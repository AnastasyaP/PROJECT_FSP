<?php
    //include 'koneksi.php';
    require_once("eventclass.php");
    require_once("event_teamclass.php");

    $id = $_GET['idevent'];
    
    $event = new Event();
    $eventeam = new Event_Team();

    $affectedevent = $event->deleteEvent($id);
    $affectedeventteam = $eventeam->deleteEvenTeam($id);

    if($affectedevent > 0 && $affectedeventteam > 0  ){
        header("Location: inserteventnew.php?status=success");
        exit();
    } else {
        header("Location: inserteventnew.php?status=failure");
        exit();
    }
?>