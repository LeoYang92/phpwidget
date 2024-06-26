<?php
/*
 * @Author: error: git config user.name & please set dead value or install git
 * @Date: 2024-05-10 10:56:36
 * @LastEditors: error: git config user.name & please set dead value or install git
 * @LastEditTime: 2024-05-10 11:29:15
 * @Description: 
 */
namespace Kuyuan\Phpwidget\RemoteAttachment;
use Qcloud\Cos\Client;

class TX extends RemoteAttachment
{
    // 云存储对象
    private $cosClient = null;
    public function __construct(array $_setting)
    {
//        $secretId = "SECRETID"; //"云 API 密钥 SecretId";
//        $secretKey = "SECRETKEY"; //"云 API 密钥 SecretKey";
//        $region = "COS_REGION"; //设置一个默认的存储桶地域
//        $cosClient = new Qcloud\Cos\Client(
//            array(
//                'region' => $region,
//                'schema' => 'https', //协议头部，默认为http
//                'credentials'=> array(
//                    'secretId'  => $secretId ,
//                    'secretKey' => $secretKey)));
        $this->_setting = array_merge(
            $_setting,
            [
                'schema' => ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https' : 'http'
            ]
        );
        $this->cosClient = new Client($this->_setting);
    }

    /**
     * @inheritDoc
     */
    public function push($_path, $_remote_path)
    {
        try {
            $file = fopen($_path, "rb");
            if ($file) {
                $this->cosClient->putObject(array(
                    'Bucket' => $this->_setting['bucket'],
                    'Key' => $_remote_path,
                    'Body' => $file));
                return true;
            }
        } catch (\Exception $e) {
           return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function remove($_remote_path)
    {
        try {
            $_result = $this->cosClient->deleteObject(array(
                'Bucket' => $this->_setting['bucket'],
                'Key' => $_remote_path
            ));
            // 请求成功
            return true;
        } catch (\Exception $e) {
            // 请求失败
            return false;
        }
    }

    public function pushString($_path, $_remote_path)
    {
        // TODO: Implement pushString() method.
    }

     /**
     * 返回私有文件访问链接
     * @param $_remote_path 远程文件路径
     * @param $expires 访问链接的有效时长  
     */  
    public function privateUrl($_remote_path, $expires = 3600)
    {
        
    }

}