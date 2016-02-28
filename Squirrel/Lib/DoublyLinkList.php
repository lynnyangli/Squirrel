<?php

interface DoubltLinkedList{
    //回到头结点
    public function rewind();
    //取节点数据
    public function current();
    //下移一个节点
    public function next();
    //移向上一个节点
    public function prev();
    //top端增加节点
    public function push($value);
    //在bottom端添加节点
    public function unshigt($value);
    //删除节点
    public function pop();
}