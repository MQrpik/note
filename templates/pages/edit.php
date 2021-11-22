<?php 
  if (!empty($params)): ?>
<?php $note = $params['note'] ?? null; ?>
 
<div>
  <h3> Edycja notatki: <?php echo $note['title'] ?></h3>
  <div>
      <form class="note-form" action="/?action=edit" method="post">
      <input name="id" type="hidden" value=<?php echo $note['id'] ?> />
        <ul>
          <li>
            <label>Tytuł <span class="required">*</span></label>
            <input type="text" name="title" class="field-long" value="<?php echo $note['title'] ?>" />
          </li>
          <li>
            <label>Treść</label>
            <textarea name="description" id="field5" class="field-long field-textarea"><?php echo $note['description'] ?></textarea>
          </li>
          <li>
            <input type="edit" value="Submit" />
          </li>
        </ul>
      </form>
  
  </div>
</div>
<?php else: ?>
Błąd edycji <a href="/">Wróć</a>
<?php endif ?>