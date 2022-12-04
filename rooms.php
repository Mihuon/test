<!DOCTYPE html>
<html lang="cs">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam místností</title>
</head>
<body class="container">
    <?php
        require_once "db.inc.php";
        echo "<h1>Seznam místností</h1>
        <table class='table'>
            <tr>
                <th>Název<a href='?poradi=nazev_up' class='sorted'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=nazev_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th>
                <th>Číslo<a href='?poradi=cislo_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=cislo_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th>
                <th>Telefon<a href='?poradi=telefon_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=telefon_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th>
            </tr>";
            $rooms = $pdo->query('SELECT r.room_id as rId, r.name as rNa, r.no as rNo, r.phone as rPh FROM room r');
            while($line = $rooms->fetch())
            {
                echo "<tr><td><a href='room.php?roomId={$line->rId}'>{$line->rNa}</td><td>{$line->rNo}</td><td>{$line->rPh}</td></tr>";
            }
            echo "</tr></table>";
    ?>
</body>