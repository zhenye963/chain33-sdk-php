<?php


namespace chain33\phpsdk\chain33\system;


use chain33\phpsdk\lib\http\Request;

class Trade
{
    const CREATE_RAW_TRAN = 'Chain33.CreateRawTransaction';
    const SIGN_RAW_TX = 'Chain33.SignRawTx';
    const SEND_TRAN = 'Chain33.SendTransaction';
    const CREATE_NO_BALANCE_TRAN = 'Chain33.CreateNoBalanceTransaction';
    const CREATE_NO_BALANCE_TRANS = 'Chain33.CreateNoBlanaceTxs';
    const RE_WRITE_RAW_TX = 'Chain33.ReWriteRawTx';

    const QUERY_TRAN = 'Chain33.QueryTransaction';
    const GET_TX_BY_ADDR = 'Chain33.GetTxByAddr';
    const GET_TX_BY_HASHES = 'Chain33.GetTxByHashes';
    const GET_HEX_BY_HASHES = 'Chain33.GetHexTxByHash';
    const GET_ADDR_OVERVIEW = 'Chain33.GetAddrOverview';
    const CONVERT_EXEC_TO_ADDR = 'Chain33.ConvertExectoAddr';
    const CREATE_RAW_TX_GROUP = 'Chain33.CreateRawTxGroup';
    const GET_PROPER_FEE = 'Chain33.GetProperFee';

    /**
     * 构造，签名，发送交易
     * @param string $privateKey
     * @param string $to
     * @param int $amount
     * @param int $fee
     * @param string $expire
     * @param string $execer
     * @param bool $isWithdraw
     * @param string $execName
     * @param string $note
     * @param bool $isToken
     * @param string $tokenSymbol
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     */
    public static function transfer(string $privateKey,string $to,int $amount,int $fee,string $execer = '',string $expire = '300s',bool $isToken = false,string $tokenSymbol = '',bool $isWithdraw = false,string $execName = '',string $note = '')
    {
        $params = [
            'to' => $to,
            'amount' => $amount,
            'fee' => $fee,
            'note' => $note,
            'isToken' => $isToken,
            'isWithdraw' => $isWithdraw,
            'tokenSymbol' => $tokenSymbol,
            'execName' => $execName,
            'execer' => $execer
        ];
        //echo "created raw trade begin\r\n";
        $res = Request::sendRequest(self::CREATE_RAW_TRAN,$params);
        if (!empty($res['error']))return $res;

        $params = [
            'addr' => '',
            'privkey' => $privateKey,
            'txHex' => $res['result'],
            'expire' => $expire,
            'index' => 0,
            'token' => '',
            'fee' => $fee,
            'newToAddr' => ''
        ];
        //echo "sign trade begin\r\n";
        $sign = Request::sendRequest(self::SIGN_RAW_TX,$params);
        if (!empty($sign['error']))return $sign;
        $params = ['data' => $sign['result'],'token' => $tokenSymbol];
        //echo "send trade begin\r\n";
        return Request::sendRequest(self::SEND_TRAN,$params);
    }

    /**
     * 构造交易
     * @param string $to 发送到地址
     * @param int $amount 发送金额，注意基础货币单位为10^8
     * @param int $fee 手续费，注意基础货币单位为10^8
     * @param string $note 备注
     * @param bool $isWithdraw 是否为取款交易
     * @param bool $isToken 是否是token类型的转账 （非token转账这个不用填 包括平行链的基础代币转账也不用填）
     * @param string $execName TransferToExec（转到合约） 或 Withdraw（从合约中提款），如果要构造平行链上的转账，此参数置空
     * @param string $execer 执行器名称，如果是构造平行链的基础代币，此处要填写user.p.xxx.coins
     * @param string $tokenSymbol token 的 symbol （非token转账这个不用填）
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:27
     */
    public static function createRawTransaction(string $to,int $amount,int $fee,string $execer = '',bool $isToken = false,string $tokenSymbol = '',string $note = '',bool $isWithdraw = false,string $execName = '')
    {
        $params = [
            'to' => $to,
            'amount' => $amount,
            'fee' => $fee,
            'note' => $note,
            'isToken' => $isToken,
            'isWithdraw' => $isWithdraw,
            'tokenSymbol' => $tokenSymbol,
            'execName' => $execName,
            'execer' => $execer
        ];
        return Request::sendRequest(self::CREATE_RAW_TRAN,$params);
    }

    /**
     * 交易签名
     * @param string $address addr与privkey可以只输入其一，如果使用addr则依赖钱包中存储的私钥签名
     * @param string $privateKey addr与privkey可以只输入其一，如果使用privkey则直接签名
     * @param string $txHex 上一步生成的原始交易数据
     * @param string $expire 过期时间可输入如”300s”，”-1.5h”或者”2h45m”的字符串，有效时间单位为”ns”, “us” (or “µs”), “ms”, “s”, “m”, “h”
     * @param int $index 若是签名交易组，则为要签名的交易序号，从1开始，小于等于0则为签名组内全部交易
     * @param string $token
     * @param int $fee 费用
     * @param string $newToAddr
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:34
     */
    public static function signRawTx(string $address,string $privateKey,string $txHex,string $expire,int $fee,int $index = 0,string $token = '',string $newToAddr = '')
    {
        $params = [
            'addr' => $address,
            'privkey' => $privateKey,
            'txHex' => $txHex,
            'expire' => $expire,
            'index' => $index,
            'token' => $token,
            'fee' => $fee,
            'newToAddr' => $newToAddr
        ];
        return Request::sendRequest(self::SIGN_RAW_TX,$params);
    }

    /**
     * 发送交易
     * @param string $data 为上一步签名后的交易数据
     * @param string $token 可为空
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:38
     */
    public static function sendTransaction(string $data,string $token = '')
    {
        $params = ['data' => $data,'token' => $token];
        return Request::sendRequest(self::SEND_TRAN,$params);
    }

    /**
     *  构造并发送不收手续费交易 （平行链）
     * @param string $txHex 未签名的原始交易数据
     * @param string $payAddr 用于付费的地址，这个地址要在主链上存在，并且里面有比特元用于支付手续费, payAddr与privkey可以只输入其一，如果使用payAddr则依赖钱包中存储的私钥签名
     * @param string $privateKey 对应于payAddr的私钥。如果payAddr已经导入到平行链，可以只传地址
     * @param string $expire 过期时间可输入如”300s”，”-1.5h”或者”2h45m”的字符串，有效时间单位为”ns”, “us” (or “µs”), “ms”, “s”, “m”, “h”， 不传递默认设置永不过期
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:44
     */
    public static function createNoBalanceTransaction(string $txHex,string $payAddr,string $privateKey,string $expire)
    {
        $params = [
            'txHex' => $txHex,
            'payAddr' => $payAddr,
            'privkey' => $privateKey,
            'expire' => $expire
        ];
        return Request::sendRequest(self::CREATE_NO_BALANCE_TRAN,$params);
    }

    /**
     * 构造多笔并发送不收手续费交易 （平行链）
     * @param array $txHexs 未签名的原始交易数据
     * @param string $payAddr 用于付费的地址，这个地址要在主链上存在，并且里面有比特元用于支付手续费, payAddr与privkey可以只输入其一，如果使用payAddr则依赖钱包中存储的私钥签名
     * @param string $privateKey 对应于payAddr的私钥。如果payAddr已经导入到平行链，可以只传地址
     * @param string $expire 过期时间可输入如”300s”，”-1.5h”或者”2h45m”的字符串，有效时间单位为”ns”, “us” (or “µs”), “ms”, “s”, “m”, “h”， 不传递默认设置永不过期
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:44
     */
    public static function createNoBalanceTxs(array $txHexs,string $payAddr,string $privateKey,string $expire)
    {
        $params = [
            'txHexs' => $txHexs,
            'payAddr' => $payAddr,
            'privkey' => $privateKey,
            'expire' => $expire
        ];
        return Request::sendRequest(self::CREATE_NO_BALANCE_TRANS,$params);
    }

    /**
     * 重写交易
     * @param string $to 重写交易的目的地址，只有单笔交易生效，交易组不生效
     * @param int $fee 重写交易的费用，交易组只会修改第一笔交易的费用
     * @param string $tx 需要重写的原始交易数据
     * @param string $expire 过期时间可输入如”300ms”，”-1.5h”或者”2h45m”的字符串，有效时间单位为”ns”, “us” (or “µs”), “ms”, “s”, “m”, “h”
     * @param int $index 若是交易组，则为要重写的交易序号，从1开始，小于等于0则为交易组内全部交易
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:50
     */
    public static function reWriteRawTx(string $to,int $fee,string $tx,string $expire,int $index)
    {
        $params = ['to' => $to,'fee' => (int)$fee,'tx' => $tx,'expire' => $expire,'index' => (int)$index];
        return Request::sendRequest(self::RE_WRITE_RAW_TX,$params);
    }

    /**
     * 根据哈希查询交易信息
     * @param string $hash 交易哈希
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:53
     */
    public static function queryTransaction(string $hash)
    {
        $params = ['hash' => $hash];
        return Request::sendRequest(self::QUERY_TRAN,$params);
    }

    /**
     * 根据地址获取交易信息
     * @param string $addr 要查询的账户地址
     * @param int $count 返回的数据条数
     * @param int $direction 查询的方向；0：正向查询，区块高度从低到高；-1：反向查询；
     * @param int $height 交易所在的block高度，-1：表示从最新的开始向后取；大于等于0的值，从具体的高度+具体index开始取
     * @param int $flag 交易类型；0：所有涉及到addr的交易； 1：addr作为发送方； 2：addr作为接收方；
     * @param int $index 交易所在block中的索引，取值0—100000
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:56
     */
    public static function getTxByAddr(string $addr,int $count,int $flag = 0,int $direction = 0,int $height = -1,int $index = 0)
    {
        $params = [
            'addr' => $addr,
            'flag' => $flag,
            'count' => $count,
            'direction' => $direction,
            'height' => $height,
            'index' => $index
        ];
        return Request::sendRequest(self::GET_TX_BY_ADDR,$params);
    }

    /**
     * 根据哈希数组批量获取交易信息
     * @param array $hashes 交易hash数组
     * @param bool $disableDetail 是否隐藏交易详情，默认为false
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:01
     */
    public static function getTxByHashes(array $hashes,bool $disableDetail = false)
    {
        $params = ['hashes' => $hashes,'disableDetail' => $disableDetail];
        return Request::sendRequest(self::GET_TX_BY_HASHES,$params);
    }

    /**
     * 根据哈希获取交易的字符串
     * @param string $hash 交易哈希
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:01
     */
    public static function getHexTxByHash(string $hash)
    {
        $params = ['hash' => $hash];
        return Request::sendRequest(self::GET_HEX_BY_HASHES,$params);
    }

    /**
     * 获取地址相关摘要信息
     * @note本接口中参数结构和GetTxByAddr公用，但是本接口目前只是用到了addr参数，其它参数均无意义；
     * @param string $addr 要查询的账户地址
     * @param int $count 返回的数据条数
     * @param int $direction 查询的方向；0：正向查询，区块高度从低到高；-1：反向查询；
     * @param int $height 交易所在的block高度，-1：表示从最新的开始向后取；大于等于0的值，从具体的高度+具体index开始取
     * @param int $flag 交易类型；0：所有涉及到addr的交易； 1：addr作为发送方； 2：addr作为接收方；
     * @param int $index 交易所在block中的索引，取值0—100000
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 10:56
     */
    public static function getAddrOverview(string $addr,int $count = 1,int $direction = 1,int $height = -1,int $flag = 0,int $index = 0)
    {
        $params = [
            'addr' => $addr,
            'flag' => $flag,
            'count' => $count,
            'direction' => $direction,
            'height' => $height,
            'index' => $index
        ];
        return Request::sendRequest(self::GET_ADDR_OVERVIEW,$params);
    }

    /**
     * 将合约名转成实际地址
     * @param string $execname 执行器名称，如果需要往执行器中转币这样的操作，需要调用些接口将执行器名转成实际地址
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:14
     */
    public static function convertExectoAddr(string $execname)
    {
        $params = ['execname' => $execname];
        return Request::sendRequest(self::CONVERT_EXEC_TO_ADDR,$params);
    }

    /**
     * 构造交易组
     * @param array $txs 十六进制格式交易数组
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:16
     */
    public static function createRawTxGroup(array $txs)
    {
        $params = ['txs' => $txs];
        return Request::sendRequest(self::CREATE_RAW_TX_GROUP,$params);
    }

    /**
     * 设置合适单元交易费率
     * @param int $txCount 预发送的交易个数,单个交易发送默认空即可
     * @param int $txSize 预发送交易的大小, 单位Byte, 字节
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 11:19
     */
    public static function getProPerFee(int $txCount,int $txSize)
    {
        $params = ['txCount' => $txCount,'txSize' => $txSize];
        return Request::sendRequest(self::GET_PROPER_FEE,$params);
    }
}