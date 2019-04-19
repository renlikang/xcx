<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/10
 * Time: 11:56 PM
 */

namespace  backend\actions\article;

use backend\actions\BaseAction;
use common\models\content\ArticleModel;
use common\services\ArticleService;
use common\services\RetCode;
use Yii;
use yii\helpers\Json;

class Insert extends BaseAction
{
    public $type;

    public function run()
    {
        $authorId = Yii::$app->request->post('authorId') ?? 0;
        $source = Yii::$app->request->post('source');
        $title = Yii::$app->request->post('title');
        $subTitle = Yii::$app->request->post('subTitle');
        $summary = Yii::$app->request->post('summary');
        $headImg = Yii::$app->request->post('headImg') ?? '';
        $endImg = Yii::$app->request->post('endImg') ?? '';
        $content = Yii::$app->request->post('content');
        $orderId = Yii::$app->request->post('orderId');
        $tagName = Yii::$app->request->post('tagName') ?? [];
        if($content) {
            $content = Json::decode($content, true);
        }

        if($this->type == 'update') {
            $articleId = Yii::$app->request->post('articleId');
            $ret = (new ArticleService)->update($articleId, $authorId, $tagName, $source, $title, $subTitle, $summary, $headImg, $endImg, $content, $orderId);

        } else {
            $ret = (new ArticleService)->create($authorId, $tagName, ArticleModel::PGC, $source, $title, $subTitle, $summary, $headImg, $endImg, $content, $orderId);
        }

        return RetCode::response(RetCode::SUCCESS, $ret);

    }
}