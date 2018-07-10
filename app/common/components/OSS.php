<?php
/**
 * @author rlk
 */

namespace common\components;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\base\Component;
use Yii;

class OSS extends Component
{
    public $accessKey;
    public $secretKey;
    public $bucket;
    /** @var  Auth */
    private $auth;

    public function init()
    {
        $this->auth = new Auth($this->accessKey, $this->secretKey);
    }

    public function getUpToken()
    {
        return $this->auth->uploadToken($this->bucket);
    }


    public function upload()
    {
        $token = $this->getUpToken();
        $uploadManager=new UploadManager();
        $file = pathinfo($_FILES['file']['name']);
        $name = YII_ENV.'/'.date('Ymd').'/'.$file['filename'] . '_' . md5(time() . microtime()) . '.' . $file['extension'];
        $filePath=$_FILES['file']['tmp_name'];
        $type=$_FILES['file']['type'];
        list($ret,$err)=$uploadManager->putFile($token,$name,$filePath,null,$type,false);
        if($err) {
            Yii::error($err, __CLASS__.'::'.__FUNCTION__);
            return false;
        }

        return $ret;
    }


}