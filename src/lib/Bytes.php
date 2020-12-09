<?php


namespace chain33\phpsdk\utils;


class Bytes
{
    /**
     * 字符串转字节数组
     * @param string $string
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 14:33
     */
    public static function strToBytes(string $string) : array
    {
        $bytes = [];
        $len = strlen($string);
        for ($i = 0;$i < $len;$i++){
            $bytes[] = ord($string[$i]);
        }
        return $bytes;
    }

    /**
     * 字节数组转字符串
     * @param array $bytes
     * @return string
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 14:35
     */
    public static function bytesToStr(array $bytes) : string
    {
        $str = '';
        foreach ($bytes as $byte){
            $str .= chr($byte);
        }
        return $str;
    }
}