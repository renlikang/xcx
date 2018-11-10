<?php
/**
 * @author rlk
 */
namespace console\controllers;

use common\components\Helper;
use common\models\admin\AdminModel;
use common\models\content\ArticleModel;
use common\services\backend\RoleService;
use yii\console\Controller;
use yii\helpers\Json;

class AdminController extends Controller
{
    public function actionSetAdmin($username)
    {
        $password = Helper::autoGeneratePassword($username);
        $model = new AdminModel;
        $model->username = $username;
        $model->setPassword($password);
        $model->status = AdminModel::STATUS_ACTIVE;
        if($model->save()) {
            echo $password;
        }

        var_dump($model->errors);
        exit;
    }

}