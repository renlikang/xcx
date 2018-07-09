<?php
/**
 * @author rlk
 */

namespace common\components;

use yii\base\Component;
use Yii;
use yii\helpers\Json;
use yii\redis\Connection;

class Redis extends Component
{
    public $hostname;
    public $port;
    public $database;
    public $socketClientFlags;
    public $redis;
    public $password;

    public function init()
    {
        if($this->password) {
            $this->redis = Yii::createObject([
                'class' => 'yii\redis\Connection',
                'hostname' => $this->hostname,
                'port' => $this->port,
                'database' => $this->database,
                'socketClientFlags' => $this->socketClientFlags,
                'password' => $this->password,

            ]);
        } else {
            $this->redis = Yii::createObject([
                'class' => 'yii\redis\Connection',
                'hostname' => $this->hostname,
                'port' => $this->port,
                'database' => $this->database,
                'socketClientFlags' => $this->socketClientFlags,

            ]);
        }
    }

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'set':
                $arguments[1] = Json::encode($arguments[1]);
                break;
            case 'hset':
                $arguments[2] = Json::encode($arguments[2]);
                break;
            default:
                break;

        }

        if(isset($arguments) && sizeof($arguments)) {
            $ret = call_user_func_array([$this->redis, $name], $arguments);
        }else if(isset($arguments) && sizeof($arguments) == 1){
            $ret = $this->redis->$name($arguments[0]);
        } else {
            $ret = $this->redis->$name();
        }

        switch ($name) {
            case 'get':
                return Json::decode($ret, true);
            case 'hget':
                return Json::decode($ret, true);
            case 'exists':
                return $ret == 1 ? true : false;
            case 'hexists':
                return $ret == 1 ? true : false;
            default:
                return $ret;

        }
    }
}