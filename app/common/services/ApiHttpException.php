<?php
/**
 * Created by PhpStorm.
 * User: renlikang
 * Date: 2018/11/16
 * Time: 10:28 AM
 */

namespace common\service;


use common\services\RetCode;
use yii\web\HttpException;

class ApiHttpException extends HttpException
{
    public function __construct($code, \Exception $previous = null)
    {
        $message = RetCode::$responseMsg[$code];
        parent::__construct($code, $message, $code, $previous);
    }
}