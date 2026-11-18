<?php
include 'db.php';
$tittel = 'Slett klasse';
include 'header.php';

if (isset($_POST['slett'])) {
    $klassekode = trim($_POST['klassekode'] ?? '');

    if ($klassekode === '') {
        echo '<p class="feil">Du må velge en klasse.</p>';
    } else {
        // Ikke tillatt å slette en klasse som har studenter
        $sjekk = $db->prepare('SELECT COUNT(*) AS antall FROM student WHERE klassekode = ?');
        $sjekk->bind_param('s', $klassekode);
        $sjekk->execute();
        $antall = (int) $sjekk->get_result()->fetch_assoc()['antall'];
        $sjekk->close();

        if ($antall > 0) {
            echo '<p class="feil">Klassen ' . e($klassekode) . ' kan ikke slettes fordi den har ' . $antall
               . ' student(er). Slett eller flytt studentene først.</p>';
        } else {
            try {
                $stmt = $db->prepare('DELETE FROM klasse WHERE klassekode = ?');
                $stmt->bind_param('s', $klassekode);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    echo '<p class="ok">Klassen ' . e($klassekode) . ' er slettet.</p>';
                } else {
                    echo '<p class="feil">Fant ingen klasse med klassekode ' . e($klassekode) . '.</p>';
                }
                $stmt->close();
            } catch (mysqli_sql_exception $ex) {
                echo '<p class="feil">Kunne ikke slette klassen.</p>';
            }
        }
    }
}

// Dynamisk listeboks: hent klassene fra databasen
$klasser = $db->query('SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode');
?>
<?php if ($klasser->num_rows === 0): ?>
  <p>Det finnes ingen klasser å slette.</p>
<?php else: ?>
<form method="post" action="slett-klasse.php"
      onsubmit="return confirm('Er du sikker på at du vil slette denne klassen?');">
  <label>Klasse
    <select name="klassekode" required>
      <option value="">-- Velg klasse --</option>
      <?php while ($k = $klasser->fetch_assoc()): ?>
        <option value="<?= e($k['klassekode']) ?>">
          <?= e($k['klassekode']) ?> &ndash; <?= e($k['klassenavn']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </label>
  <button type="submit" name="slett">Slett klasse</button>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>
