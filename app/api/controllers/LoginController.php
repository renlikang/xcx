<?php
/**
 * @author rlk
 */

namespace api\controllers;

use yii\rest\Controller;

class LoginController extends Controller
{
    public function actions()
    {
        return [
            'wx' => 'api\actions\login\Login',
        ];
    }
}