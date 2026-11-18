<?php
include 'db.php';
$tittel = 'Slett student';
include 'header.php';

if (isset($_POST['slett'])) {
    $brukernavn = trim($_POST['brukernavn'] ?? '');

    if ($brukernavn === '') {
        echo '<p class="feil">Du må velge en student.</p>';
    } else {
        $stmt = $db->prepare('DELETE FROM student WHERE brukernavn = ?');
        $stmt->bind_param('s', $brukernavn);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo '<p class="ok">Studenten ' . e($brukernavn) . ' er slettet.</p>';
        } else {
            echo '<p class="feil">Fant ingen student med brukernavn ' . e($brukernavn) . '.</p>';
        }
        $stmt->close();
    }
}

// Dynamisk listeboks: hent studentene fra databasen
$studenter = $db->query('SELECT brukernavn, fornavn, etternavn FROM student ORDER BY brukernavn');
?>
<?php if ($studenter->num_rows === 0): ?>
  <p>Det finnes ingen studenter å slette.</p>
<?php else: ?>
<form method="post" action="slett-student.php"
      onsubmit="return confirm('Er du sikker på at du vil slette denne studenten?');">
  <label>Student
    <select name="brukernavn" required>
      <option value="">-- Velg student --</option>
      <?php while ($s = $studenter->fetch_assoc()): ?>
        <option value="<?= e($s['brukernavn']) ?>">
          <?= e($s['brukernavn']) ?> &ndash; <?= e($s['fornavn']) ?> <?= e($s['etternavn']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </label>
  <button type="submit" name="slett">Slett student</button>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>
