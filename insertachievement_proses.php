<?php
    require_once("achievementclass.php");

    if(isset($_POST['btnSubmit'])){
        $team = $_POST['team'];
        $name = $_POST['achievement'];
        $date = $_POST['date'];
        $description = $_POST['description'];

        $achievement = new Achievement();

        $achievementData = [
            'idteam' => $team,
            'name' => $name,
            'date' => $date,
            'description' => $description
        ];

        $achievement->insertAchievement($achievementData);
    }
    header("Location: insertachievement.php?result=success");
    exit();
?>