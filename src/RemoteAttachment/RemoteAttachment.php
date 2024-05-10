<?php
/*
 * @Author: error: git config user.name & please set dead value or install git
 * @Date: 2024-05-10 10:56:36
 * @LastEditors: error: git config user.name & please set dead value or install git
 * @LastEditTime: 2024-05-10 11:28:08
 * @Description: 添加访问私有文件方法
 */
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
     * 上传字符串
     * @param string $_path 字符串内容
     * @param $_remote_path
     * @return mixed
     */
    abstract public function pushString($_path,$_remote_path);


    /**
     * 删除远程附件
     * @param $_remote_path
     * @return mixed
     */
    abstract public function remove($_remote_path);

    /**
     * 返回私有文件访问链接
     * @param $_remote_path 远程文件路径
     * @param $expires 访问链接的有效时长  
     */
    abstract public function privateUrl($_remote_path,$expires=3600);
}