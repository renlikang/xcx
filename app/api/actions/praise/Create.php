<?php
/**
 * @author rlk
 */

namespace api\actions\praise;


use api\actions\BaseAction;
use common\models\content\ArticleComment;
use common\models\content\ArticleModel;
use common\models\content\ArticlePraiseModel;
use common\models\content\CommentPraiseModel;
use common\services\RetCode;
use Yii;

class Create extends BaseAction
{
    public $modelClass = false;
    public $scenario;

    public function run()
    {
        $id = Yii::$app->request->post('id');
        $type = Yii::$app->request->post('type');
        if($type == 'article') {
            if(!ArticlePraiseModel::findOne($id) && ArticleModel::findOne($id)) {
                $model = new ArticlePraiseModel;
                $model->articleId = $id;
                $model->uid = Yii::$app->user->id;
                $model->save();
            }
        } else if($type == 'comment' && !CommentPraiseModel::findOne($id) && ArticleComment::findOne($id)) {
            $model = new CommentPraiseModel;
            $model->commentId = $id;
            $model->uid = Yii::$app->user->id;
            $model->save();
        }

        return RetCode::response(RetCode::SUCCESS);
    }
}