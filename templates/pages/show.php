

  <tbody>
        <?php foreach ($params['note'] ?? [] as $note): ?>
          <tr>
            <td><?php echo htmlentities($note['id'])  ?></td>
            <td><center><?php echo htmlentities($note['title']) ?></center></td>
            <td><?php echo htmlentities($note['created'])  ?></td>
            <td><?php echo htmlentities($note['description'])  ?></td>
            <td> <a href="/?action=show&id=<?php echo htmlentities($note['id']) ?>">Pokaż</a></td>
          </tr>
        <?php endforeach; ?>