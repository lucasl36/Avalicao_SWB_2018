<?php

namespace app\components;

use Yii;

class FileHelper 
{

	public static function listActions()
	{
		$controllerlist = [];
		if ($handle = opendir('../controllers')) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
					$controllerlist[] = $file;
				}
			}
			closedir($handle);
		}
		asort($controllerlist);
		$fulllist = [];
		foreach ($controllerlist as $controller):
			$handle = fopen('../controllers/' . $controller, "r");
			if ($handle) {
				while (($line = fgets($handle)) !== false) {
					if (preg_match('/public function action(.*?)\(/', $line, $display)):
						if (strlen($display[1]) > 2):
							$fulllist[substr($controller, 0, -4)][] = strtolower($display[1]);
						endif;
					endif;
				}
			}
			fclose($handle);
		endforeach;
		return $fulllist;
	}
	
}

