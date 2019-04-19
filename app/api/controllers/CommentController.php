<?php
/**
 * @author rlk
 */

namespace api\controllers;

use yii\rest\ActiveController;

/**
 * @SWG\Get(
 *     path="/comment",
 *     tags={"评论管理"},
 *     summary="文章评论列表",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *      @SWG\Parameter(in = "query",name = "articleId",description = "文章Id",required = true, type = "integer"),
 *     @SWG\Parameter(in = "query",name = "page",description = "页数",required = true, type = "integer"),
 *     @SWG\Parameter(in = "query",name = "size",description = "每页个数",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 * @SWG\Post(
 *     path="/comment",
 *     tags={"评论管理"},
 *     summary="文章评论",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "formData",name = "articleId",description = "文章Id",required = true, type = "integer"),
 *     @SWG\Parameter(in = "formData",name = "parentId",description = "评论为0 回复为commentId",required = true, type = "integer"),
 *     @SWG\Parameter(in = "formData",name = "content",description = "评论/回复内容",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 */
class CommentController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'common\models\content\ArticleComment';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class'] = 'api\actions\comment\Index';
        $actions['create']['class'] = 'api\actions\comment\Create';
        $actions['create']['modelClass'] = $this->modelClass;
        $actions['create']['checkAccess'] = "";
        $actions['create']['scenario'] = $this->createScenario;
        unset($actions['update']);
        return $actions;
    }
}