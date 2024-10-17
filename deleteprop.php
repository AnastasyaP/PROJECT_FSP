<?php
    session_start();
    require_once("proposalclass.php");
    
    if(!isset($_SESSION['idmember'])){
        header("Location:login.php");
        exit();
    }
    
    $join = new Proposal();
    
    $id = $_GET['idjoin_proposal'];

    $affected_rows = $join->getDeleteProposal($id);
    //echo "Affected rows: " . $affected_rows;

    if($affected_rows > 0){
        header("Location: detailproposal.php?success=sucess to delete");
    } else {
        header("Location:detailproposal.php?unsucess to delete");
    }
?>