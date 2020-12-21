<?php
namespace chain33\phpsdk;

use chain33\phpsdk\chain33\contract\Token;
use chain33\phpsdk\chain33\contract\EVM;
use chain33\phpsdk\chain33\system\Balance;
use chain33\phpsdk\chain33\system\Chain;
use chain33\phpsdk\chain33\system\GenerateKey;
use chain33\phpsdk\chain33\system\Mempool;
use chain33\phpsdk\chain33\system\System;
use chain33\phpsdk\chain33\system\Trade;
use chain33\phpsdk\chain33\system\Wallet;

/**
 * Class ChainClient
 * @package chain33\phpsdk
 * @method array CreateRawTransaction($to,$amount,$fee,$execer = '',$isToken = false,$tokenSymbol = '',$note = '',$isWithdraw = false,$execName = '')
 *
 * @method array signRawTx($address,$privateKey,$txHex,$expire,$fee,$index = 0,$token = '',$newToAddr = '')
 *
 * @method array sendTransaction($data,$token = '')
 * @method array transfer($privateKey,$to,$amount,$fee,$execer = '',$expire = '300s',$isToken = false,$tokenSymbol = '',$isWithdraw = false,$execName = '',$note = '')
 *
 * @method array getTxByHashes(array $hashes,$isDetail = false)
 * @method array createNoBalanceTransaction($txHex,$payAddr,$privateKey,$expire)
 *
 * @method array createNoBalanceTxs(array $txHexs,$payAddr,$privateKey,$expire)
 * @method array reWriteRawTx($to,$fee,$tx,$expire,$index)
 * @method array getTxByAddr($addr,$count,$flag = 0,$direction = 0,$height = -1,$index = 0)
 * @method array queryTransaction($hash)
 * @method array getHexTxByHash($hash)
 * @method array getAddrOverview($addr,$count = 1,$direction = 1,$height = -1,$flag = 0,$index = 0)
 * @method array convertExectoAddr($execname)
 * @method array createRawTxGroup(array $txs)
 * @method array getProPerFee($txCount,$txSize)
 *
 * -----see [[Trade]] end -------
 *
 * @method lock()
 * @method unLock($password, $walletOrTicket = false, $timeout = 60)
 * @method array setPassWord($oldPass,$newPass)
 * @method array setLabel($address,$label)
 * @method array newAccount($label)
 * @method array getAccounts($withoutBalance = false)
 * @method array mergeBalance($toAddress)
 * @method array importPrivateKey($privateKey,$label)
 * @method array dumpPrivateKey($address)
 * @method array genSeed($lang)
 * @method array saveSeed($seed,$password)
 * @method array getSeed($password)
 * @method array getWalletStatus()
 *
 * @method privateKey()
 * @method publicKey()
 * @method getAddress($private_key)
 *
 * @method array getBalance(array $addresses,$execer = 'coins',$asset_exec = '',$asset_symbol = '',$stateHash = "")
 * @method array getTokenBalance(array $addresses,$execer,$tokenSymbol)
 * @method array getAllExecBalance($addresses,$execer = "",$asset_symbol = "",$asset_exec = "",$stateHash = "")
 *
 * @method array isSync()
 * @method array getTimeStatus()
 * @method array getNetInfo()
 * @method array getPeerInfo()
 *
 * @method array getVersion()
 * @method array getBlocks($start,$end,$isDetail = false)
 * @method array getLastHeader()
 * @method array getHeaders($start,$end,$isDetail = false)
 * @method array getBlockHash($height)
 * @method array getBlockOverview($hash)
 * @method array getBlockByHashes(array $hashes,$isDetail = false)
 * 
 * @method array createHello()
 * @method array queryHello($hash)
 *
 */
class ChainClient
{

    function __call($name, $arguments)
    {
        $classes = [
            Trade::class,Balance::class,Wallet::class,GenerateKey::class,Chain::class,System::class,Mempool::class,Token::class,EVM::class
        ];
        foreach ($classes as $class) {
            if(method_exists($class,$name)) {
                return call_user_func_array([$class,$name],$arguments);
            }
        }
        return ['error' => 'method not fund','result' => null];
    }
}