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
  <?php 
   // dump($params);
      $sort = $params['sort'] ?? [];
      $by = $sort['by'] ?? 'title';
      $order = $sort['order'] ?? 'desc';
      
      $page = $params['page'] ?? [];
      $size = $page['size'] ?? 10;
      $number = $page['number'] ?? 1;
      $pages = $page['pages'] ?? 1;

      $phrase = $params['phrase'] ?? null; 
  ?>

    <div>
    <form class="settings-form" action="/" method="GET">
  <div>
<label>Wyszukaj:<input type="text" name="phrase" value="<?php echo $phrase ?>"/></label>
  </div>
     <div>
 <div>Sortuj po:</div>
        <label>Tytule: <input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked' : '' ?> /></label>
        <label>Dacie: <input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked' : '' ?> /></label>
  </div>
  <div>
    <div>Kierunek sortowania:</div>
      <label>Rosnąco: <input name="sortorder" type="radio" value="asc" <?php echo $order === 'asc' ? 'checked' : '' ?> /></label>
      <label>Malejąco: <input name="sortorder" type="radio" value="desc" <?php echo $order === 'desc' ? 'checked' : '' ?> /></label>
    </div>
    <div>
      <div>Rozmiar pagera</div>
      <label>1 <input name="pagesize" type="radio" value="1" <?php echo $size === 1 ? 'checked' : '' ?> /></label>
      <label>5 <input name="pagesize" type="radio" value="5" <?php echo $size === 5 ? 'checked' : '' ?> /></label>
      <label>10 <input name="pagesize" type="radio" value="10" <?php echo $size === 10 ? 'checked' : '' ?> /></label>
      <label>25 <input name="pagesize" type="radio" value="25" <?php echo $size === 25 ? 'checked' : '' ?> /></label>
    </div>
    <input type="submit" value="Sortuj" />
    </form>
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
  <ul class="pagination">
  <?php 
  $paginationUlr = "&phrase=$phrase&pagesize=$size&sortby=$by&sortorder=$order";
  if($number >1 ) { ?>
  <li>
    <a href="/?page=<?php echo $number - 1 . $paginationUlr?>"> 
    <button><<</button>
    </a></li> <?php } ?>
    <?php for($i =1; $i <= $pages; $i++): ?>
      <li>
        <a href="/?page=<?php echo $i . $paginationUlr ?>">
          <button><?php echo $i ?></button>
        </a>
      </li>
  <?php endfor; ?>
   <?php if($number < $pages ) { ?>
  <li>
    <a href="/?page=<?php echo $number + 1 . $paginationUlr ?>"> 
    <button>>></button>
    </a></li>
    <?php } ?>
</ul>
</section>
</div>