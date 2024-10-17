<?php
session_start();
require_once("proposalclass.php");

if(!isset($_SESSION['idmember'])){
    header("Location:login.php");
    exit();
}

$join = new Proposal();

$idmember = $_SESSION['idmember'];

if(isset($_POST['btnSubmit'])){
    $team = $_POST['team'];
    $description = $_POST['description'];

    $joinData = [
        'idteam' => $team,
        'idmember'=>$idmember,
        'description'=>$description
    ];

    // $join->insertJoinProposal($joinData);

    if($join->insertJoinProposal($joinData)){
        header("Location:proposalmember.php?success=Successfully do Join_proposal");
        exit();
    }else{
        header("Location:proposalmember.php?failed=Cannot do Join_proposal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" type="text/css" href="style.css">
    <title>Join Proposal</title>
</head>
<body>

    <div id="proposal-container">
        <div id="join">
            <form action="proposalmember.php" method="post">
            <h1>JOIN PROPOSAL</h1>
                <?php
            
                     if(isset($_GET['success'])){
                        $psn = $_GET['success'];
                         echo "<p class='success'>$psn</p>";
                    }
                    if(isset($_GET['failed'])){
                        $psnerror = $_GET['failed'];
                        echo "<p class='error'>$psnerror</p>";
                    }
                ?>
                <label for="team">Select Team : </label><br>
                <select name="team" id="team">
                    <option value="">Choose a Team</option>
                    <?php
                        $proposalData = $join->getTeam();
                        
                        while($row = $proposalData->fetch_assoc()){
                            echo"<option value=".$row['idteam'].">".$row['name']."</option>";
                        }
                    ?>
                </select><br><br>

                <label for="description">Description</label><br>
                <textarea name="description" id="description"></textarea><br><br>

                <input type="submit" name="btnSubmit" value="submit"><br><br>
            </form>
            <label id=detail>You Wannay see your join Proposal?<a href="detailproposal.php"> Detail Proposalp</a></label>
        </div>
    </div>
</body>
</html>