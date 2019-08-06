<?php
/**
 * @author rlk
 */

namespace api\actions\article;

use api\actions\BaseAction;
use common\models\content\ArticleModel;
use common\services\ArticleService;
use common\services\BadWordService;
use common\services\RetCode;
use Yii;
use yii\helpers\Json;

class Create extends BaseAction
{
    public $type;
    public function run()
    {
        $authorId = Yii::$app->user->id;
        $source = "个人";
        $title = Yii::$app->request->post('title');
        $subTitle = Yii::$app->request->post('subTitle') ?? '';
        $summary = Yii::$app->request->post('summary');
        $headImg = Yii::$app->request->post('headImg') ?? '';
        $endImg = Yii::$app->request->post('endImg') ?? '';
        $content = Yii::$app->request->post('content');
        $orderId = Yii::$app->request->post('orderId') ?? 10;
        $tagName = Yii::$app->request->post('tagName') ?? [];
        if($content) {
            $content = Json::decode($content, true);
        }

        if($title) {
            BadWordService::validate($title);
        }

        if($subTitle) {
            BadWordService::validate($subTitle);
        }

        if($summary) {
            BadWordService::validate($summary);
        }

        if($content) {
            if(is_array($content)) {
                foreach ($content as $k => $v) {
                    BadWordService::validate($v);
                }
            } else {
                BadWordService::validate($content);
            }

        }

        if($this->type == 'update') {
            $articleId = Yii::$app->request->post('articleId');
            $ret = (new ArticleService)->update($articleId, $authorId, $tagName, $source, $title, $subTitle, $summary, $headImg, $endImg, $content, $orderId);

        } else {
            $ret = (new ArticleService())->create($authorId, $tagName, ArticleModel::UGC, $source, $title, $subTitle, $summary, $headImg, $endImg, $content, $orderId);
        }

        return RetCode::response(RetCode::SUCCESS, $ret);
    }
}