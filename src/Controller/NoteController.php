<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;

class NoteController extends AbstractController 
{
  private const PAGE_SIZE = 10;

  public function createAction() {   
        if ($this->request->hasPost()) {
          $this->database->createNote([
            'title' => $this->request->postParam('title'),
            'description' => $this->request->postParam('description')
          ]);
          $this->redirect('before=created');
        }
        $this->view->render('create');
  }

  public function showAction() {
      $note = $this->getNote();
  
       $this->view->render(
        'show', 
         ['note' => $note]
       );
  }

  public function listAction() {

        $pageSize = (int) $this->request->getParam('pagesize', self::PAGE_SIZE);
        $pageNumber = (int) $this->request->getParam('page', 1);
        $sortBy = $this->request->getParam('sortby', 'title');
        $sortOrder = $this->request->getParam('sortorder', 'desc');
        if (!in_array($pageSize, [1, 5, 10, 25])) {
          $pageSize = self::PAGE_SIZE;
        }

        $note = $this->database->getNotes($pageNumber, $pageSize, $sortBy, $sortOrder);

        $this->view->render(
           'list', 
           [
            'sort' => [
              'by' => $sortBy,
              'order' => $sortOrder
            ],
            'page' => ['number' => $pageNumber, 'size' => $pageSize],
            'notes' => $note,
            'before' => $this->request->getParam('before'),
            'error' => $this->request->getParam('error')
           ]
        );
  }

  public function editAction() {

    if($this->request->isPost()) {
      $noteId = (int)$this->request->postParam('id');
      $noteData = [
        'title' => $this->request->postParam('title'),
        'description' => $this->request->postParam('description')
      ];
      $this->database->editNote($noteId, $noteData);
      $this->redirect('before=edited');
    }
    
     $note = $this->getNote();
   
       $this->view->render(
        'edit', 
         ['note' => $note]
       ); 
}

  public function deleteAction(): void {

  if($this->request->isPost()){
    $id = (int)$this->request->postParam('id');
    $this->database->deleteNote($id);
    $this->redirect('before=deleted');
  }
   $this->view->render(
        'delete', 
         ['note' => $this->getNote()]
       ); 
}

private function redirect (string $to) {
header("Location: /?$to");
exit;
}
  private function getNote(): array {
   $noteId = (int)$this->request->getParam('id');
    if (!$noteId) {
      $this->redirect('error=missingNoteId');
    }  
    try {
          $note = $this->database->getNote($noteId); 
        } catch (NotFoundException $e) {
          $this->redirect('error=noteNotFound');
        }
    return $note;
  }

}
