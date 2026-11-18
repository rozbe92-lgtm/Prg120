# PRG120V – Obligatorisk oppgave 1

PHP + MySQL/MariaDB-applikasjon for å vedlikeholde tabellene `klasse` og `student`.

## Filer

| Fil | Innhold |
|---|---|
| `index.php` | Meny der alle brukerfunksjonene kan velges |
| `db.php` | Databasetilkobling (leser `DB_HOST`, `DB_USER`, `DB_PASSWORD`, `DB_DATABASE`) |
| `schema.sql` | CREATE TABLE-setningene fra oppgaven + testdata |
| `registrer-klasse.php` / `registrer-student.php` | Registrering (med sjekk av duplikat nøkkel, listeboks for klassekode) |
| `vis-klasser.php` / `vis-studenter.php` | Visning av alle rader |
| `slett-klasse.php` / `slett-student.php` | Sletting (listeboks, «Er du sikker?», klasse med studenter kan ikke slettes) |
| `header.php` / `footer.php` | Felles sidemal |

## Oppsett

1. Kjør `schema.sql` i databasen din (som UTF-8).
2. Sett databaseinnstillingene i `db.php`, eller som miljøvariabler i dokploy.
3. Legg prosjektet i et GitHub-repo og deploy via dokploy (`https://dokploy.usn.no/app/BRUKERNAVN-REPONAVN`).
4. Lever lenken til besvarelsen i Canvas.
