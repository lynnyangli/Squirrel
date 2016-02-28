<?php
namespace Admin\Controller;
use Squirrel\Controller\Controller;
class IndexController extends Controller{
	function Index()
	{
		//echo '<h1>Welcome Squirrel</h1>';

		//$this->assign('content','<h1>Welcome Squirrel</h1>');
		//$this->display();
		echo 'Change';
		header('Location:http://127.0.0.1:8088/test.php');


	}
}
