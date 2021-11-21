<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;

class NoteController extends AbstractController 
{
  public function createAction() {   
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

  public function showAction() {
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
  
       $this->view->render(
        'show', 
         ['note' => $note]
       );
  }

  public function listAction() {
         $this->view->render(
           'list',
           [
            'notes' => $this->database->getNotes(),
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam('error')
           ]
        );
  }

  public function editAction() {
  
}
 
}
