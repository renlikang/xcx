<?php
/**
 * @author rlk
 */

namespace api\actions\comment;

use api\actions\BaseAction;
use common\services\ArticleService;
use common\services\RetCode;
use Yii;

class Index extends BaseAction
{
    public function run()
    {
        $articleId = Yii::$app->request->get('articleId');
        $page = Yii::$app->request->get('page');
        $size = Yii::$app->request->get('size');
        return RetCode::response(RetCode::SUCCESS, (new ArticleService())->commentList($articleId, $page, $size));
    }
}