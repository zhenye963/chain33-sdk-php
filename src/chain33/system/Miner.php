<?php


namespace chain33\phpsdk\chain33\system;

use chain33\phpsdk\lib\http\Request;

/**
 * Class Miner 挖矿模型
 * @package chain33\phpsdk\model
 */
class Miner
{
    const CONVERT_EXEC_TO_ADDR = 'Chain33.ConvertExectoAddr';
    const CREATE_BIND_MINER = 'ticket.CreateBindMiner';
    const SET_AUTO_MINING = 'ticket.SetAutoMining';
    const GET_TICKET_COUNT = 'ticket.GetTicketCount';
    const CHAIN_QUERY = 'Chain33.Query';

    /**
     * 获取执行器地址
     * @param string $execname 执行器名称
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:33
     */
    public static function convertExecToAddr(string $execname)
    {
        $params = ['execname' => $execname];
        return Request::sendRequest(self::CONVERT_EXEC_TO_ADDR,$params);
    }

    /**
     * 绑定挖矿地址
     * @param string $bindAddr 挖矿绑定地址
     * @param string $originAddr 原始地址
     * @param int $amount 用于购买ticket的bty数量
     * @param bool $checkBalance 是否进行额度检查
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:35
     */
    public static function createBindMiner(string $bindAddr,string $originAddr,int $amount,bool $checkBalance)
    {
        $params = [
            'bindAddr' => $bindAddr,
            'originAddr' => $originAddr,
            'amount' => $amount,
            'checkBalance' => $checkBalance
        ];
        return Request::sendRequest(self::CREATE_BIND_MINER,$params);
    }

    /**
     * 设置自动挖矿
     * @param int $flag 标识符，1 为开启自动挖矿，0 为关闭自动挖矿。
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:37
     */
    public static function setAutoMining(int $flag)
    {
        $params = ['flag' => $flag];
        return Request::sendRequest(self::SET_AUTO_MINING,$params);
    }

    /**
     * 获取Ticket的数量
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:33
     */
    public static function getTicketCount()
    {
        return Request::sendRequest(self::GET_TICKET_COUNT);
    }

    /**
     * 获取绑定的挖矿地址
     * @param string $addr
     * @param string $execer
     * @param string $funcName
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 14:46
     */
    public static function getBindMinerAddr(string $addr,string $execer = 'ticket',string $funcName = 'MinerAddress')
    {
        $params = [
            'execer' => $execer,
            'funcName' => $funcName,
            'payload' => [
                'data' => $addr
            ]
        ];
        return Request::sendRequest(self::CHAIN_QUERY,$params);
    }
}