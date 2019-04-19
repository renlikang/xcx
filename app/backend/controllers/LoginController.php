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
            'index' => 'backend\actions\login\Login',
            'test' => 'backend\actions\login\Test',
        ];
    }
}