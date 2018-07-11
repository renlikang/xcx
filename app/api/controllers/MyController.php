<?php
/**
 * @author rlk
 */

namespace api\controllers;

use yii\rest\Controller;

class MyController extends Controller
{
    public function actions()
    {
        return [
            'img' => 'api\actions\My\Img',
        ];
    }
}