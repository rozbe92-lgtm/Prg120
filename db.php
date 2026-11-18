<?php

$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';
$db_navn = getenv('DB_DATABASE') ?: 'prg120v';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // feil gir unntak
try {
    $db = new mysqli($db_host, $db_user, $db_pass, $db_navn);
    $db->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit('Kunne ikke koble til databasen. Sjekk innstillingene i db.php.');
}

// Hjelpefunksjon: trygg utskrift av tekst i HTML (beskytter mot XSS)
function e($tekst)
{
    return htmlspecialchars((string) $tekst, ENT_QUOTES, 'UTF-8');
}
