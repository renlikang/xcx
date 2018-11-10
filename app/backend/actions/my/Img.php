<?php
/**
 * @author rlk
 */
namespace backend\actions\my;

use api\actions\BaseAction;
use common\models\UserRecord;
use Yii;

class Img extends BaseAction
{
    public function run()
    {
        if(Yii::$app->user->isGuest) {
            return ['code' => 500, 'message' => '请登录'];
        }

        $address = Yii::$app->request->post('address');
        $memo = Yii::$app->request->post('memo');
        $imgUrl = Yii::$app->request->post('imgUrl');
        $title = Yii::$app->request->post('title') ?? '';
        $model = new UserRecord;
        $model->uid = Yii::$app->user->id;
        $model->address = $address;
        $model->memo = $memo;
        $model->imgUrl = $imgUrl;
        $model->title = $title;
        $model->save();
        return ['code' => 200, 'message' => 'success'];
    }
}