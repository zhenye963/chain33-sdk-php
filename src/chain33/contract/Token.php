<?php
namespace chain33\phpsdk\chain33\contract;

use chain33\phpsdk\lib\http\Request;

class Token
{
    const CREATE_RAW_TOKEN_PRE_CREATE_TX = 'token.CreateRawTokenPreCreateTx';
    const CREATE_RAW_TOKEN_FINISH_TX = 'token.CreateRawTokenFinishTx';
    const CREATE_RAW_TOKEN_REVOKE_TX = '';
    const SEND_TO_ADDRESS = 'Chain33.SendToAddress';
    const CHAIN_QUERY = 'Chain33.Query';


    /**
     * 生成预创建token 的交易（未签名）
     * @param string $name 	token的全名，最大长度是128个字符
     * @param string $symbol token标记符，最大长度是16个字符，且必须为大写字符和数字
     * @param string $introduction token介绍，最大长度为1024个字节
     * @param int $total 发行总量,需要乘以10的8次方，比如要发行100个币，需要100*1e8
     * @param int $price 发行该token愿意承担的费用
     * @param string $owner token拥有者地址
     * @param int $category token属性类别， 0 为普通token， 1 可增发和燃烧
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 15:25
     */
    public static function createRawTokenPreCreateTx(string $name,string $symbol,string $introduction,int $total,int $price,string $owner,int $category)
    {
        $params = [
            'name' => $name,
            'symbol' => $symbol,
            'introduction' => $introduction,
            'total' => $total,
            'price' => $price,
            'category' => $category,
            'owner' => $owner
        ];
        return Request::sendRequest(self::CREATE_RAW_TOKEN_PRE_CREATE_TX,$params);
    }

    /**
     * 生成完成创建token 的交易（未签名）
     * @param string $symbol token标记符，最大长度是16个字符，且必须为大写字符
     * @param string $owner token拥有者地址
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 15:29
     */
    public static function createRawTokenFinishTx(string $symbol,string $owner)
    {
        $params = [
            'symbol' => $symbol,
            'owner' => $owner
        ];
        return Request::sendRequest(self::CREATE_RAW_TOKEN_FINISH_TX,$params);
    }

    /**
     * token转账
     * @param string $from 来源地址
     * @param string $to 发送到地址
     * @param int $amount 发送金额
     * @param string $note 备注
     * @param string $tokenSymbol token标记符，最大长度是16个字符，且必须为大写字符
     * @param bool $isToken 发送的是否是token，false 的情况下发送的bty
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2020/1/2 10:34
     */
    public static function sendToAddress(string $from,string $to,int $amount,string $note,string $tokenSymbol,bool $isToken = true)
    {
        $params = [
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
            'note' => $note,
            'tokenSymbol' => $tokenSymbol,
            'isToken' => $isToken
        ];
        return Request::sendRequest(self::SEND_TO_ADDRESS,$params);
    }

    /**
     * 查询地址下的token合约下的token资产
     * @param string $execer 执行器名，主链上:token, 平行链上:user.p.xxx.token
     * @param string $address 查询的地址
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2020/1/2 10:40
     */
    public static function getAccountTokenAssets(string $address,string $execer = 'token')
    {
        $params = [
            'execer' => $execer,
            'funcName' => 'GetAccountTokenAssets',
            'payload' => ['address' => $address,'execer' => 'token']
        ];
        return Request::sendRequest(self::CHAIN_QUERY,$params);
    }

    /**
     * @param string $execer
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2020/1/15 11:51
     */
    public static function getTokens(string $execer)
    {
        $params = [
            'execer' => $execer,
            'funcName' => 'GetTokens',
            'payload' => ['status' => 0,'queryAll' => true,'symbolOnly' => true]
        ];
        return Request::sendRequest(self::CHAIN_QUERY,$params);
    }
}