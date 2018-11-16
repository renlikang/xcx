<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/16
 * Time: 11:26 AM
 */

namespace api\controllers;

use yii\rest\Controller;

/**
 * @SWG\Get(
 *     path="/article/list",
 *     tags={"文章管理"},
 *     summary="文章列表",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "query",name = "page",description = "页数",required = true, type = "integer"),
 *     @SWG\Parameter(in = "query",name = "size",description = "每页个数",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 *     @SWG\Response(response = 10003,description = "保存失败"),
 * )
 *
 * @SWG\Get(
 *     path="/article/detail",
 *     tags={"文章管理"},
 *     summary="文章详情",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "query",name = "articleId",description = "文章编号",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 *     @SWG\Response(response = 10003,description = "保存失败"),
 * )
 *
 *
 */
class ArticleController extends Controller
{
    public function actions()
    {
        return [
            'list' => [
                'class' => 'api\actions\article\ArticleList',
            ],

            'detail' => [
                'class' => 'api\actions\article\Detail',
            ],
        ];
    }
}