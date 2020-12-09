<?php


namespace chain33\phpsdk\chain33\system;


use chain33\phpsdk\lib\http\Request;

class Balance
{
    const GET_BALANCE = 'Chain33.GetBalance';
    const GET_TOKEN_BALANCE = 'token.GetTokenBalance';
    const GET_ALL_EXEC_BALANCE = 'Chain33.GetAllExecBalance';

    /**
     * 查询地址余额
     * @param array $addresses 要查询的地址列表
     * @param string $execer 执行器名称，coins 查询可用的主代币 ，ticket 查询正在挖矿的主代币
     * @param string $asset_exec 资产原始合约名称，如bty 在 coins 合约中产生，各种token 在 token 合约中产生， 跨链的资产在 paracross 合约中
     * @param string $asset_symbol 资产名称，如 bty， token的各种 symbol ， 跨链的bty 名称为 coins.bty, 跨链的token 为 token.symbol
     * @param string $stateHash 状态Hash
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:55
     */
    public static function getBalance(array $addresses,string $execer = 'coins',string $asset_exec = '',string $asset_symbol = '',string $stateHash = "")
    {
        $params = [
            'addresses' => $addresses,
            'execer' => $execer,
            'asset_exec' => $asset_exec,
            'asset_symbol' => $asset_symbol,
            'stateHash' => $stateHash
        ];
        return Request::sendRequest(self::GET_BALANCE,$params);
    }

    /**
     * 查询地址token余额
     * @param array $addresses 要查询的地址列表
     * @param string $execer token 查询可用的余额 ，trade 查询正在交易合约里的token,如果是查询平行链上余额，则需要指定具体平行链的执行器execer,例如：user.p.xxx.token .
     * @param string $tokenSymbol token符号名称
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 11:01
     */
    public static function getTokenBalance(array $addresses,string $execer,string $tokenSymbol)
    {
        $params = [
            'addresses' => $addresses,
            'execer' => $execer,
            'tokenSymbol' => $tokenSymbol,
        ];
        return Request::sendRequest(self::GET_TOKEN_BALANCE,$params);
    }

    /**
     * 查询地余额
     * @param array $addresses 要查询的地址列表
     * @param string $execer 执行器名称，coins 查询可用的主代币 ，ticket 查询正在挖矿的主代币
     * @param string $asset_exec 资产原始合约名称，如bty 在 coins 合约中产生，各种token 在 token 合约中产生， 跨链的资产在 paracross 合约中
     * @param string $asset_symbol 资产名称，如 bty， token的各种 symbol ， 跨链的bty 名称为 coins.bty, 跨链的token 为 token.symbol
     * @param string $stateHash 状态Hash
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/30 10:55
     */
    public static function getAllExecBalance(string $addresses,string $execer = "",string $asset_symbol = "",string $asset_exec = "",string $stateHash = "")
    {
        $params = [
            'addr' => $addresses,
            'execer' => $execer,
            'asset_exec' => $asset_exec,
            'asset_symbol' => $asset_symbol,
            'stateHash' => $stateHash
        ];
        return Request::sendRequest(self::GET_ALL_EXEC_BALANCE,$params);
    }
}