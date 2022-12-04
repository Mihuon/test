<?php
$id = filter_input(INPUT_GET,
    'roomId',
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

    $rooms = $pdo->prepare("SELECT r.room_id as rId, r.no as rNo, r.name as rNa, r.phone as rPh FROM room r WHERE r.room_id=:roomId");
    $employees = $pdo->query("SELECT e.employee_id as eId, e.name as eNa, e.surname as eSu, e.wage as eWa FROM employee e WHERE e.room = $id");
    $keys = $pdo->query("SELECT k.employee as kEm, e.employee_id as eId, e.name as eNa, e.surname as eSu FROM `key` k JOIN employee e ON k.employee = e.employee_id WHERE k.room = $id");
    $rooms->execute(['roomId' => $id]);
    if ($rooms->rowCount() === 0) {
        http_response_code(404);
        $status = "not_found";
    } else {
        $line = $rooms->fetch();
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
    <title>Karta osoby</title>
</head>
<body class="container">
    <?php
    echo "
        <h1>Místnost č. {$line->rNo}</h1>
        <dl class='dl-horizontal'>
            <dt>Číslo</dt><dd>{$line->rNo}</dd>
            <dt>Název</dt><dd>{$line->rNa}</dd>
            <dt>Telefon</dt><dd>{$line->rPh}</dd>
            <dt>Lidé</dt><dd>";
            $mzda = 0;
            $pocet = 0;
            while($row = $employees->fetch())
            {
                echo "<a href='employee.php?employeeId={$row->eId}'>{$row->eNa} {$row->eSu}</a><br>";
                $mzda += $row->eWa;
                $pocet++;
            }
            echo "</dd>";
            if($pocet!=0)
            $mzda /= $pocet;
            else 
            $mzda = "-";
    echo"
        <dt>Průměrná mzda</dt><dd>{$mzda}</dd>
            <dt>Klíče</dt><dd>";
            while($row = $keys->fetch())
            {
                echo "<a href='employee.php?employeeId={$row->eId}'>{$row->eNa} {$row->eSu}</a><br>";
            }
            echo "</dd>";
    echo "</dl><a href='rooms.php'><span class='glyphicon glyphicon-arrow-left' aria-hidden='true'></span> Zpět na seznam místností</a>";
    ?>
</body>