<?php
session_start();
require_once("proposalclass.php");

if(!isset($_SESSION['idmember'])){
    header("Location:login.php");
    exit();
}

$join = new Proposal();

$idmember = $_SESSION['idmember'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Proposal</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="detail-container">
    <h1>Your Proposal</h1>
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
        
        <div class="tableall">
            <?php

                $res = $join->getProposalbymember($idmember);
                    echo "<table border = '1'>";
                    echo "<tr>
                        <th>Nama Member</th>
                        <th>Nama Team </th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>";

                    while($row = $res->fetch_assoc()){
                        echo"<tr>
                        <td>".$row['member_name']."</td>
                        <td>".$row['team_name']."</td>
                        <td>".$row['description']."</td>
                        <td>".$row['status']."</td>
                        <td><a href='deleteprop.php?idjoin_proposal=" . $row['idjoin_proposal'] . "'>DELETE</a></td>
                        </tr>";
                    }
                    echo"</table>";
                        
            ?>

        </div>
    </div>
    
</body>
</html>