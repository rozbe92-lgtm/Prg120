<?php
include 'db.php';
$tittel = 'Registrer klasse';
include 'header.php';

if (isset($_POST['registrer'])) {
    $klassekode  = trim($_POST['klassekode'] ?? '');
    $klassenavn  = trim($_POST['klassenavn'] ?? '');
    $studiumkode = trim($_POST['studiumkode'] ?? '');

    if ($klassekode === '' || $klassenavn === '' || $studiumkode === '') {
        echo '<p class="feil">Alle felt må fylles ut.</p>';
    } elseif (mb_strlen($klassekode) > 5 || mb_strlen($klassenavn) > 50 || mb_strlen($studiumkode) > 50) {
        echo '<p class="feil">For lang tekst i ett eller flere felt (klassekode maks 5 tegn).</p>';
    } else {
        // Sjekk om klassekoden finnes fra før
        $sjekk = $db->prepare('SELECT 1 FROM klasse WHERE klassekode = ?');
        $sjekk->bind_param('s', $klassekode);
        $sjekk->execute();
        $finnes = $sjekk->get_result()->num_rows > 0;
        $sjekk->close();

        if ($finnes) {
            echo '<p class="feil">Klassekoden ' . e($klassekode) . ' finnes fra før. Velg en annen klassekode.</p>';
        } else {
            try {
                $stmt = $db->prepare('INSERT INTO klasse (klassekode, klassenavn, studiumkode) VALUES (?, ?, ?)');
                $stmt->bind_param('sss', $klassekode, $klassenavn, $studiumkode);
                $stmt->execute();
                $stmt->close();
                echo '<p class="ok">Klassen ' . e($klassekode) . ' (' . e($klassenavn) . ') er registrert.</p>';
            } catch (mysqli_sql_exception $ex) {
                echo '<p class="feil">Kunne ikke registrere klassen.</p>';
            }
        }
    }
}
?>
<form method="post" action="registrer-klasse.php">
  <label>Klassekode (maks 5 tegn)
    <input type="text" name="klassekode" maxlength="5" required value="<?= e($_POST['klassekode'] ?? '') ?>">
  </label>
  <label>Klassenavn
    <input type="text" name="klassenavn" maxlength="50" required value="<?= e($_POST['klassenavn'] ?? '') ?>">
  </label>
  <label>Studiumkode
    <input type="text" name="studiumkode" maxlength="50" required value="<?= e($_POST['studiumkode'] ?? '') ?>">
  </label>
  <button type="submit" name="registrer">Registrer klasse</button>
</form>
<?php include 'footer.php'; ?>
