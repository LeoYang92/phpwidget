<?php
namespace Kuyuan\Phpwidget\RemoteAttachment;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use OSS\Core\OssException;
use OSS\OssClient;

class AL extends RemoteAttachment
{
    private $OssClient = null;

    /**
     *'access_key' => '',   // 阿里云access Id
     *'secret_key' => '',   // 阿里云secret
     *'region_domain' => '', // 阿里云地域节点
     *'bucket' => ''  阿里云空间标识
     */
    public function __construct(array $_setting)
    {
        $this->_setting = $_setting;
        try {
            $this->OssClient = new OssClient($this->_setting['access_key'], $this->_setting['secret_key'], $this->_setting['region_domain']);
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

    /**
     * 上传字符串
     * @param string $_path 字符串内容
     * @param $_remote_path
     * @return bool|void
     */
    public function pushString($_path, $_remote_path)
    {
        try{
            $this->OssClient->putObject($this->_setting['bucket'], $_remote_path,$_path);
            return true;
        } catch (OssException $e) {
            printf($e->getMessage());
        }
    }

    /**
     * 阿里云STS授权，用于前端调用资源
     * @param $_arn
     * @param $_role_name
     * @return mixed
     * @throws \AlibabaCloud\Client\Exception\ClientException
     * @throws \AlibabaCloud\Client\Exception\ServerException
     */
    public function js($_arn,$_role_name)
    {
        AlibabaCloud::accessKeyClient($this->_setting['access_key'], $this->_setting['secret_key'])
            ->regionId('cn-hangzhou')
            ->asDefaultClient();
        //设置参数，发起请求。
        try {
            $result = AlibabaCloud::rpc()
                ->scheme('https')
                ->product('Sts')
                ->version('2015-04-01')
                ->action('AssumeRole')
                ->method('POST')
                ->host('sts.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'RoleArn' => $_arn,
                        'RoleSessionName' => $_role_name,
                    ],
                ])
                ->request();
            return $result->toArray();
        } catch (ClientException $e) {
            printf($e->getMessage());
        } catch (ServerException $e) {
            printf($e->getMessage());
        }
    }

    /**
     * 返回私有文件访问链接
     * @param $_remote_path 远程文件路径
     * @param $expires 访问链接的有效时长  
     */ 
    public function privateUrl($_remote_path, $expires = 3600)
    {
        try{
            return $this->OssClient->signUrl($this->_setting['bucket'],$_remote_path,$expires);  
        } catch (OssException $e) {
            printf($e->getMessage());
        }
    }
}