<?php
    require_once("teamclass.php");

    if(isset($_POST['btnSubmit'])){
        // extract($_POST);
        $teamName = $_POST['name'];
        $games = $_POST['game'];

        $team = new Team();

        foreach($games as $game){
            $teamData = [
                'idgame' => $game,
                'name' => $teamName
            ];
        }

        $team->insertTeam($teamData);
    }
    header("Location: insertteam.php?result=success");
    exit();
?>