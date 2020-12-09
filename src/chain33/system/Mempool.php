<?php


namespace chain33\phpsdk\chain33\system;


use chain33\phpsdk\lib\http\Request;

class Mempool
{
    const GET_MEM_POOL = 'Chain33.GetMempool';

    /**
     * 获取 GetMempool
     * @param bool $isAll 可不填，是否获取全部交易信息，默认 false
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 14:41
     */
    public static function getMemPool(bool $isAll = false) : array
    {
        $params = ['isAll' => $isAll];
        return Request::sendRequest(self::GET_MEM_POOL,$params);
    }
}