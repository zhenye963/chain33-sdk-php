<?php
namespace chain33\phpsdk;

use chain33\phpsdk\chain33\contract\Token;
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
 * @method array CreateRawTransaction(string $to,int $amount,int $fee,string $execer = '',bool $isToken = false,string $tokenSymbol = '',string $note = '',bool $isWithdraw = false,string $execName = '')
 *
 * @method array signRawTx(string $address,string $privateKey,string $txHex,string $expire,int $fee,int $index = 0,string $token = '',string $newToAddr = '')
 *
 * @method array sendTransaction(string $data,string $token = '')
 * @method array transfer(string $privateKey,string $to,int $amount,int $fee,string $execer = '',string $expire = '300s',bool $isToken = false,string $tokenSymbol = '',bool $isWithdraw = false,string $execName = '',string $note = '')
 *
 * @method array getTxByHashes(array $hashes,bool $isDetail = false)
 * @method array createNoBalanceTransaction(string $txHex,string $payAddr,string $privateKey,string $expire)
 *
 * @method array createNoBalanceTxs(array $txHexs,string $payAddr,string $privateKey,string $expire)
 * @method array reWriteRawTx(string $to,int $fee,string $tx,string $expire,int $index)
 * @method array getTxByAddr(string $addr,int $count,int $flag = 0,int $direction = 0,int $height = -1,int $index = 0)
 * @method array queryTransaction(string $hash)
 * @method array getHexTxByHash(string $hash)
 * @method array getAddrOverview(string $addr,int $count = 1,int $direction = 1,int $height = -1,int $flag = 0,int $index = 0)
 * @method array convertExectoAddr(string $execname)
 * @method array createRawTxGroup(array $txs)
 * @method array getProPerFee(int $txCount,int $txSize)
 *
 * -----see [[Trade]] end -------
 *
 * @method bool lock()
 * @method bool unLock(string $password, bool $walletOrTicket = false, int $timeout = 60)
 * @method array setPassWord(string $oldPass,string $newPass)
 * @method array setLabel(string $address,string $label)
 * @method array newAccount(string $label)
 * @method array getAccounts(bool $withoutBalance = false)
 * @method array mergeBalance(string $toAddress)
 * @method array importPrivateKey(string $privateKey,string $label)
 * @method array dumpPrivateKey(string $address)
 * @method array genSeed(int $lang)
 * @method array saveSeed(string $seed,string $password)
 * @method array getSeed(string $password)
 * @method array getWalletStatus()
 *
 * @method string privateKey()
 * @method string publicKey()
 * @method string getAddress($private_key)
 *
 * @method array getBalance(array $addresses,string $execer = 'coins',string $asset_exec = '',string $asset_symbol = '',string $stateHash = "")
 * @method array getTokenBalance(array $addresses,string $execer,string $tokenSymbol)
 * @method array getAllExecBalance(string $addresses,string $execer = "",string $asset_symbol = "",string $asset_exec = "",string $stateHash = "")
 *
 * @method array isSync()
 * @method array getTimeStatus()
 * @method array getNetInfo()
 * @method array getPeerInfo()
 *
 * @method array getVersion()
 * @method array getBlocks(int $start,int $end,bool $isDetail = false)
 * @method array getLastHeader()
 * @method array getHeaders(int $start,int $end,bool $isDetail = false)
 * @method array getBlockHash(int $height)
 * @method array getBlockOverview(string $hash)
 * @method array getBlockByHashes(array $hashes,bool $isDetail = false)
 *
 */
class ChainClient
{

    function __call($name, $arguments)
    {
        $classes = [
            Trade::class,Balance::class,Wallet::class,GenerateKey::class,Chain::class,System::class,Mempool::class,Token::class
        ];
        foreach ($classes as $class) {
            if(method_exists($class,$name)) {
                return call_user_func_array([$class,$name],$arguments);
            }
        }
        return ['error' => 'method not fund','result' => null];
    }
}