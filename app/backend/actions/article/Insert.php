<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/10
 * Time: 11:56 PM
 */

namespace  backend\actions\article;

use backend\actions\BaseAction;
use common\services\ArticleService;
use common\services\RetCode;
use Yii;

class Insert extends BaseAction
{
    public $type;

    public function run()
    {
        $authorId = Yii::$app->request->post('authorId');
        $source = Yii::$app->request->post('source');
        $title = Yii::$app->request->post('title');
        $subTitle = Yii::$app->request->post('subTitle');
        $summary = Yii::$app->request->post('summary');
        $headImg = Yii::$app->request->post('headImg');
        $content = Yii::$app->request->post('content');
        $orderId = Yii::$app->request->post('orderId');
        if($this->type == 'update') {
            $articleId = Yii::$app->request->post('articleId');
            (new ArticleService)->update($articleId, $authorId, $source, $title, $subTitle, $summary, $headImg, $content, $orderId);

        } else {
            (new ArticleService)->create($authorId, 'PGC', $source, $title, $subTitle, $summary, $headImg, $content, $orderId);
        }

        return RetCode::response(RetCode::SUCCESS);

    }
}