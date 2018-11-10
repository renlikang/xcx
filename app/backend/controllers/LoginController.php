<?php
/**
 * @author rlk
 */

namespace backend\controllers;

use yii\rest\Controller;

class LoginController extends Controller
{
    public function actions()
    {
        return [
            'login' => 'backend\actions\login\Login',
        ];
    }
}