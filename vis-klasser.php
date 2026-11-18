<?php
include 'db.php';
$tittel = 'Alle klasser';
include 'header.php';

$resultat = $db->query('SELECT klassekode, klassenavn, studiumkode FROM klasse ORDER BY klassekode');
?>
<?php if ($resultat->num_rows === 0): ?>
  <p>Ingen klasser er registrert.</p>
<?php else: ?>
<table>
  <tr><th>Klassekode</th><th>Klassenavn</th><th>Studiumkode</th></tr>
  <?php while ($rad = $resultat->fetch_assoc()): ?>
    <tr>
      <td><?= e($rad['klassekode']) ?></td>
      <td><?= e($rad['klassenavn']) ?></td>
      <td><?= e($rad['studiumkode']) ?></td>
    </tr>
  <?php endwhile; ?>
</table>
<?php endif; ?>
<?php include 'footer.php'; ?>
