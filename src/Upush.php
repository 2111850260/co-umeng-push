<?php
namespace Umeng\Push;

trait Upush{

    protected $description ="省小二推送";
    protected $config=[];
    protected $time;
    protected $body = [];
    protected $url="http://msg.umeng.com/api/send";

    protected function _requestMessage($masterSecret)
    {
        $sign = $this->_createSign($masterSecret);
        $this->url = $this->url ."?sign=" . $sign;
        try{
            go(function (){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $this->url);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 2);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->body));
                $response = json_decode(curl_exec($ch), true);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlErrNo = curl_errno($ch);
                $curlErr = curl_error($ch);
                $output = curl_exec($ch);
                if ($response['ret'] !== 'SUCCESS') {
                    throw new Exception('error' . $response['data']['error_msg']);
                }
            });
        } catch (\Exception $e) {
            throw  new Exception('error:' . $e->getMessage());
        }


    }

    protected function _createSign($masterSecret)
    {
        $sign = md5("POST" . $this->url . json_encode($this->body) . $masterSecret);
        return strtolower($sign);
    }
}