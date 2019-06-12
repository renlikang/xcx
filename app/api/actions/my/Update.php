<?php
/**
 * @author rlk
 */

namespace api\actions\my;


use api\actions\BaseAction;
use common\models\UserModel;
use common\services\RetCode;
use Yii;

class Update extends BaseAction
{
    public function run()
    {
        $uid = Yii::$app->user->id;
        $nickName  = Yii::$app->request->post('nickName') ?? null;
        $avatarUrl = Yii::$app->request->post('avatarUrl') ?? null;
        $model = UserModel::findOne($uid);
        if(!$nickName && !$avatarUrl) {
            return RetCode::response(200);
        }

        if($nickName) {
            $model->nickName = $nickName;
        }

        if($avatarUrl) {
            $model->avatarUrl = $avatarUrl;
        }

        $model->save();
        return RetCode::response(200);
    }
}