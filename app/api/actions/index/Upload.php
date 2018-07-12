<?php
/**
 * @author rlk
 */

namespace api\actions\index;


use api\actions\BaseAction;
use common\components\OSS;
use Yii;

class Upload extends BaseAction
{
    /**
     * @SWG\Post(
     *     path="/index/upload",
     *     tags={"基础功能"},
     *     summary="上传接口",
     *     description="",
     *     produces={"application/json"},
     *     @SWG\Parameter(in = "formData",name = "file",description = "文件",required = true,type = "file"),
     *     @SWG\Response(response = 200,description = " success"),
     *     @SWG\Response(response = 100,description = " 上传失败请重新上传"),
     * )
     *
     */
    public function run()
    {
        /** @var OSS $oss */
        $oss = Yii::$app->oss;
        $file = $oss->upload();
        if($file === false) {
            return ['code' => 100, 'message' => '上传失败请重新上传'];
        }

        return ['code' => 200, 'message' => 'success', 'data' => ['url' => Yii::$app->params['staticUrl'].'/'.$file['key']]];
    }
}