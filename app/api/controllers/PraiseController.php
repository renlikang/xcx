<?php
/**
 * @author rlk
 */

namespace api\controllers;


use yii\rest\ActiveController;

/**
 * @SWG\Get(
 *     path="/praise",
 *     tags={"点赞管理"},
 *     summary="点赞列表",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
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
    /**
     * @var string
     */
    //public $modelClass = 'common\models\content\ArticlePraise';

    /**
     * @var string
     */
    public $modelClass = 'common\models\content\ArticleComment';

    public function actions()
    {
        $actions = parent::actions();
        $actions['index']['class'] = 'api\actions\comment\Index';
        $actions['create']['class'] = 'api\actions\comment\Create';
        unset($actions['update']);
        return $actions;
    }
}