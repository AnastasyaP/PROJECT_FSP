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
        header("Location: proposalmember.php?success=Successfully cancel the join");
    } else {
        header("Location:proposalmember.php?failed=failed to cancel the join");
    }
?>