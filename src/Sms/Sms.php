<?php
namespace Kuyuan\Phpwidget\Sms;
abstract class Sms
{
    // 参数
    protected $_setting = array();
    abstract protected function __construct(Array $_setting);

    /**
     * 发送短信
     * @param $_params
     * @return mixed
     */
    abstract public function send(Array $_params);
}