<?php
namespace Squirrel\Model;
class Request{
    private static $request = NULL;

    private function __construct()
    {

    }
    //获取请求的时间
    public function getTime($float = false)
    {
        return $float?$_SERVER['REQUEST_TIME_FLOAT']:$_SERVER['REQUEST_TIME'];
    }
    //获取客服端IP
    public function getIp()
    {
        if(isset($_SERVER['REMOTE_ADDR'])){
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    //单例模式
    public static function createRequest()
    {
        if(self::$request){
            return self::$request;
        }else {
            self::$request = new self();
            return self::$request;
        }
    }
}