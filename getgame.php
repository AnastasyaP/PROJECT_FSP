<?php
require_once('gameclass.php');
$game = new Game();

$offset = $_POST['offset'];
$perhal = 3;
$cari = $_POST['cari'];

if(isset($cari)){
    $res = $game->readGame($cari, $offset, $perhal);
} else{
    $res = $game->readGame("", $offset, $perhal);
}

while($row = $res->fetch_assoc()){
    echo"<tr>
        <td>".$row['name']."</td>
        <td>".$row['description']."</td>
    </tr>";
}
?>