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
use yii\base\Model;

class Create extends BaseAction
{
    public $modelClass;
    public $scenario = Model::SCENARIO_DEFAULT;

    public function run()
    {
        $id = Yii::$app->request->post('id');
        $type = Yii::$app->request->post('type');
        $uid = Yii::$app->user->id;
        if($type == 'article') {
            if(!ArticlePraiseModel::findOne($id) && ArticleModel::findOne($id)) {
                $model = new ArticlePraiseModel;
                $model->articleId = $id;
                $model->uid = $uid;
                $model->save();
            }
        } else if($type == 'comment' && !CommentPraiseModel::findOne($id) && ArticleComment::findOne($id)) {
            $model = new CommentPraiseModel;
            $model->commentId = $id;
            $model->uid = $uid;
            $model->save();
        }

        return RetCode::response(RetCode::SUCCESS);
    }
}