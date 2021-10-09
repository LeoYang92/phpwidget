<?php
namespace Kuyuan\Phpwidget\RemoteAttachment;
use OSS\Core\OssException;
use OSS\OssClient;

class AL extends RemoteAttachment
{
    private $OssClient = null;

    public function __construct(array $_setting)
    {
        $this->_setting = $_setting;
        try {
            $this->OssClient = new OssClient($this->_setting['access_key'], $this->_setting['secret_key'], $this->_setting['domain']);
        } catch (OssException $e) {
            print $e->getMessage();
        }
    }

    /**
     * 上传文件
     * @param $_path
     * @param $_remote_path
     * @return bool|mixed
     */
    public function push($_path, $_remote_path)
    {
        try{
            $this->OssClient->uploadFile($this->_setting['bucket'],$_remote_path,$_path);
            return true;
        } catch (OssException $e) {
            printf($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function remove($_remote_path)
    {
        try {
            $this->OssClient->deleteObject($this->_setting['bucket'],$_remote_path);
            return true;
        } catch (OssException $e) {
            printf($e->getMessage());
            return false;
        }
    }
}