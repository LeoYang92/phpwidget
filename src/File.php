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
}
