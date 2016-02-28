<?php
namespace Squirrel\Controller;
trait CreateModelTrait{
    //实例化MySql
    public static function createMySql($bd_host,$db_user,$db_pass,$db_db=NULL)
    {
            return new \Squirrel\Model\MySql($bd_host,$db_user,$db_pass,$db_db);
    }
    //实例化Session
    public static function createSession($start=true)
    {
        return new \Squirrel\Model\Session($start);
    }
    //实例化Cookie
    public static function createCookie()
    {
        return new \Squirrel\Model\Cookie();
    }

    //实例化Request
    public static function createRequest()
    {
        return \Squirrel\Model\Request::createRequest();
    }
}