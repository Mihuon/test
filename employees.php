<!DOCTYPE html>
<html lang="cs">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam zaměstnanců</title>
</head>
<body class="container">
    <?php
        require_once "db.inc.php";
        echo "<h1>Seznam zaměstnanců</h1>
        <table class='table'>
            <tr>
                <th>Jméno<a href='?poradi=jmeno_up' class='sorted'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=jmeno_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th>
                <th>Místnost<a href='?poradi=mistnost_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=mistnost_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th>
                <th>Telefon<a href='?poradi=telefon_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=telefon_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th>
                <th>Pozice<a href='?poradi=pozice_up'><span class='glyphicon glyphicon-arrow-down' aria-hidden='true'></span></a><a href='?poradi=pozice_down'><span class='glyphicon glyphicon-arrow-up' aria-hidden='true'></span></a></th>
            </tr>";
        $employees = $pdo->query('SELECT e.employee_id as eId, e.name as eNa, e.surname as eSu, r.name as rNa, r.phone as rPh, e.job as eJo FROM employee e JOIN room r ON e.room = r.room_id');
        while($line = $employees->fetch())
        {
            echo "<tr><td><a href='employee.php?employeeId={$line->eId}'>{$line->eNa} {$line->eSu}</td><td>{$line->rNa}</td><td>{$line->rPh}</td><td>{$line->eJo}</td></tr>";
        }
        echo "</tr></table>";
    ?>
</body>
</html>