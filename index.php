<?php
require "lib/Framework.class.php";

class MyFramework extends Framework {
	public function indexpage() {
		return 'Hello World!';
	}
	
	public function listbadgers() {
		return 'Hello from badgers!';
	}
}

$app = new MyFramework();

$app->get('', 'indexpage');

$app->get('badgers/:cheese', 'listbadgers');

$app->run();