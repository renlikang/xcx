<?php
/**
 * @author rlk
 */

namespace common\components;

use yii\base\Component;

class UtilLib extends Component
{
    public static function getUserHostIp()
    {
        if (!isset($_SERVER['REMOTE_ADDR']) || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' ||
            self::isLAN($_SERVER['REMOTE_ADDR'])
        )
        {
            if (!empty($_SERVER["HTTP_X_REAL_IP"]))
            {
                $_SERVER["REMOTE_ADDR"] = $_SERVER["HTTP_X_REAL_IP"];
            }
        }
        return $_SERVER["REMOTE_ADDR"] ?? '';
    }

    public static function isLAN($ip)
    {
        $ip = ip2long($ip);
        $net_a = ip2long('10.0.0.0') >> 24; //A类网预留ip的网络地址 10.0.0.0 ～ 10.255.255.255
        $net_b = ip2long('172.16.0.0') >> 20; //B类网预留ip的网络地址 172.16.0.0 ～ 172.31.255.255
        $net_c = ip2long('192.168.0.0') >> 16; //C类网预留ip的网络地址 192.168.0.0 ～ 192.168.255.255
        return $ip >> 24 === $net_a || $ip >> 20 === $net_b || $ip >> 16 === $net_c;
    }
}