<div class="show">
  <?php 
  $note = $params['note'] ?? null; 
  dump($note['title']);
  ?>
  <ul>
    <li>Id: <?php echo htmlentities($note['id']) ?></li>
    <li>Tytuł: <?php echo htmlentities($note['title']) ?></li>
    <li>Opis: <?php echo htmlentities($note['description']) ?></li>
    <li>Data dodania: <?php echo htmlentities($note['created']) ?></li>
  </ul>
  <a href="/">
  <button>Powrót do listy</button>
  </a>
</div> 