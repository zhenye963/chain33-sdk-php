<?php


namespace chain33\phpsdk\chain33\system;



use chain33\phpsdk\lib\http\Request;

class Chain
{
    const VERSION = 'Chain33.Version';
    const GET_BLOCKS = 'Chain33.GetBlocks';
    const GET_LAST_HEADER = 'Chain33.GetLastHeader';
    const GET_HEADERS = 'Chain33.GetHeaders';
    const GET_BLOCK_HASH = 'Chain33.GetBlockHash';
    const GET_BLOCK_OVERVIEW = 'Chain33.GetBlockOverview';
    const GET_BLOCK_BY_HASHES = 'Chain33.GetBlockByHashes';
    const GET_BLOCK_SEQUENCES = 'Chain33.GetBlockSequences';
    const GET_LAST_BLOCK_SEQUENCES = 'Chain33.GetLastBlockSequence';
    const ADD_SEQ_CALL_BACK = 'Chain33.AddSeqCallBack';
    const LIST_SEQ_CALL_BACK = 'Chain33.ListSeqCallBack';
    const GET_SEQ_CALL_BACK_LAST_NUM = 'Chain33.GetSeqCallBackLastNum';

    /**
     * 获取版本
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:17
     */
    public static function getVersion()
    {
        return Request::sendRequest(self::VERSION);
    }

    /**
     * 获取区间区块
     * @param int $start 开始区块高度
     * @param int $end 结束区块高度
     * @param bool $isDetail 是否打印区块详细信息
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:16
     */
    public static function getBlocks(int $start,int $end,bool $isDetail = false)
    {
        $params = ['start' => (int)$start,'end' => (int)$end,'isDetail' => (bool)$isDetail];
        return Request::sendRequest(self::GET_BLOCKS,$params);
    }

    /**
     * 获取最新的区块头
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:18
     */
    public static function getLastHeader()
    {
        return Request::sendRequest(self::GET_LAST_HEADER);
    }

    /**
     * 获取区间区块头 todo @see https://chain.33.cn/document/97#1.4%20%E8%8E%B7%E5%8F%96%E5%8C%BA%E9%97%B4%E5%8C%BA%E5%9D%97%E5%A4%B4%20GetHeaders
     * @param int $start 开始区块高度
     * @param int $end 结束区块高度
     * @param bool $isDetail 是否打印区块详细信息
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:21
     */
    public static function getHeaders(int $start,int $end,bool $isDetail = false)
    {
        $params = ['start' => (int)$start,'end' => (int)$end,'isDetail' => (bool)$isDetail];
        return Request::sendRequest(self::GET_HEADERS,$params);
    }

    /**
     * 获取区块哈希值
     * @param int $height 需要获取哈希的区块的高度
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:24
     */
    public static function getBlockHash(int $height)
    {
        $params = ['height' => (int)$height];
        return Request::sendRequest(self::GET_BLOCK_HASH,$params);
    }

    /**
     * 获取区块的详细信息
     * @param string $hash 区块哈希值
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:25
     */
    public static function getBlockOverview(string $hash)
    {
        $params = ['hash' => $hash];
        return Request::sendRequest(self::GET_BLOCK_OVERVIEW,$params);
    }

    /**
     * 通过区块哈希获取区块信息
     * @param array $hashes 区块哈希列表
     * @param bool $isDetail 是否打印区块详细信息
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:28
     */
    public static function getBlockByHashes(array $hashes,bool $isDetail = false)
    {
        $params = ['hashes' => $hashes,'disableDetail' => (bool)$isDetail];
        return Request::sendRequest(self::GET_BLOCK_BY_HASHES,$params);
    }

    /**
     * 获取区块的序列信息
     * @param int $start 开始区块高度
     * @param int $end 结束区块高度
     * @param bool $isDetail 是否打印区块详细信息
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:34
     */
    public static function getBlockSequences(int $start,int $end,bool $isDetail)
    {
        $params = ['start' => (int)$start,'end' => (int)$end,'isDetail' => (bool)$isDetail];
        return Request::sendRequest(self::GET_BLOCK_SEQUENCES,$params);
    }

    /**
     * 获取最新区块的序列号
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:34
     */
    public static function getLastBlockSequence()
    {
        return Request::sendRequest(self::GET_LAST_BLOCK_SEQUENCES);
    }

    /**
     * 增加区块序列号变更回调 todo @see  https://chain.33.cn/document/97#1.10%20%E5%A2%9E%E5%8A%A0%E5%8C%BA%E5%9D%97%E5%BA%8F%E5%88%97%E5%8F%B7%E5%8F%98%E6%9B%B4%E5%9B%9E%E8%B0%83%20AddSeqCallBack
     * @param string $name 回调名称，长度不能超过128
     * @param string $url 序列号变化通知的URL，长度不能超过1024；当name相同，URL为空时取消通知
     * @param string $encode 数据编码方式；json 或者 proto
     * @param bool $isHeader 推送的数据类型；false:block 或者 true:header
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:44
     */
    public static function addSeqCallBack(string $name,string $url,string $encode,bool $isHeader)
    {
        $params = ['name' => $name,'URL' => $url,'encode' => $encode,'isHeader' => (bool)$isHeader];
        return Request::sendRequest(self::ADD_SEQ_CALL_BACK,$params);
    }

    /**
     * 列举区块序列号回调
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:48
     */
    public static function listSeqCallBack()
    {
        return Request::sendRequest(self::LIST_SEQ_CALL_BACK);
    }

    /**
     * 获取某回调最新序列号的值
     * @param string $data 回调名
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:49
     */
    public static function getSeqCallBackLastNum(string $data)
    {
        $params = ['data' => $data];
        return Request::sendRequest(self::GET_SEQ_CALL_BACK_LAST_NUM,$params);
    }
}