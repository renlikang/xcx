<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/10
 * Time: 11:55 PM
 */

namespace backend\controllers;

use yii\rest\Controller;

/**
 * @SWG\Post(
 *     path="/article/insert",
 *     tags={"文章管理"},
 *     summary="新增文章",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "formData",name = "authorId",description = "作者编号",required = false, type = "integer"),
 *     @SWG\Parameter(in = "formData",name = "tagName[]",description = "文章标签",required = false, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "source",description = "文章来源",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "title",description = "文章标题",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "subTitle",description = "副标题",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "summary",description = "摘要",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "headImg",description = "封面图片地址",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "endImg",description = "尾图地址",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "content",description = "文章内容",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "orderId",description = "权重",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 * @SWG\Post(
 *     path="/article/update",
 *     tags={"文章管理"},
 *     summary="更新文章",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "formData",name = "articleId",description = "文章编号",required = true, type = "integer"),
 *     @SWG\Parameter(in = "formData",name = "tagName[]",description = "文章标签",required = false, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "authorId",description = "作者编号",required = false, type = "integer"),
 *     @SWG\Parameter(in = "formData",name = "source",description = "文章来源",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "title",description = "文章标题",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "subTitle",description = "副标题",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "summary",description = "摘要",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "headImg",description = "封面图片地址",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "endImg",description = "尾图地址",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "content",description = "文章内容",required = true, type = "string"),
 *     @SWG\Parameter(in = "formData",name = "orderId",description = "权重",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 *
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
 * )
 *
 * @SWG\Post(
 *     path="/article/delete",
 *     tags={"文章管理"},
 *     summary="删除文章",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "formData",name = "articleId",description = "文章编号",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 *
 */
class ArticleController extends Controller
{

    public function actions()
    {
        return [
            'insert' => [
                'class' => 'backend\actions\article\Insert',
                'type' => 'insert',
            ],

            'update' => [
                'class' => 'backend\actions\article\Insert',
                'type' => 'update',
            ],

            'list' => [
                'class' => 'backend\actions\article\ArticleList',
            ],

            'detail' => [
                'class' => 'backend\actions\article\Detail',
            ],
            'delete' => [
               'class' =>  'backend\actions\article\Delete',
            ],
        ];
    }
}