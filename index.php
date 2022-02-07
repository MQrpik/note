<?php

declare(strict_types=1);

/* Kod popniżej to ręczy autoloader, ale można by to zastąpić Composerem, i tak sie dzieje w 90% projektow */
spl_autoload_register(function(string $classNamespace) {
  $path = str_replace(['\\','App/'],['/',''], $classNamespace);
  $path = "src/$path.php";
  require_once($path);
});

require_once("src/Utils/debug.php");
$configuration = require_once("config\config.php");

use App\Request;
use App\Controller\NoteController;
use App\Exception\AppException;
use App\Exception\ConfigurationException;
 
$request = new Request($_GET, $_POST, $_SERVER);

try {
NoteController::initConfiguration($configuration);
(new NoteController($request))->run();
}catch (ConfigurationException $e){
  echo 'Wystąpił błąd w aplikacji';
  echo 'Skontaktuj się z administratorem';
} catch (AppException $e) {
  echo "Wystąpił błąd w aplikacji";
  echo '<h2>'. $e->getMessage() .'</h2>';
} catch (\Throwable $e) {
  echo "Wystąpił błąd w aplikacji" ;
  dump($e);
}
