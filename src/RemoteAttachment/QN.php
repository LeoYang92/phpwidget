<?php
/*
 * @Author: error: git config user.name & please set dead value or install git
 * @Date: 2024-05-10 10:56:36
 * @LastEditors: error: git config user.name & please set dead value or install git
 * @LastEditTime: 2024-05-10 11:28:55
 * @Description: 
 */
namespace Kuyuan\Phpwidget\RemoteAttachment;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class QN extends RemoteAttachment
{
    // 七牛云鉴权类
    private $Auth = null;
    public function __construct(array $_setting)
    {
        // $_setting['access_key']  七牛云公钥
        // $_setting['secret_key']  七牛云私钥
        // $_setting['bucket'] 七牛云空间名字
        $this->_setting = $_setting;
        $this->init();
    }

    /**
     * 初始化
     */
    private function init()
    {
        $this->Auth = new Auth($this->_setting['access_key'],$this->_setting['secret_key']);
    }

    /**
     * 上传文件到远程
     * @param string $_path 上传的文件路径
     * @param string $_remote_path 远程的文件路径
     * @return mixed|void
     * @throws \Exception
     */
    public function push($_path, $_remote_path)
    {
        // 生成上传token
        $_token = $this->Auth->uploadToken($this->_setting['bucket']);
        $Upload = new UploadManager();
        list($ret, $err) = $Upload->putFile($_token,$_remote_path,$_path);
        return !$err;
    }

    /**
     * 删除远程附件
     * @param string $_remote_path 远程文件名字
     * @return mixed|void
     */
    public function remove($_remote_path)
    {
        $Manager = new BucketManager($this->Auth);
        list($ret, $err) = $Manager->delete($this->_setting['bucket'],$_remote_path);
        return !$err;
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