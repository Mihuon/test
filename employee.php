<?php
$id = filter_input(INPUT_GET,
    'employeeId',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range"=> 1]]
);

if ($id === null || $id === false) 
{
    http_response_code(400);
    $status = "bad_request";
} 
else 
{
    require_once "db.inc.php";

    $employees = $pdo->prepare("SELECT e.employee_id as eId, e.name as eNa, e.surname as eSu, e.job as eJo, e.wage as eWa, r.name as rNa, r.room_id as rId, k.room as kRo FROM employee e JOIN room r ON e.room = r.room_id JOIN `key` k ON k.room = r.room_id WHERE e.employee_id=:employeeId");
    $keys = $pdo->query("SELECT r.name as rNa, r.room_id as rId FROM room r JOIN `key` k ON r.room_id = k.room WHERE k.employee = $id");
    $employees->execute(['employeeId' => $id]);
    if ($employees->rowCount() === 0) {
        http_response_code(404);
        $status = "not_found";
    } else {
        $line = $employees->fetch();
        $status = "ok";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karta místnosti</title>
</head>
<body class="container">
    <?php
    echo "
        <h1>Karta osoby: <em>{$line->eSu} {$line->eNa}</em></h1>
        <dl class='dl-horizontal'>
            <dt>Jméno</dt><dd>{$line->eNa}</dd>
            <dt>Příjmení</dt><dd>{$line->eSu}</dd>
            <dt>Pozice</dt><dd>{$line->eJo}</dd>
            <dt>Mzda</dt><dd>{$line->eWa}</dd>
            <dt>Místnost</dt><dd><a href='room.php?roomId={$line->rId}'>{$line->rNa}</a></dd>
            <dt>Klíče</dt><dd>";
            while($row = $keys->fetch())
            {
                echo "<a href='room.php?roomId={$row->rId}'>{$row->rNa}</a><br>";
            }
            echo "</dd>";
    echo "</dl><a href='employees.php'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Zpět na seznam zaměstnanců</a>";
    ?>
</body>