<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/16
 * Time: 11:20 AM
 */

namespace api\actions\article;

use api\actions\BaseAction;
use common\service\ArticleService;
use common\services\RetCode;
use Yii;

class ArticleList extends BaseAction
{
    public function run()
    {
        $page = Yii::$app->request->get('page');
        $size = Yii::$app->request->get('size');
        return RetCode::response(RetCode::SUCCESS, (new ArticleService)->articleList($page, $size));
    }
}