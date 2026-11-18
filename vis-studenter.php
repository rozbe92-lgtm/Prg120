<?php
include 'db.php';
$tittel = 'Alle studenter';
include 'header.php';

$resultat = $db->query('SELECT brukernavn, fornavn, etternavn, klassekode FROM student ORDER BY brukernavn');
?>
<?php if ($resultat->num_rows === 0): ?>
  <p>Ingen studenter er registrert.</p>
<?php else: ?>
<table>
  <tr><th>Brukernavn</th><th>Fornavn</th><th>Etternavn</th><th>Klassekode</th></tr>
  <?php while ($rad = $resultat->fetch_assoc()): ?>
    <tr>
      <td><?= e($rad['brukernavn']) ?></td>
      <td><?= e($rad['fornavn']) ?></td>
      <td><?= e($rad['etternavn']) ?></td>
      <td><?= e($rad['klassekode']) ?></td>
    </tr>
  <?php endwhile; ?>
</table>
<?php endif; ?>
<?php include 'footer.php'; ?>
