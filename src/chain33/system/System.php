<?php


namespace chain33\phpsdk\chain33\system;

use chain33\phpsdk\lib\http\Request;

/**
 * Class System chain33 system
 * @package chain33\phpsdk\model
 */
class System
{
    const GET_PEER_INFO = 'Chain33.GetPeerInfo';
    const GET_NET_INFO = 'Chain33.GetNetInfo';
    const GET_TIME_STATUS = 'Chain33.GetTimeStatus';
    const IS_SYNC = 'Chain33.IsSync';

    /**
     * 获取远程节点列表
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:24
     */
    public static function getPeerInfo()
    {
        return Request::sendRequest(self::GET_PEER_INFO);
    }

    /**
     * 查询节点状态
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:24
     */
    public static function getNetInfo()
    {
        return Request::sendRequest(self::GET_NET_INFO);
    }

    /**
     * 查询时间状态
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:24
     */
    public static function getTimeStatus()
    {
        return Request::sendRequest(self::GET_TIME_STATUS);
    }


    /**
     * 查询同步状态
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:23
     */
    public static function isSync()
    {
        return Request::sendRequest(self::IS_SYNC);
    }
}