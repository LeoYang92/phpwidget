<?php
namespace Kuyuan\Phpwidget;
class Str
{
    /**
     * 格式化金额
     * @param int $_money 金额
     * @param bool $_to_int 是否将金额转为整数
     * @return float|int|string
     */
    static public function format_money($_money, $_to_int = false)
    {
        if(!$_to_int) {
            return sprintf('%.2f', $_money / 100);
        } else {
            return $_money * 100;
        }
    }
}