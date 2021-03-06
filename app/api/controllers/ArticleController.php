<?php

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
 *     @SWG\Parameter(in = "header",name = "Authorization",description = "用户Token",required = false, type = "string"),
 *     @SWG\Parameter(in = "query",name = "page",description = "页数",required = true, type = "integer"),
 *     @SWG\Parameter(in = "query",name = "size",description = "每页个数",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 * @SWG\Get(
 *     path="/article/detail",
 *     tags={"文章管理"},
 *     summary="文章详情",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "header",name = "Authorization",description = "用户Token",required = false, type = "string"),
 *     @SWG\Parameter(in = "query",name = "articleId",description = "文章编号",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 * @SWG\Post(
 *     path="/article/create",
 *     tags={"文章管理"},
 *     summary="新增文章",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "header",name = "Authorization",description = "用户Token",required = false, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "title",description = "文章标题",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "summary",description = "摘要",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "headImg",description = "封面图片地址",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "content",description = "文章内容",required = true, type = "string"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
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

            'create' => [
                'class' => 'api\actions\article\Create',
                'type' => 'create',
            ],
        ];
    }
}