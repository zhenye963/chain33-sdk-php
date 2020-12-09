<?php

use chain33\phpsdk\ChainClient;

require_once './autoload.php';

/*****config.php文件要配置主机、端口超时时间等******/

$client = new ChainClient();

/**交易开始 交易分三步(构造交易，签名，发送交易)******/
//1、构建交易 数量是乘1e8之后的数量
//$rawTx = $client->CreateRawTransaction('1HoPZ68echFJw5NtRTjvRcR1JKuRqrMrZA',100000000,1000000);
//token交易 execer为对应平行链固定格式user.p.xxx.token tokenSymbol为token名称 注意修改config.php配置
//$rawTx = $client->CreateRawTransaction('1HoPZ68echFJw5NtRTjvRcR1JKuRqrMrZA',10000000,1000000,'user.p.sakurachain.token',true,'SJPY');


//2、签名 address和privateKey填一个即可，如果address不为空要先解锁钱包，建议直接用privateKey签名
/*if (empty($rawTx['error']) && !empty($rawTx['result'])) {
    //2.1构建交易组，一次发送多笔交易
    //$rawTx = $client->createRawTxGroup([$rawTx['result']]);
    //2.2 构造并发送不收手续费交易 （平行链）手续费实际为指定地址代扣，payAddr为代扣手续费地址，payAddr和privateKey填一个即可 返回结果要签名
    //$rawTx = $client->createNoBalanceTransaction($rawTx['result'],'','','300s');
    //$rawTx = $client->createNoBalanceTxs([$rawTx['result']],'','','300s');
    //address和privateKey填一个即可
    $signRes = $client->signRawTx('','0xb3f28572edbdfc080895f4590a248a2b66841e7f007cb1b80bc49187a3aa62be',$rawTx['result'],'300s',1000000);
}*/

//3、发送交易 成功返回交易hash
/*if (empty($signRes['error']) && !empty($signRes['result'])) {
    $res = $client->sendTransaction($signRes['result']);
}*/

/*****交易结束******/

//交易 三步合一步
$res = $client->transfer('0xb3f28572edbdfc080895f4590a248a2b66841e7f007cb1b80bc49187a3aa62be','1HoPZ68echFJw5NtRTjvRcR1JKuRqrMrZA',10000000,1000000);
//token交易
//$res = $client->transfer('','','',10000000,1000000,'user.p.sakurachain.token','300s',true,'JSPY');

//根据hash查询多笔交易信息
//$res = $client->getTxByHashes(['0x49fb0eef702d0d918d7a0d4c404e3fd7aa737b5518ae2d8d7a3e0368cc294d02']);
//根据hash查单笔交易
//$res = $client->queryTransaction('0x49fb0eef702d0d918d7a0d4c404e3fd7aa737b5518ae2d8d7a3e0368cc294d02');
//根据地址获取交易
//$tx = $client->getTxByAddr('1HwjxVT9wkWitCEhYvXRo1FcKXibbP6pPL',10);
//获取地址摘要信息
//$info = $client->getAddrOverview('1HwjxVT9wkWitCEhYvXRo1FcKXibbP6pPL');



//本地生成私钥
//$priKey = $client->privateKey();
//本地生成公钥(地址) 和生成私钥一起使用
//$pubKey = $client->publicKey();
//从私钥导出地址(公钥)
//$address = $client->getAddress('c3fa39c08959fb33a518a08848470f03c53e74de61afd38cc652f6a6bc3575b7');


//获取coins或ticket余额
//$res = $client->getBalance(['1HwjxVT9wkWitCEhYvXRo1FcKXibbP6pPL']);
//获取token余额 execer为平行链名称 固定格式， tokenSymbol为币种名称
//$res = $client->getTokenBalance(['1HwjxVT9wkWitCEhYvXRo1FcKXibbP6pPL'],'user.p.sakurachain.token','SJPY');

//获取指定高度区块头
//$res = $client->getHeaders(10,12,true);
//根据hash获取区块
//$res = $client->getBlockByHashes(['0x49fb0eef702d0d918d7a0d4c404e3fd7aa737b5518ae2d8d7a3e0368cc294d02'],true);
//根据高度获取区块信息
//$res = $client->getBlockHash(2);
//获取指定高度直接的区块
//$res = $client->getBlocks(10,15,true);
//获取最新区块头
//$res = $client->getLastHeader();

//获取节点是否同步
//$res = $client->isSync();
print_r($res);
//查询节点时间状态
//$res = $client->getTimeStatus();
//查询节点状态
//$res = $client->getNetInfo();
//获取远程节点列表
//$res = $client->getPeerInfo();


