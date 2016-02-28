<?php
namespace Squirrel\Lib;
interface Db{
    //where 条件
    public function where($where);
    //order实现
    public function order();
    //limit实现
    public function limit($start=0,$s=NULL);
    //查询
    public function select();
    //开始一个事务
    public function start_transaction();
    //提交事务
    public function commit();
    //回滚事务
    public function rollback();
}
