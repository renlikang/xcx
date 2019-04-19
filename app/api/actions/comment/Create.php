<?php
/**
 * @author rlk
 */

namespace api\actions\comment;

use api\actions\BaseAction;
use common\models\content\ArticleComment;
use common\services\RetCode;
use Yii;
use yii\web\HttpException;

class Create extends BaseAction
{
    public function run()
    {
        $articleId = Yii::$app->request->post('articleId');
        $parentId = Yii::$app->request->post('parentId');
        if(YII_ENV != "prod" && Yii::$app->user->isGuest == true) {
            $uid = 2;
        } else {
            $uid = Yii::$app->user->id;
        }

        $content = Yii::$app->request->post('content');
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