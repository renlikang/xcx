<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/16
 * Time: 11:22 AM
 */

namespace api\actions\article;

use api\actions\BaseAction;
use common\service\ArticleService;
use common\services\RetCode;
use Yii;

class Detail extends BaseAction
{
    public function run()
    {
        $articleId = Yii::$app->request->get('articleId');
        return RetCode::response(RetCode::SUCCESS, (new ArticleService)->detail($articleId));
    }
}