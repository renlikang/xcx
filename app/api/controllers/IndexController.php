<?php
/**
 * @author rlk
 */

namespace api\controllers;


use yii\rest\Controller;

class IndexController extends Controller
{
    public function actions()
    {
        return [
            'index' => 'api\actions\index\Index',
            'upload' => 'api\actions\index\Upload',
            'upload-url' => 'api\actions\index\UploadUrl',
        ];
    }

}