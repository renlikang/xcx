<?php
/**
 * @author rlk
 */

namespace api\controllers;

use yii\rest\ActiveController;

/**
 * @SWG\Get(
 *     path="/comment/{articleId}",
 *     tags={"评论管理"},
 *     summary="文章评论列表",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *      @SWG\Parameter(in = "path",name = "articleId",description = "文章Id",required = true, type = "integer"),
 *     @SWG\Parameter(in = "query",name = "page",description = "页数",required = true, type = "integer"),
 *     @SWG\Parameter(in = "query",name = "size",description = "每页个数",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 *
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
        unset($actions['create'], $actions['update']);
        return $actions;
    }
}