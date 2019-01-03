<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/10
 * Time: 11:58 PM
 */

namespace common\services;

use app\models\content\TagMapModel;
use app\models\content\TagModel;
use common\models\content\ArticleModel;
use common\services\RetCode;
use Yii;
use yii\data\Pagination;
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
        /** @var ArticleModel[] $commentModel */
        $data = $list->offset($offset)->limit($pages->pageSize)->all();
        $ret = [];
        $ret['list'] = $data;
        $ret['page'] = $page;
        $ret['size'] = $size;
        $ret['total'] = $total;
        return $ret;
    }

    /**
     * 详情
     *
     * @param $articleId
     * @return ArticleModel|null
     */
    public function detail($articleId)
    {
        return ArticleModel::findOne($articleId);
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