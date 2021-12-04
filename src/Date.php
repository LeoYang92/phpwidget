<?php
namespace Kuyuan\Phpwidget;
class Date
{
    /**
     * 通过一个时间戳返回简单的时间格式
     * 当日时间返回 12:30 当年时间返回 08-10 12:30 其他返回 2021-08-10 12:30
     * @param $_timestamp
     * @return string
     */
    public static function shortFormat($_timestamp)
    {
        $_format = "Y-m-d H:i:s";
        $_today_time = strtotime(date("Y-m-d"));
        if($_timestamp > $_today_time) {
            $_format = "H:i:s";
        } else if(date("Y") == date("Y",$_timestamp)) {
            $_format = "m-d H:i:s";
        }
        return date($_format,$_timestamp);
    }

    /**
     * 通过一个数字（返回指定月份的开始时间戳和结束时间戳）
     * @param $_index
     * @return mixed
     */
    public static function monthStartEnd($_index)
    {
        $_m = date('m');
        $_diff = $_m - $_index;
        // 年差值
        $_year_diff = 0;
        if($_diff == 0) {
            $_year_diff = 1;
            $_m = 12;
        } else if($_diff < 0) {
            $_year_diff = abs(round(($_index - $_m) / 12));
            $_m = $_m - abs($_diff % 12);
        } else {
            $_year_diff = 0;
            $_m = $_diff;
        }
        $_year = date('Y') - $_year_diff;
        return array(
            'start' => mktime(0,0,0,$_m,1,$_year),
            'end' => mktime(23,59,59,$_m,date('t',strtotime($_year.'-'.$_m)),$_year)
        );
    }
}