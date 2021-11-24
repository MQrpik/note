<div class="list">
  <section>
  <div class="message">
    <?php 
    if(!empty($params['before'])){
        switch($params['before']) {
          case 'created':
            echo 'Notatka została utworzona';
          break;
          case 'edited':
            echo 'Notatka została edytowana';
          break;
        }}
    if(!empty($params['error'])){
        switch($params['error']) {
          case 'noteNotFound':
            echo 'Notatka nie została odnaleziona';
          break;
          case 'missingNoteId':
            echo 'Niepoprawne ID notatki';
          break;
        }
  } ?>
  
  </div>

  <div class="tbl-header">  
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tytuł</th>
           <th>Utworzony</th>
          <th>Opcje</th>
        </tr>
      </thead>
    </table>
</div>
<div class="tbl-content">
   <table cellpadding="0" cellspacing="0" border="0">
     <tbody>
        <?php foreach ($params['notes'] ?? [] as $note): ?>
          <tr>
            <td><?php echo $note['id']  ?></td>
            <td><center><?php echo $note['title'] ?></center></td>
            <td><?php echo $note['created']  ?></td>
            <td><a href="/?action=show&id=<?php echo $note['id'] ?>"> <button>Pokaż</button></a></td>
          </tr>
        <?php endforeach; ?>
     </tbody>
   </table>
</div>
</section>
</div>