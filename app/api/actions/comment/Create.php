<?php
/**
 * @author rlk
 */

namespace api\actions\comment;

use api\actions\BaseAction;
use common\models\content\ArticleComment;
use common\models\content\ArticleModel;
use common\services\BadWordService;
use common\services\RetCode;
use Yii;
use yii\web\HttpException;

class Create extends BaseAction
{
    public $modelClass = 'common\models\content\ArticleComment';
    public $scenario;
    public function run()
    {
        $articleId = Yii::$app->request->post('articleId');
        if(!ArticleModel::findOne($articleId)) {
            throw new HttpException("400", "文章不存在");
        }

        $parentId = Yii::$app->request->post('parentId');
        if($parentId && !ArticleComment::findOne($parentId)) {
            throw new HttpException("400", "您回复的评论不存在");
        }

//        if(YII_ENV != "prod" && Yii::$app->user->isGuest == true) {
//            $uid = 2;
//        } else {
//            $uid = Yii::$app->user->id;
//        }

        $uid = Yii::$app->user->id;
        $content = Yii::$app->request->post('content');
        BadWordService::validate($content);
        $model = new ArticleComment;
        $model->articleId = $articleId;
        $model->parentId = $parentId;
        $model->content = $content;
        $model->uid = $uid;
        if(!$model->save()) {
            Yii::error($model->errors, __CLASS__.'::'.__FUNCTION__);
            throw new HttpException("400", "数据保存失败");
        }

        return RetCode::response(200);
    }
}