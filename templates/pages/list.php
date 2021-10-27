<div class="list">
  <section>
  <div class="message">
    <?php 
    if(!empty($params['before'])){
        switch($params['before']) {
          case 'created':
            echo 'Notatka została utworzona';
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
            <td><?php echo htmlentities($note['id'])  ?></td>
            <td><center><?php echo htmlentities($note['title']) ?></center></td>
            <td><?php echo htmlentities($note['created'])  ?></td>
            <td> <a href="/?action=show&id=<?php echo htmlentities($note['id']) ?>">Pokaż</a></td>
          </tr>
        <?php endforeach; ?>
     </tbody>
   </table>
</div>
</section>
</div>