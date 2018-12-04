<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/12/4
 * Time: 3:59 PM
 */

namespace backend\actions\article;


use common\models\content\ArticleModel;
use common\services\RetCode;
use yii\rest\Action;
use Yii;

class Delete extends Action
{
    public $modelClass = false;
    public function run()
    {
        $articleId = Yii::$app->request->post('articleId');
        $model = ArticleModel::findOne($articleId);
        $model->deleteFlag = 1;
        $model->save();
        return RetCode::response(RetCode::SUCCESS);
    }
}