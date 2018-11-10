<?php
/**
 * @author rlk
 */

namespace backend\controllers;

use yii\rest\Controller;

class MyController extends Controller
{
    public function actions()
    {
        return [
            'img' => 'api\actions\my\Img',
        ];
    }
}