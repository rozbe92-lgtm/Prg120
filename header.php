<?php
// Felles topp for alle sider. Bruk: $tittel = '...'; include 'header.php';
?>
<!DOCTYPE html>
<html lang="no">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($tittel ?? 'PRG120V Oppgave 1') ?></title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 760px; margin: 2rem auto; padding: 0 1rem; }
    nav a { margin-right: 1rem; }
    label { display: block; margin-top: .8rem; }
    input[type=text], select { padding: .3rem; min-width: 16rem; }
    button { margin-top: 1rem; padding: .4rem 1rem; }
    table { border-collapse: collapse; margin-top: 1rem; }
    th, td { border: 1px solid #999; padding: .3rem .8rem; text-align: left; }
    .ok { color: #176b17; font-weight: bold; }
    .feil { color: #b00020; font-weight: bold; }
  </style>
</head>
<body>
<p><a href="index.php">&larr; Til meny</a></p>
<h1><?= e($tittel ?? '') ?></h1>
