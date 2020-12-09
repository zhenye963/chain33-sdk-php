<?php


namespace chain33\phpsdk\chain33\system;

use \chain33\phpsdk\lib\http\Request;

class Wallet
{
    const LOCK = 'Chain33.Lock';
    const UNLOCK = 'Chain33.UnLock';
    const SET_PWD = 'Chain33.SetPasswd';
    const SET_LABEL = 'Chain33.SetLabl';
    const NEW_ACCOUNT = 'Chain33.NewAccount';
    const GET_ACCOUNTS = 'Chain33.GetAccounts';
    const MERGE_BALANCE = 'Chain33.MergeBalance';
    const IMPORT_PRIVATE_KEY = 'Chain33.ImportPrivkey';
    const DUMP_PRIVATE_KEY = 'Chain33.DumpPrivkey';


    const SET_TX_FEE = 'Chain33.SetTxFee';
    const SEND_TO_ADDRESS = 'Chain33.SendToAddress';
    const WALLET_TX_LIST = 'Chain33.WalletTxList';

    const SIGN_RAW_TX = 'Chain33.SignRawTx';

    const GEN_SEED = 'Chain33.GenSeed';
    const SAVE_SEED = 'Chain33.SaveSeed';
    const GET_SEED = 'Chain33.GetSeed';

    const GET_WALLET_STATUS = 'Chain33.GetWalletStatus';


    /**
     * 钱包加锁
     * @return array|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 15:03
     */
    public static function lock()
    {
        return Request::sendRequest(self::LOCK);
    }

    /**
     * 钱包解锁
     * @param string $password 解锁密码
     * @param bool $walletOrTicket true，只解锁ticket买票功能，false：解锁整个钱包
     * @param int $timeout 超时时间
     * @return mixed|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 14:56
     */
    public static function unLock(string $password, bool $walletOrTicket = false, int $timeout = 60)
    {
        $params = [
            "passwd" => $password,
            "walletorticket" => $walletOrTicket,
            "timeout" => (int)$timeout
        ];
        return  Request::sendRequest(self::UNLOCK, $params);
    }

    /**
     * 设置密码
     * @param string $oldPass 第一次设置密码时，oldPass 为空
     * @param string $newPass 待设置的新密码 必须是8个字符（包含8个）以上的数字和字母组合
     * @return array|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 15:28
     */
    public static function setPassWord(string $oldPass,string $newPass)
    {
        $params = [
            'oldPass' => $oldPass,
            'newPass' => $newPass,
        ];
        return Request::sendRequest(self::SET_PWD,$params);
    }

    /**
     * 设置账户标签 SetLabel
     * @param string $address 账户地址
     * @param string $label 待设置的账户标签
     * @return array|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 15:35
     */
    public static function setLabel(string $address,string $label)
    {
        $params = [
            'addr' => $address,
            'label' => $label
        ];
        return Request::sendRequest(self::SET_LABEL,$params);
    }

    /**
     * 创建账户
     * @param string $label 待设置的账户标签
     * @return array|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 15:37
     */
    public static function newAccount(string $label)
    {
        $params = ['label' => $label];
        return Request::sendRequest(self::NEW_ACCOUNT,$params);
    }

    /**
     * 获取账户列表
     * @param bool $withoutBalance 不填或false， 将返回account 的帐号信息。 为true 则返回 label 和 addr 信息， 其他信息为 0
     * @return array|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 15:37
     */
    public static function getAccounts(bool $withoutBalance = false)
    {
        $params = ['withoutBalance' => (bool)$withoutBalance];
        return Request::sendRequest(self::GET_ACCOUNTS,$params);
    }

    /**
     * 合并账户余额
     * @param string $toAddress 合并钱包上的所有余额到一个账户地址
     * @return array|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 15:44
     */
    public static function mergeBalance(string $toAddress)
    {
        $params = ['to' => $toAddress];
        return Request::sendRequest(self::MERGE_BALANCE,$params);
    }

    /**
     * 导入私钥
     * @param string $privateKey 私钥
     * @param string $label 导入账户标签
     * @return array|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 15:49
     */
    public static function importPrivateKey(string $privateKey,string $label)
    {
        $params = ['privkey' => $privateKey,'label' => $label];
        return Request::sendRequest(self::IMPORT_PRIVATE_KEY,$params);
    }

    /**
     *  导出私钥
     * @param string $address 待导出私钥的账户地址
     * @return mixed|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 16:09
     */
    public static function dumpPrivateKey(string $address)
    {
        $params = ['data' => $address];
        return Request::sendRequest(self::DUMP_PRIVATE_KEY,$params);
    }

    /**
     *  设置交易费用
     * @param int $amount 手续费
     * @return mixed|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 16:04
     */
    public static function setTxFee(int $amount)
    {
        $params = ['amount' => (int)$amount];
        return Request::sendRequest(self::SET_TX_FEE,$params);
    }

    /**
     * 发送交易
     * @param string $from 来源地址
     * @param string $to 发送到地址
     * @param int $amount 发送金额
     * @param string $note 备注
     * @param bool $isToken 是否是token类型的转账（非token转账这个不用填）
     * @param string $tokenSymbol toekn的symbol（非token转账这个不用填）
     * @return mixed|null
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 16:07
     */
    public static function sendToAddress(string $from,string $to,int $amount,bool $isToken = false,string $tokenSymbol = '',string $note = '')
    {
        $params = [
            'from' => $from,
            'to' => $to,
            'amount' => (int)$amount,
            'note' => $note,
            'isToken' => (bool)$isToken,
            'tokenSymbol' => $tokenSymbol
        ];
        return Request::sendRequest(self::SEND_TO_ADDRESS,$params);
    }

    /**
     * 获取钱包交易列表 todo @see https://chain.33.cn/document/94#2.3%20%E8%8E%B7%E5%8F%96%E9%92%B1%E5%8C%85%E4%BA%A4%E6%98%93%E5%88%97%E8%A1%A8%20WalletTxList
     * @param string $fromTx Sprintf(“%018d”, height*100000 + index)，表示从高度 height 中的 index 开始获取交易列表；第一次传参为空，获取最新的交易
     * @param int $count 获取交易列表的个数
     * @param int $direction 查找方式；0，获取最新的交易数据，倒叙排序，在交易列表中时间高度是递减的；1，正序排序，按照时间，区块高度增加的方向获取交易列表
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 14:22
     */
    public static function walletTxList(string $fromTx,int $count,int $direction)
    {
        $params = [
            'fromTx' => $fromTx,
            'count' => (int)$count,
            'direction' => (int)$direction
        ];
        return Request::sendRequest(self::WALLET_TX_LIST,$params);
    }

    /**
     * 交易签名 todo @see https://chain.33.cn/document/94#3.1%20%E4%BA%A4%E6%98%93%E7%AD%BE%E5%90%8D%20SignRawTx
     * @param string $addr 签名地址
     * @param string $key 签名私钥，addr与key可以只输入其一
     * @param string $txHex 交易原始数据
     * @param string $expire 过期时间，可输入如”300ms”，”-1.5h”或者”2h45m”的字符串，有效时间单位为”ns”, “us” (or “µs”), “ms”, “s”, “m”, “h”
     * @param int $index 若是签名交易组，则为要签名的交易序号，从1开始，小于等于0则为签名组内全部交易
     * @param int $fee 交易费，单位1/10^8 BTY, 为0时将自动设置合适交易费
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/31 14:26
     */
    public static function signRawTx(string $addr,string $key,string $txHex,string $expire,int $fee,int $index)
    {
        $params = [
            'addr' => $addr,
            'key' => $key,
            'txhex' => $txHex,
            'expire' => $expire,
            'index' => (int)$index,
            'fee' => (int)$fee,
        ];
        return Request::sendRequest(self::SIGN_RAW_TX,$params);
    }
    /**
     * 生成随机的 Seed
     * @param int $lang lang=0:英语，lang=1:简体汉字
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 17:01
     */
    public static function genSeed(int $lang)
    {
        $params = ['lange' => (int)$lang];
        return Request::sendRequest(self::GEN_SEED,$params);
    }

    /**
     * 保存seed并用密码加密Seed
     * @param string $seed 种子要求16个单词或者汉字，参考genseed输出格式，需要空格隔开
     * @param string $password 加密密码，必须大于或等于8个字符的字母和数字组合
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 17:01
     */
    public static function saveSeed(string $seed,string $password)
    {
        $params = ['seed' => $seed,'passwd' => $password];
        return Request::sendRequest(self::SAVE_SEED,$params);
    }

    /**
     * 通过钱包密码获取钱包的seed原文
     * @param string $password 加密密码
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 17:01
     */
    public static function getSeed(string $password)
    {
        $params = ['passwd' => $password];
        return Request::sendRequest(self::GET_SEED,$params);
    }

    /**
     * 获取钱包状态
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 16:59
     */
    public static function getWalletStatus()
    {
        return Request::sendRequest(self::GET_WALLET_STATUS);
    }
}