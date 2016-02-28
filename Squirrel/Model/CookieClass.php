<?php
namespace Squirrel\Model;

class Cookie implements \ArrayAccess{
    //设置cookie
    public function set($name,$value,$time=NULL,$path='/')
    {
        return setcookie($name,$value,$time,$path);
    }
    //获取cookie
    public function get($name)
    {
        if(isset($_COOKIE[$name])){
            return $_COOKIE[$name];
        }else{
            return false;
        }
    }
    //移除cookie
    public function remove($name,$path='/')
    {
        return setcookie($name,'',time()-3600,$path);
    }
    public function offsetExists($offset)
    {
        return isset($_COOKIE[$offset])?true:false;
    }
    public function offsetGet($offset)
    {
        if(isset($_COOKIE[$offset])){
            return $_COOKIE[$offset];
        }else{
            return false;
        }
    }
    public function offsetSet($offset, $value)
    {
        return setcookie($offset,$value);
    }
    public function offsetUnset($offset)
    {
        if(isset($_COOKIE[$offset])){
            setcookie($offset,'',time()-3600);
            unset($_COOKIE[$offset]);
        }
    }
}