<?php


namespace chain33\phpsdk\lib\http;

class Request
{
    /**
     * @param string $method
     * @param array $params
     * @return array
     * @author zhaeng <zhangf@disanbo.com>
     * @time: 2019/12/27 11:16
     */
    public static function sendRequest(string $method,$params = [])
    {
        $id = time();
        try {
            $curl = new Curl();
            $data = [
                'id' => $id,
                "jsonrpc" => "2.0",
                'method' => $method,
                'params' => empty($params) ? [] : [$params]
            ];

            $curl->setData(json_encode($data));
            $curl->setHeader(['Content-Type:application/json']);
            $res = $curl->post();
            $res = $res ? $res : ['id' => $id,'result' => [],'error' => 'request fail'];
        } catch (\Exception $e) {
            $res = ['id' => $id,'result' => [],'error' => $e->getMessage()];
        }
        unset($res['id']);
        return $res;
    }
}