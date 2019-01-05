<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/16
 * Time: 11:22 AM
 */

namespace api\actions\article;

use api\actions\BaseAction;
use common\models\content\UserReadRecordModel;
use common\services\ArticleService;
use common\services\RetCode;
use Yii;

class Detail extends BaseAction
{
    public function run()
    {
        $articleId = Yii::$app->request->get('articleId');
        $uid = Yii::$app->user->id;
        if($uid) {
            $read = UserReadRecordModel::findOne(['uid' => $uid, 'articleId' => $articleId]);
            if(!$read) {
                $read = new UserReadRecordModel;
                $read->uid = $uid;
                $read->articleId = $articleId;
            }

            $read->status = 2;
            $read->save();
        }

        return RetCode::response(RetCode::SUCCESS, (new ArticleService)->detail($articleId));
    }
}