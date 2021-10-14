<?php
namespace Kuyuan\Phpwidget;
class File
{
    static public function stringDir($_dir_name = '')
    {
        $_string_dir = '';
        if(empty(!$_dir_name)) {
            $_string_dir = $_dir_name;
        }
        $_string_dir .= '/'.date('Y').'/'.date('m');
        return $_string_dir;
    }

    /**
     * 判断一个远程文件是否存在
     * @param $_url
     * @return boolean
     */
    static public function existsRemote($_url)
    {
        $_url = trim($_url);
        if(empty($_url)) return false;
        $Curl = curl_init($_url);
        curl_setopt($Curl,CURLOPT_NOBODY, true);
        curl_setopt($Curl, CURLOPT_CUSTOMREQUEST, 'GET');
        $Result = curl_exec($Curl);
        $_result = false;
        if($Result === true) {
            $_status_code = curl_getinfo($Curl, CURLINFO_HTTP_CODE);
            if($_status_code == 200) {
                $_result = true;
            }
        }
        return $_result;
    }
}
