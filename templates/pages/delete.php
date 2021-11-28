<div class="show">
  <?php 
  $note = $params['note'] ?? null; ?>
  <?php if ($note) :  ?>
  
  <ul>
    <li>Id: <?php echo $note['id'] ?></li>
    <li>Tytuł: <?php echo $note['title'] ?></li>
    <li>Opis: <?php echo $note['description'] ?></li>
    <li>Data dodania: <?php echo $note['created'] ?></li>
  </ul>
    <form method="POST" action="?action=delete">
    <input type="hidden" name="id" value="<?php echo $note['id'] ?>" />
    <input type="submit" value="Usuń" />
    </form>
  <a href="/">
  <button>Powrót do listy</button>
  </a>
  <?php else: ?>
    <div>
      Brak notatki do wyświetlenia 
    </div>
    <?php endif; ?>
</div> 