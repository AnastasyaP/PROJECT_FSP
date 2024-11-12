<?php
require_once('teamclass.php');
$team = new Team();

$offset = $_POST['offset'];
$perhal = 2;
$cari = $_POST['cari'];

if(isset($_GET['cari'])){
    $res = $team->readTeam($cari, $offset, $perhal);
} else{
    $res = $team->readTeam("", $offset, $perhal);
    $totaldata = $team->getTotalData("");
}

while ($row = $res->fetch_assoc()) {
    echo "<tr>
            <td>".$row['teamname']."</td>
            <td>".$row['gamename']."</td>
        </tr>";
}
?>