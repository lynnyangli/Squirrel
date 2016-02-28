<?php
namespace Squirrel\Bin;
class SqException extends \Exception{
    function dispaly()
    {
        echo '<b>'.$this->getMessage().'</b>';
        echo 'on'.$this->getLine().'  '.$this->getLine().'行';
        echo '<br>号'.$this->getCode();
    }
}