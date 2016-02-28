<?php
//定义引擎路径
try {

    //预定义常量
    defined('ENGINE_DIR') or define('ENGINE_DIR',__DIR__);
    defined('DS') or define('DS', DIRECTORY_SEPARATOR);


    //初始化全局变量
    $INDEX_VENDER = NULL;
    $INDEX_MODULAR = NULL;
    $INDEX_CONTROLLER = NULL;
    $INDEX_FUNCTION = NULL;

    $INDEX_TEST = 'index test';

    //加载smarty
    include ENGINE_DIR.DS.'Vender/Smarty/Smarty.class.php';

    $INDEX_VENDER = new Smarty();


    //引入自动加载
    require_once __DIR__.'/Bin/LoaderClass.php';

    //注册自动加载函数
    spl_autoload_register('\\Squirrel\\Bin\\Loader::autoload');

    //使用路由解析
    Squirrel\Bin\Route::routeAnalysis();




}catch(Squirrel\Bin\SqException $e){
    $e->dispaly();
}

