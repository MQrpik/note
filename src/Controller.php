<?php

declare(strict_types=1);

namespace App;

require_once("src/Database.php");
require_once("src/View.php");
require_once("src/Exception/ConfigurationException.php");

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Request;
class Controller
{
  private const DEFAULT_ACTION = 'list';

  private static array $configuration = [];

  private Database $database;
  private Request $request;
  private View $view;

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

  public function create() {   
        if ($this->request->hasPost()) {
           
          $this->database->createNote([
            'title' => $this->request->postParam('title'),
            'description' => $this->request->postParam('description')
          ]);
          header('Location: /?before=created');
          exit;
        }
        $this->view->render('create');
  }

  public function show() {
         $noteId = (int) $this->request->getParam('id');
        if (!$noteId) {
          header ('Location: /?error=missingNoteId');
          exit;
        }

        try {
          $note = $this->database->getNote($noteId); 
        } catch (NotFoundException $e) {
          header('Location: /?error=noteNotFound');
          exit;
        }
         $viewParams = [
            'note' => $note
        ];
       $this->view->render('show');
  }

  public function list() {
         $this->view->render(
           'list',
           [
            'notes' => $this->database->getNotes(),
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam('error')
           ]
           );
  }

  public function run(): void
  {
    switch ($this->action()) {
      case 'create':
        $this->create();
      break;

      case 'show':
        $this->show();
      break;

      default:
        $this->list();
      break;
    } 
  }

  private function action(): string
  {
    return $this->request->getParam('action', self::DEFAULT_ACTION);
  }
}
