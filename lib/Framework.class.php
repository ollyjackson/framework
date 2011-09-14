<?php
class Framework {
	public $urlpatterns, $requestmethod, $requesturi;

	function __construct() {
		$this->requestmethod = $_SERVER['REQUEST_METHOD'];
		$this->requesturl = $_REQUEST['p'];
		return;
	}

	public function get($url, $function) {
		$this->urlpatterns[] = array('url'=>$url, 'function'=>$function);
		return;
	}

	public function run() {
		$this->urlpatterns = array_reverse($this->urlpatterns);

		foreach ($this->urlpatterns as $pattern) {
			preg_match_all('/:\w*/', $pattern['url'], $matches);
			$matches = array_shift($matches);
			foreach($matches as $match) {
				$vars[] = substr($match, 1);
			}
			// TODO: improve regex below to stop at slashes
			$pattern['url'] = preg_replace('/:\w*/', '(\w+)', $pattern['url']);
			$pattern['url'] = '/'.str_replace('/', '\/', $pattern['url']) . '/';
			if (preg_match($pattern['url'], $this->requesturl, $matches) == 1) {
				$this->requestvars = array($vars[0] => $matches[1]);
				echo $this->{$pattern['function']}();
				break;
			}
		}

		return;
	}
}
?>