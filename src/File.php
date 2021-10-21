<?php
namespace Kuyuan\Phpwidget;
class File
{
    /**
     * 生成一个文件存储相对路径
     * @param string $_dir_name 文件名字
     * @param string $_suffix 文件后缀名字
     * @return string
     */
    static public function stringDir($_dir_name = '',$_suffix = '')
    {
        $_string_dir = '';
        if(empty(!$_dir_name)) {
            $_string_dir = $_dir_name;
        }
        $_string_dir .= '/'.date('Y').'/'.date('m');
        if(!empty($_suffix)) $_string_dir.= '/'.self::fileName($_suffix);
        return $_string_dir;
    }

    /**
     * 生成一个文件名字
     * @param string $_suffix 文件后缀名字
     * @return string
     */
    static public function fileName($_suffix)
    {
        return md5(uniqid(microtime(),true)).'.'.$_suffix;
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
