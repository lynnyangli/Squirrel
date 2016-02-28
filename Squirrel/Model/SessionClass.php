<?php

namespace Squirrel\Model;

class Session implements \ArrayAccess
{
    public function __construct($start=true)
    {
        if($start) {
            //开启session会话
            session_start();
        }
    }
    //开启或重现现有回话
    public function start(array $options = [])
    {
        return session_start($options);
    }
    //session是否开启
    public function isActive()
    {
        if(isset($_SESSION)){
            return true;
        }else{
            return false;
        }
    }
    public function __destruct()
    {
        session_write_close();
        //关闭session会话
        session_register_shutdown();
    }
    //get session's id
    function get_id()
    {
        return session_id();
	}
    //get session's name
    function get_name()
    {
        return session_name();
    }
    //get session's save path
    function get_save_path()
    {
        return session_save_path();
    }
    //关闭write_session
    function write_close()
    {
        session_write_close();
    }
    //注册变量
    function set($name,$value)
    {
        if(isset($value)){
            $_SESSION[$name] = $value;
            session_write_close();
            return true;
        }else{
            return false;
        }
    }
    //取得变量
    public function get($name)
    {
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }else{
            return NULL;
        }
    }
    //删除变量
    function remove($name)
    {
        if(isset($_SESSION[$name])){
            unset($_SESSION[$name]);
            session_write_close();
            return true;
        }else{
            return false;
        }
    }
    //shutdwon session
    function shutdown()
    {
        session_register_shutdown();
    }
    //destroy all data
    function destory()
    {
        session_destroy();
    }
    //get module name
    function get_module_name()
    {
        return session_module_name();
    }

    //偏移位置是否存在
    public function offsetExists($offset)
    {
           return isset($_SESSION[$offset])?true:false;
    }
    //获取一个偏移位置的值
    public function offsetGet($offset)
    {
        return $_SESSION[$offset];
    }
    //设置一个偏移位置的值
    public function offsetSet($offset,$value)
    {
        $_SESSION[$offset] = $value;
    }
    //复位一个偏移位置的值
    public function offsetUnset($offset)
    {
        if(isset($_SESSION[$offset])){
            unset($_SESSION[$offset]);
        }
        return true;
    }

}