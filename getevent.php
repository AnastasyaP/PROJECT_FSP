<?php
require_once('eventclass.php');
require_once('event_teamclass.php');
$event = new Event();
$eventeam = new Event_Team();
$offset = $_POST['offset'];
$perhal = 4;
$cari = $_POST['cari'];

if(isset($cari)){
    $res = $event->readEvent($cari, $offset, $perhal);
} else{
    $res = $event->readEvent("", $offset, $perhal);
}

while($row = $res->fetch_assoc()){
    $formatrilis = strftime("%d %B %Y", strtotime($row['date']));

    $reseventeam = $eventeam->readEventWithTeam($row['idevent']);
    
    $team = array();
    while($rowteam = $reseventeam->fetch_assoc()){
        $team[]=$rowteam['name'];
    }
    $team = implode(",",$team);
    echo"<tr>
        <td>".$row['name']."</td>
        <td>".$formatrilis."</td>
        <td>".$row['description']."</td>
        <td>".$team."</td>
    </tr>";
}
?>
