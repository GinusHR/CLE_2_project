<?php

if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header("Location: login.php?location=agenda.php");
    exit;
}
/** @var $db */
require_once 'includes/database.php';

$userID = $_SESSION['user']['id'];

$query = "SELECT users.name, users.email, dates.location, dates.datetime, dates.hours
            FROM users, dates
            WHERE users.id = $userID
            AND dates.user_id = $userID;";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$afspraken = [];
while($row = mysqli_fetch_assoc($result))
    $afspraken[] = $row;



?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Victoria Schoonmaakbedrijf - Agenda</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <?php
    include_once 'includes/nav.php'
    ?>
</header>
<main class="agendaMain">
        <h1>Uw Afspraken</h1>
    <?php if(!empty($afspraken)): ?>
        <table>
            <thead>
            <tr>
                <th>Naam</th>
                <th>Email</th>
                <th>Datum</th>
                <th>Aantal uren</th>
                <th>Locatie</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($afspraken as $index => $afspraak) { ?>
                <tr>
                    <td><?= $afspraak['name'] ?></td>
                    <td><?= $afspraak['email'] ?></td>
                    <td><?= $afspraak['datetime'] ?></td>
                    <td><?= $afspraak['hours'] ?></td>
                    <td><?= $afspraak['location'] ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="smalltaxt">
            <div>
                <p>Geen afspraken gevonden...</p>
            </div>
        </div>
    <?php endif; ?>
</main>
<footer>
    <?php
    include_once 'includes/footer.php'
    ?>
</footer>
</body>
</html>
