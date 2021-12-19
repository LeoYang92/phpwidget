<?php
/**
 * 阿里云短信
 */
namespace Kuyuan\Phpwidget\Sms;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
class ALSms extends Sms
{
    // 短信对象
    private $SmsClient = null;

    /**
     * ALSms constructor.
     * @param array $_setting
     * $_setting['access_key']  $_setting['access_secret']
     */
    public function __construct(array $_setting)
    {
        $Config = new Config([
            "accessKeyId" => $_setting['access_key'],
            // 您的AccessKey Secret
            "accessKeySecret" => $_setting['access_secret']
        ]);
        $Config->endpoint = "dysmsapi.aliyuncs.com";
        $this->SmsClient = new Dysmsapi($Config);
    }

    /**
     * 发送短信
     * @param array $_params
     * @return mixed|void
     * @return Object ( [bizId] => 256604239920984872^0 [code] => OK [message] => OK [requestId] => B7B18788-8779-58F4-84C1-DD5C39BD3509 [_name:protected] => Array ( [bizId] => BizId [code] => Code [message] => Message [requestId] => RequestId ) [_required:protected] => Array ( ) )
     */
    public function send(Array $_params)
    {
        $sendSmsRequest = new SendSmsRequest([
            "phoneNumbers" => $_params['phone_number'],
            "signName" => $_params['sign_name'],
            "templateCode" => $_params['template_code'],
            "templateParam" => json_encode($_params['params'])
        ]);
        $Result = $this->SmsClient->sendSms($sendSmsRequest);
        return $Result->body;
    }
}