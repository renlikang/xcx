<?php
/**
 * @author rlk
 */

namespace api\controllers;


use yii\rest\ActiveController;

/**
 * @SWG\Post(
 *     path="/praise",
 *     tags={"点赞管理"},
 *     summary="对文章/评论点赞",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "formData",name = "id",description = "文章/评论Id",required = true, type = "integer"),
 *     @SWG\Parameter(in = "formData",name = "type",description = "文章为 article 评论为 comment",required = true, type = "string"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 */
class PraiseController extends ActiveController
{
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }

    /**
     * @var string
     */
    public $modelClass = 'common\models\content\ArticlePraise';

    public function actions()
    {
        $actions = parent::actions();
        $actions['create'] = [
            'class' => 'api\actions\praise\Create',
            'modelClass' => $this->modelClass,
            'checkAccess' => [$this, 'checkAccess'],
            'scenario' => $this->createScenario,
        ];
        unset($actions['index']);
        return $actions;
    }
}