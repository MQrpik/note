<?php

declare(strict_types=1);

namespace App;

require_once("src/Utils/Request.php");
require_once("src/Utils/debug.php");
require_once("src/Controller.php");
require_once("src/Exception/AppException.php");

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use App\Request;
use Throwable;
 

$configuration = require_once("config\config.php");

$request = new Request($_GET, $_POST);

try {
//$controller = new Controller($request);
//$controller->run(); 

Controller::initConfiguration($configuration);
(new Controller($request))->run();
}catch (ConfigurationException $e){
  echo 'Wystąpił błąd w aplikacji';
  echo 'Skontaktuj się z administratorem';
} catch (AppException $e) {
  echo "Wystąpił błąd w aplikacji";
  echo '<h2>'. $e->getMessage() .'</h2>';
} catch (Throwable $e) {
  echo "Wystąpił błąd w aplikacji" ;
  dump($e);
}
