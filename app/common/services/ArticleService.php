<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/10
 * Time: 11:58 PM
 */

namespace common\services;

use common\models\content\ArticleComment;
use common\models\content\CommentPraiseModel;
use common\models\content\TagMapModel;
use common\models\content\TagModel;
use common\models\content\ArticleModel;
use common\models\content\UserReadLastModel;
use common\models\content\UserReadRecordModel;
use common\services\RetCode;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;

class ArticleService
{
    /**
     * 新增文章
     *
     * @param $authorId
     * @param  $arrTagName
     * @param $type
     * @param $source
     * @param $title
     * @param $subTitle
     * @param $summary
     * @param $headImg
     * @param $content
     * @param $orderId
     * @return bool
     * @throws HttpException
     */
    public function create($authorId, $arrTagName, $type, $source, $title, $subTitle, $summary, $headImg, $endImg, $content, $orderId)
    {
        $model = new ArticleModel;
        $model->authorId = $authorId;
        $model->type = $type;
        $model->source = $source;
        $model->title = $title;
        $model->subTitle = $subTitle;
        $model->summary = $summary;
        $model->headImg = $headImg;
        $model->endImg = $endImg;
        $model->content = $content;
        $model->orderId = $orderId;
        if(!$model->save()){
            Yii::error($model->errors, __CLASS__.'::'.__FUNCTION__);
            throw new HttpException(RetCode::DB_ERROR, RetCode::$responseMsg[RetCode::DB_ERROR], RetCode::DB_ERROR);
        }

        foreach ($arrTagName as $k => $tagName) {
            $md5 = md5($tagName);
            $this->insertTag($tagName);
            $this->mapTag($md5, $model->articleId);
        }

        return ArticleModel::findOne($model->articleId);
    }

    /**
     * 更新文章
     *
     * @param $articleId
     * @param $authorId
     * @param $arrTagName
     * @param $source
     * @param $title
     * @param $subTitle
     * @param $summary
     * @param $headImg
     * @param $content
     * @param $orderId
     * @return bool
     * @throws HttpException
     */
    public function update($articleId, $authorId, $arrTagName, $source, $title, $subTitle, $summary, $headImg, $endImg, $content, $orderId)
    {
        $model = ArticleModel::findOne($articleId);
        $model->authorId = $authorId;
        $model->source = $source;
        $model->title = $title;
        $model->subTitle = $subTitle;
        $model->summary = $summary;
        $model->headImg = $headImg;
        $model->endImg = $endImg;
        $model->content = $content;
        $model->orderId = $orderId;
        if(!$model->save()){
            Yii::error($model->errors, __CLASS__.'::'.__FUNCTION__);
            throw new HttpException(RetCode::DB_ERROR, RetCode::$responseMsg[RetCode::DB_ERROR], RetCode::DB_ERROR);
        }

        TagMapModel::deleteAll(['mapId' => $articleId]);
        foreach ($arrTagName as $k => $tagName) {
            $md5 = md5($tagName);
            $this->insertTag($tagName);
            $this->mapTag($md5, $model->articleId);
        }

        return ArticleModel::findOne($articleId);
    }

    /**
     * 文章列表
     *
     * @param $page
     * @param $size
     * @return array
     */
    public function articleList($page, $size)
    {
        $list = ArticleModel::find()->where(['deleteFlag' => 0]);
        $list->orderBy('orderId desc, cTime desc');
        $modelClone = clone $list;
        $total = (int)$modelClone->count();
        $pages = new Pagination(['totalCount' => $total, 'pageSize' => $size]);
        $pages->setPage($page - 1);
        $offset = $pages->offset;
        /** @var ArticleModel[] $data */
        $data = $list->offset($offset)->limit($pages->pageSize)->all();
        foreach ($data as $k => $v) {
            $data[$k] = $v->toArray();
            $data[$k]['tag'] = null;
            $md5Tag = TagMapModel::find()->where(['mapId' => $v->articleId])->all();
            if($md5Tag) {
                $md5Tag = ArrayHelper::getColumn($md5Tag, 'md5TagName');
                $data[$k]['tag'] = TagMapModel::find()->where(['md5TagName' => $md5Tag])->all();
            }
        }

        $ret = [];
        $ret['list'] = $data;
        $ret['page'] = $page;
        $ret['size'] = $size;
        $ret['total'] = $total;
        return $ret;
    }


    public function articleShow($uid)
    {
        if(!Yii::$app->cache->exists(date("Y-m-d"))) {
            Yii::$app->cache->set(date('Y-m-d'), 1);
            /** @var ArticleModel[] $articleAll */
            $articleAll = ArticleModel::find()->andWhere(['<' , 'cTime', date('Y-m-d', time() - 7 * 3600 * 24)])->all();
            foreach ($articleAll as $k => $v) {
                $sameTag = TagMapModel::findOne(['md5TagName' => md5('时事类'), 'mapId' => $v->articleId]);
                if($sameTag) {
                    $v->deleteFlag = 1;
                    $v->save();
                }
            }
        }

        $list = ArticleModel::find()->where(['deleteFlag' => 0]);
        $read = UserReadRecordModel::find()->where(['uid' => $uid])->andWhere(['or', ['status' => 2] , ['and', 'status = 1', 'nums = 2']])->all();
        if($read && YII_ENV == 'prod') {
            $read = ArrayHelper::getColumn($read, 'articleId');
            $list->andWhere(['not in', 'articleId', $read]);
        }

        $model = UserReadLastModel::findOne($uid);
        if($model && YII_ENV == 'prod') {
            if($model->preArticleType == $model->articleType) {
                $tagArr = TagMapModel::find()->where(['md5TagName' => $model->articleType])->all();
                if($tagArr) {
                    $tagArr = ArrayHelper::getColumn($tagArr, 'mapId');
                    $list->andWhere(['not in', 'articleId', $tagArr]);
                }
            }
        }

        $list->orderBy('cTime desc')->limit(20);
        $clone = clone $list;
        $count = $clone->count();
        $data = $list->all();
        if(!$data)  {
            return null;
        }

        if($count > 20) {
            $num = rand(0, 19);
        } else {
            $num = rand(0, $count - 1);
        }

        /** @var ArticleModel $model */
        $model = $data[$num];
        $read = UserReadRecordModel::findOne(['uid' => $uid, 'articleId' => $model->articleId]);
        if(!$read) {
            $read = new UserReadRecordModel;
            $read->uid = $uid;
            $read->articleId = $model->articleId;
            $read->nums = 1;
        } else {
            $read->nums = $read->nums + 1;
        }

        $read->save();
        $last = UserReadLastModel::findOne($uid);
        $tag = TagMapModel::findOne(['mapId' => $model->articleId]);
        if(!$last) {
            $last = new UserReadLastModel;
            $last->uid = $uid;
            $last->preArticleType = '';
            $last->preArticleType = '';
            $last->articleType = '';
            if($tag) {
                $last->articleType = $tag->md5TagName;
            }
        } else {
            $last->preArticleType = $last->articleType;
            $last->articleType = '';
            if($tag) {
                $last->articleType = $tag->md5TagName;
            }
        }

        $last->save();
        $model = $model->toArray();
        $md5Tag = TagMapModel::find()->where(['mapId' => $model['articleId']])->all();
        $model['tag'] = null;
        if($md5Tag) {
            $md5Tag = ArrayHelper::getColumn($md5Tag, 'md5TagName');
            $model['tag'] = TagMapModel::find()->where(['md5TagName' => $md5Tag])->all();
        }


        return $model;
    }

    public function commentList($articleId, $page, $size)
    {
        $ret = [];
        $model = ArticleComment::find();
        $model->where(['articleId' => $articleId]);
        $model->orderBy('commentId desc');
        $modelClone = clone $model;
        $total = (int)$modelClone->count();
        $pages = new Pagination(['totalCount' => $total, 'pageSize' => $size]);
        $pages->setPage($page - 1);
        $offset = $pages->offset;
        /** @var ArticleComment[] $commentModel */
        $commentModel = $model->offset($offset)->limit($pages->pageSize)->all();
        foreach ($commentModel as $k => $v) {
            $ret[$k] = $v->toArray();
            if((int)$v->parentId > 0) {
                $ret[$k]['replayComment'] = ArticleComment::findOne($v->parentId)->toArray();
                $replayCommentCount = CommentPraiseModel::find()->where(['commentId' => $v->parentId])->count();
                $ret[$k]['replayComment']['commentCount'] = intval($replayCommentCount);
                $ret[$k]['replayComment']['isPraise'] = 0;
                if(Yii::$app->user->isGuest == false && CommentPraiseModel::find()->where(['commentId' => $v->parentId, 'uid' => Yii::$app->user->id])->exists()) {
                    $ret[$k]['replayComment']['isPraise'] = 1;
                }
            } else {
                $ret[$k]['replayComment'] = null;
            }

            $commentCount = CommentPraiseModel::find()->where(['commentId' => $v->commentId])->count();
            $ret[$k]['commentCount'] = intval($commentCount);
            $ret[$k]['isPraise'] = 0;
            if(Yii::$app->user->isGuest == false && CommentPraiseModel::find()->where(['commentId' => $v->commentId, 'uid' => Yii::$app->user->id])->exists()) {
                $ret[$k]['isPraise'] = 1;
            }
        }

        return ['list' =>$ret, 'page' => $page, 'size' => $size, 'total' => $total];
    }



    /**
     * 详情
     *
     * @param $articleId
     * @return array|null
     */
    public function detail($articleId)
    {
        $model = ArticleModel::findOne($articleId)->toArray();
        $md5Tag = TagMapModel::find()->where(['mapId' => $articleId])->all();
        $model['tag'] = null;
        if($md5Tag) {
            $md5Tag = ArrayHelper::getColumn($md5Tag, 'md5TagName');
            $model['tag'] = TagMapModel::find()->where(['md5TagName' => $md5Tag])->all();
        }

        return $model;
    }

    public function insertTag($tagName)
    {
        $md5 = md5($tagName);
        $model = TagModel::findOne($md5);
        if(!$model) {
            $model = new TagModel;
            $model->md5TagName = $md5;
            $model->tagName = $tagName;
            $model->save();
        }
    }

    /**
     * tag映射文章
     *
     * @param $md5
     * @param $articleId
     */
    public function mapTag($md5, $articleId)
    {
        $map = new TagMapModel;
        $map->md5TagName = $md5;
        $map->mapId = $articleId;
        $map->save();
    }
}