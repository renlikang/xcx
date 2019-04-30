<?php
/**
 * @author rlk
 */

namespace api\controllers;

use yii\rest\Controller;

/**
 * @SWG\Get(
 *     path="/my/read-list",
 *     tags={"个人中心"},
 *     summary="阅读历史列表",
 *     description="",
 *     produces={"application/json"},
 *     consumes = {"application/json"},
 *     @SWG\Parameter(in = "header",name = "Authorization",description = "用户Token",required = false, type = "string"),
 *     @SWG\Parameter(in = "query",name = "page",description = "页数",required = true, type = "integer"),
 *     @SWG\Parameter(in = "query",name = "size",description = "每页个数",required = true, type = "integer"),
 *     @SWG\Response(response = 200,description = " success"),
 * )
 *
 *
 */
class MyController extends Controller
{
    public function actions()
    {
        return [
            'img' => 'api\actions\my\Img',
            'read-list' => 'api\actions\my\ReadList'
        ];
    }
}