<?php
namespace Squirrel\Controller;
use Squirrel\Controller\CreateModelTrait;
class Controller{
    use CreateModelTrait;

    public $vender;
    function __construct()
    {
        $this->vender = $GLOBALS['INDEX_VENDER'];
        $smartyConfig = $this->setSmarty();
    }

    private function setSmarty()
    {
        $viewPath = './'.$GLOBALS['INDEX_MODULAR'].'/View/';
        $comPath = './'.$GLOBALS['INDEX_MODULAR'].'/Com/';
        $l_delimiter = '<!--{';
        $r_delimiter = '}-->';

        $this->vender->setLeftDelimiter($l_delimiter);
        $this->vender->setRightDelimiter($r_delimiter);

        $this->vender->setTemplateDir($viewPath)->
                        setCompileDir($comPath);
    }
    function assign($name,$var)
    {
        $this->vender->assign($name,$var);
    }
    function display($file=NULL)
    {
        if(is_null($file)){
            $file = 'index.html';
        }
        $this->vender->display($file);
    }


}