<?php

declare(strict_types=1);

namespace App;

require_once("src/Exception/ConfigurationException.php");
require_once("src/Database.php");
require_once("src/View.php");

use App\Exception\ConfigurationException;
use App\Request;
use Collator;

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
    switch ($this->action()) {
      case 'create':
      $this->createRecord();
      break;

      case 'show':
       $this->showRecord();
      break;

      default:
       $this->listRecord();
      break;
    } 
  }
    
  private function action(): string
  {
    return $this->request->getParam('action', self::DEFAULT_ACTION);
  }
}
