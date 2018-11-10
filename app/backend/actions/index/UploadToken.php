<?php
/**
 * @author rlk
 */

namespace backend\actions\index;

use backend\actions\BaseAction;
use common\components\OSS;
use Yii;

class UploadToken extends BaseAction
{
    /**
     * @SWG\Get(
     *     path="/index/upload-token",
     *     tags={"基础功能"},
     *     summary="上传token",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Response(response = 200,description = " success"),
     * )
     *
     */
    public function run()
    {
        /** @var OSS $oss */
        $oss = Yii::$app->oss;
        return ['code' => 200, 'message' => 'success', 'data' => ['token' => $oss->getUpToken()]];
    }
}