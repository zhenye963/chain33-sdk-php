<?php
namespace chain33\phpsdk\chain33\contract;

use chain33\phpsdk\lib\http\Request;

class EVM
{
    const CREATE_TRANSACTION = 'Chain33.CreateTransaction';
    const CHAIN_QUERY = 'Chain33.Query';
    

    /**
     * 部署hello合约
     * @param $code 需要部署或者调用合约合约代码
     * @array $abi 	需要部署或调用的合约ABI代码
     * @param $execer 执行器名称，这里固定为evm
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 15:25
     */
    public static function createHello($addr)
    {
        
        $params = [
            'execer' => 'evm',
            'actionName' => 'CreateCall',
            'payload' => [
                'isCreate'  => true,
                'name'      => 'Hello',
                "alias"     => "Hello",
                "addr"      => $addr,
                'code'      => "6060604052341561000f57600080fd5b61016c8061001e6000396000f300606060405260043610610041576000357c0100000000000000000000000000000000000000000000000000000000900463ffffffff168063f15da72914610046575b600080fd5b341561005157600080fd5b6100a1600480803590602001908201803590602001908080601f0160208091040260200160405190810160405280939291908181526020018383808284378201915050505050509190505061011c565b6040518080602001828103825283818151815260200191508051906020019080838360005b838110156100e15780820151818401526020810190506100c6565b50505050905090810190601f16801561010e5780820380516001836020036101000a031916815260200191505b509250505060405180910390f35b61012461012c565b819050919050565b6020604051908101604052806000815250905600a165627a7a72305820aad9560ffdd51ed89bbb79130bcf55b88afefcc3f2e2c895b67c223372643fd80029",
            ],
        ];
        return Request::sendRequest(self::CREATE_TRANSACTION,$params);
    }
    
    public static function useHello($addr)
    {
        
        $params = [
            'execer' => 'evm',
            'actionName' => 'CreateCall',
            'payload' => [
                'isCreate'  => false,
                'name'      => 'Hello',
                "addr"      => $addr,
                "abi"       => "echo('123')",
            ],
        ];
        return Request::sendRequest(self::CREATE_TRANSACTION,$params);
    }

    public static function queryHello($hash)
    {
        
        $params = [
            'execer' => 'evm',
            'funcName' => 'CheckAddrExists',
            'payload' => [
                'addr' => $hash
            ]
        ];
        return Request::sendRequest(self::CHAIN_QUERY,$params);
    }
    
    
}