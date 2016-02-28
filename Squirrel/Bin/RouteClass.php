<?php
namespace Squirrel\Bin;
class Route{
	public static function routeAnalysis()
	{
		//取得url参数
		$pathInfo = $_SERVER['PATH_INFO'];
		//去除参数两端空格
		$pathInfo = trim($pathInfo);
		$pathInfo = substr($pathInfo,1);

		$pathArry = explode('/',$pathInfo);

		//记录执行的信息
		$GLOBALS['INDEX_MODULAR'] = $pathArry[0];
		$GLOBALS['INDEX_CONTROLLER'] = $pathArry[1];
		$GLOBALS['INDEX_FUNCTION'] = $pathArry[2];

		//执行操作
		self:: runFunctio($pathArry[0],$pathArry[1],$pathArry[2]);
	}
	//执行操作
	public static function runFunctio($modular,$controller,$function)
	{	
		//获取项目目录
		$path = $_SERVER['DOCUMENT_ROOT'];

		$class = '\\'.$modular.'\\'.'Controller\\'.$controller.'Controller';
		//实例化类，并执行操作
		(new $class)->$function();
	}
}
