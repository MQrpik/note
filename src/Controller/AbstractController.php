<?php

declare(strict_types=1);

namespace App;

require_once("src/Exception/ConfigurationException.php");
require_once("src/Database.php");
require_once("src/View.php");

use App\Exception\ConfigurationException;
use App\Request;

abstract class AbstractController 
{
  protected const DEFAULT_ACTION = 'list';

  private static array $configuration = [];

  protected Database $database;
  protected Request $request;
  protected View $view;

  public static function initConfiguration(array $configuration) : void
  {
    self::$configuration = $configuration;
  }

  public function __construct(Request $request)
  {
    if (empty(self::$configuration['db'])) {
      throw new ConfigurationException('Configuration problem');
    }
    $this->database = new Database(self::$configuration['db']);
    $this->request = $request;
    $this->view = new View();
    
  }

  
  public function run(): void
  { 
    /* switch ($this->action()) {
      case 'create':
        $this->create();
      break;

      case 'show':
       $this->show();
      break;

      default:
       $this->list();
      break; 
      Ten kod robił dokłądnie to co poniżej i był bardziej intuicyjny ale nie wiedziec czemu VS traktował go jako błędny (a działał) 
      wiec zastosowalem ten krótszy ale trudniejszy w czytaniu.
    } */
    {
      $action = $this->action() . 'Action';
      if (!method_exists($this, $action)){
       $action = self::DEFAULT_ACTION . 'Action'; 
      }else {
        $this->$action();
      }

      
    }
  }
    
  private function action(): string
  {
    return $this->request->getParam('action', self::DEFAULT_ACTION);
  }
}
