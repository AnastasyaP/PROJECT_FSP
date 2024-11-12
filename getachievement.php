<?php
    require_once("achievementclass.php");
    $achievement = new Achievement();

    $offset = $_POST['offset'];
    // $perhal = $_POST['perhalaman'];
    $perhal = 2 ;
    $cari = $_POST['cari'];

    if(isset($cari)){
        $res = $achievement->readAchievement($cari, $offset, $perhal);
    } else{
        $res = $achievement->readAchievement("", $offset, $perhal);
    }

    while($row = $res->fetch_assoc()){
        $formatrilis = strftime("%d %B %Y", strtotime($row['date']));

        echo "<tr>
        <td>".$row['teamname']."</td>
        <td>".$row['achievename']."</td>
        <td>".$formatrilis."</td>
        <td>".$row['description']."</td>
        </tr>";
    }
?>