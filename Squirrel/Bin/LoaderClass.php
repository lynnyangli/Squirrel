<?php
namespace Squirrel\Bin;
class Loader{
	public static function autoload($className)
	{
		$classArray = new \SplFixedArray(3);
		$classArray = explode('\\',$className,3);

		//if(count($classArray)!=3){
		//	throw new \Squirrel\Bin\SqExecotion($className,111);
		//}

		if($classArray[0] == 'Squirrel'){
				if($classArray[1] == 'Lib'){
					$file = ENGINE_DIR . "/$classArray[1]" . "/$classArray[2]" . 'Interface.php';
				}else {
					$file = ENGINE_DIR . "/$classArray[1]" . "/$classArray[2]" . 'Class.php';
				}
		}else{
			$app_path = $_SERVER['DOCUMENT_ROOT'];
			$file = $app_path.'/'.$classArray[0]."/$classArray[1]"."/$classArray[2]".'Class.php';
		}
		if(!file_exists($file)){

		}
		include $file;
	}
}
