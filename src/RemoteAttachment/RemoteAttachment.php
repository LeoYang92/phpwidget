<?php
namespace Kuyuan\Phpwidget\RemoteAttachment;
abstract class RemoteAttachment
{
    // 远程附件参数
    protected $_setting = array();
    abstract protected function __construct(Array $_setting);


    /**
     * 上传文件到远程
     * @param $_path
     * @param $_remote_path
     * @return mixed
     */
    abstract public function push($_path,$_remote_path);

    /**
     * 删除远程附件
     * @param $_remote_path
     * @return mixed
     */
    abstract public function remove($_remote_path);
}