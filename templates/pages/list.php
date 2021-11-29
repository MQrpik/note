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
          case 'deleted':
            echo 'Notatka została usunięta';
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
    <div>
    <div>
    <form class="settings-form" action="/" method="GET">
      <div>Sortuj po:</div>
        <label>Tytuł: <input name="sortby" type="radio" value="title"/></label>
        <label>Data: <input name="sortby" type="radio" value="date"/></label>
   </div>
    <div>
    <div>Kierunek sortowania:</div>
      <label>Rosnąco: <input name="sortorder" type="radio" value="asc"/></label>
      <label>Malejąco: <input name="sortorder" type="radio" value="desc"/></label>
    </div>
    </form>
  </div>
  <div> 

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
            <td><a href="/?action=show&id=<?php echo $note['id'] ?>"> <button>Pokaż</button></a>
           <a href="/?action=delete&id=<?php echo $note['id'] ?>"> <button>Usuń</button></a></td>
          </tr>
        <?php endforeach; ?>
     </tbody>
   </table>
</div>
</section>
</div>