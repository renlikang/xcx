<?php
/**
 * @author rlk
 */

namespace backend\actions\index;

use backend\actions\BaseAction;
use common\components\OSS;
use Yii;

class UploadUrl extends BaseAction
{
    public function run()
    {
        /** @var OSS $oss */
        $oss = Yii::$app->oss;
        $url = Yii::$app->request->post('url');
        $file = $oss->uploadUrlImage($url);
        if($file === false) {
            return ['code' => 100, 'message' => '上传失败请重新上传'];
        }

        return ['code' => 200, 'message' => 'success', 'data' => ['url' => Yii::$app->params['staticUrl'].'/'.$file['key']]];
    }
}