<?php
include 'db.php';
$tittel = 'Registrer student';
include 'header.php';

if (isset($_POST['registrer'])) {
    $brukernavn = trim($_POST['brukernavn'] ?? '');
    $fornavn    = trim($_POST['fornavn'] ?? '');
    $etternavn  = trim($_POST['etternavn'] ?? '');
    $klassekode = trim($_POST['klassekode'] ?? '');

    if ($brukernavn === '' || $fornavn === '' || $etternavn === '' || $klassekode === '') {
        echo '<p class="feil">Alle felt må fylles ut (husk å velge klasse).</p>';
    } elseif (mb_strlen($brukernavn) > 7 || mb_strlen($fornavn) > 50 || mb_strlen($etternavn) > 50) {
        echo '<p class="feil">For lang tekst i ett eller flere felt (brukernavn maks 7 tegn).</p>';
    } else {
        // Sjekk om brukernavnet finnes fra før
        $sjekk = $db->prepare('SELECT 1 FROM student WHERE brukernavn = ?');
        $sjekk->bind_param('s', $brukernavn);
        $sjekk->execute();
        $finnes = $sjekk->get_result()->num_rows > 0;
        $sjekk->close();

        if ($finnes) {
            echo '<p class="feil">Brukernavnet ' . e($brukernavn) . ' finnes fra før. Velg et annet brukernavn.</p>';
        } else {
            try {
                $stmt = $db->prepare('INSERT INTO student (brukernavn, fornavn, etternavn, klassekode) VALUES (?, ?, ?, ?)');
                $stmt->bind_param('ssss', $brukernavn, $fornavn, $etternavn, $klassekode);
                $stmt->execute();
                $stmt->close();
                echo '<p class="ok">Studenten ' . e($fornavn) . ' ' . e($etternavn) . ' (' . e($brukernavn) . ') er registrert.</p>';
            } catch (mysqli_sql_exception $ex) {
                // Feiler f.eks. hvis klassekoden ikke finnes (fremmednøkkel)
                echo '<p class="feil">Kunne ikke registrere studenten. Sjekk at klassen finnes.</p>';
            }
        }
    }
}

// Dynamisk listeboks: hent klassene fra databasen
$klasser = $db->query('SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode');
?>
<?php if ($klasser->num_rows === 0): ?>
  <p class="feil">Det finnes ingen klasser ennå. <a href="registrer-klasse.php">Registrer en klasse</a> først.</p>
<?php else: ?>
<form method="post" action="registrer-student.php">
  <label>Brukernavn (maks 7 tegn)
    <input type="text" name="brukernavn" maxlength="7" required value="<?= e($_POST['brukernavn'] ?? '') ?>">
  </label>
  <label>Fornavn
    <input type="text" name="fornavn" maxlength="50" required value="<?= e($_POST['fornavn'] ?? '') ?>">
  </label>
  <label>Etternavn
    <input type="text" name="etternavn" maxlength="50" required value="<?= e($_POST['etternavn'] ?? '') ?>">
  </label>
  <label>Klasse
    <select name="klassekode" required>
      <option value="">-- Velg klasse --</option>
      <?php while ($k = $klasser->fetch_assoc()): ?>
        <option value="<?= e($k['klassekode']) ?>"<?= (($_POST['klassekode'] ?? '') === $k['klassekode']) ? ' selected' : '' ?>>
          <?= e($k['klassekode']) ?> &ndash; <?= e($k['klassenavn']) ?>
        </option>
      <?php endwhile; ?>
    </select>
  </label>
  <button type="submit" name="registrer">Registrer student</button>
</form>
<?php endif; ?>
<?php include 'footer.php'; ?>
