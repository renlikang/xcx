<?php
/**
 * @author rlk
 */
namespace api\actions\my;

use api\actions\BaseAction;
use common\models\UserRecord;
use Yii;

class Img extends BaseAction
{
    /**
     * @SWG\Post(
     *     path="/my/img",
     *     tags={"我的照片功能"},
     *     summary="冲洗照片接口",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Parameter(in = "formData",name = "address",description = "地址",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "memo",description = "描述",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "imgUrl",description = "图片地址",required = true,type = "string"),
     *     @SWG\Parameter(in = "formData",name = "title",description = "标题（预留字段, 可不传）",required = false,type = "string"),
     *     @SWG\Response(response = 200,description = " success"),
     *     @SWG\Response(response = 500,description = " 请登录"),
     * )
     *
     */
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