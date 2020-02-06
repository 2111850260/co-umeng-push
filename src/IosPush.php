<?php

/**
 * CREATED BY ZLW
 * 时间: 2020/2/5 14:15
 **/
namespace CoUmeng\Push;
//require_once (dirname(__FILE__) . '/Upush.php');

class IosPush
{
    use Upush;
    public function __construct(Array $config)
    {
        $this->config = $config;
        $this->time = time();
    }

    public function pushMsg(String $token, String $content)
    {
        $this->_build($token, $content);
        $this->_requestMessage($this->config['APP_MASTER_SECRET']);
    }

    private function _build(String $token, String $content)
    {
        $content = json_decode($content, true);
        if ($content) {
            $this->body = [
                "description" => $this->description,
                "appkey" => $this->config['APPKEY'],
                "timestamp" => (string)$this->time,
                "type" =>"unicast",//单播
                "device_tokens" => $token,//手机设备token
                "payload" => [
                    "display_type" => "notification",//通知
                    "aps" => [
                        "alert" => [
                            "subtitle" => (string) $content['subtitle'],//通知栏提示文字
                            "title" => (string) $content['title'],//通知标题
                            "body" => (string) $content['body'],//通知文字描述
                        ]
                    ],
                ],
                "production_mode" => "{$this->config['MESSAGE_DEBUG']}",//true/false 正式/测试环境 测试模式只对“广播”、“组播”类消息生效，其他类型的消息任务（如“文件播”）不会走测试模式 测试模式只会将消息发给测试设备。测试设备需要到web上添加。
            ];
        }

    }

}