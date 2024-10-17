<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" type="text/css" href="style.css">
    <title>Join Proposal</title>
</head>
<body>
    <?php
        require_once('proposalclass.php');
        $proposal = new Proposal();

        if(isset($_POST['action'])){
            $action = $_POST['action'];
            $idjoin = $_POST['idjoin_proposal'];
            $idteam = $_POST['idteam'];
            $idmember = $_POST['idmember'];
            $description =$_POST['description'];

            if($action =='approve'){
                $proposal->UpdateStatusApoproved($idjoin);

                $proposalData =[
                    'idteam'=>$idteam,
                    'idmember'=>$idmember,
                    'description'=>$description
                ];
    
                $proposal->InsertTeamMembers($proposalData);
                echo "Proposal approved!";
            }
            elseif($action =='reject'){
                $proposal-> UpdateStatusReject($idjoin);
                echo "Proposal approved!";
            }
        }
    ?>
    <section id="menu">
        <div class="logo">
            <img src="image/logo.png" alt="">
            <h2>Grizz Team</h2>
        </div>

        <div class ="items">
            <li><a href="adminhome.php">Dashboard</a></li>
            <li><a href="insertteam.php">Manage Team</a></li>
            <li><a href="insertgamenew.php">Manage Game</a></li>
            <li><a href="inserteventnew.php">Manage Event</a></li>
            <li></i><a href="insertachievement.php">Manage Achievement</a></li>
            <li><a href="joinproposaladmin.php">Join Proposal</a></li>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class = "n1">
                <div class="search">
                    <form action="joinproposaladmin.php" method="get">
                        <input type="text" name ="cari" placeholder="Search"  value="<?php echo @$_GET["cari"]; ?>">
                        <a class="reset-button" href="joinproposaladmin.php">Reset</a> 
                    </form>
                </div>
             <div class="profile">
                 <i class="bi bi-person-circle"></i>
             </div>
            </div>
        </div>

        <h3 class="i-name"> Join Proposal </h3>

        <div class="tableall">
            <?php

                $totaldata = 0;
                $perhal = 5;
                $currhal = 1;
        
                if(isset($_GET['offset'])){
                    $offset = intval($_GET['offset']);
                    $currhal = ($offset/5+1);
                } else{
                    $offset =0;
                }

                // search name
                if(isset($_GET['cari'])){
                    $res = $proposal->getProposalWaiting($_GET['cari'], $offset, $perhal);
                    $totaldata = $proposal->getTotalData($_GET['cari']);
                } else{
                    $res = $proposal->getProposalWaiting("", $offset, $perhal);
                    $totaldata = $proposal->getTotalData("");
                }

                $jmlhal = ceil($totaldata/$perhal);

                // $resproposal = $proposal->getProposalWaiting();
                if($res->num_rows > 0){

                    echo"<table border = '1'>";
                    echo "<tr>
                        <th>Nama Member</th>
                        <th>Nama Team</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                        
                    </tr>";
    
                        while($row = $res->fetch_assoc()){
                        echo"<form method='POST' action ='joinproposaladmin.php'>";
                        echo"<tr>
                            <td>".$row['member_name']."</td>
                            <td>".$row['team_name']."</td>
                            <td>".$row['description']."</td>
                            <td>".$row['status']."</td>
                            <td>
                                <input type='hidden' name='idjoin_proposal' value='" . $row['idjoin_proposal'] . "'>
                                <input type='hidden' name='idmember' value='" . $row['idmember'] . "'>
                                <input type='hidden' name='idteam' value='" . $row['idteam'] . "'>
                                <input type='hidden' name='description' value='" . $row['description'] . "'>
                                <button type='submit' name='action' value='approve' id=btnprop>Approve</button>
                                <button type='submit' name='action' value='reject' id=btnprop>Reject</button>
                            </td>
                            </tr>" ;
                        }
                    echo"</table>";
                    "</form>";
                }
                echo "<div>Total Data ".$totaldata."</div>";
                echo "<a href='joinproposaladmin.php?offset=0'>First</a> ";

                for($i = 1; $i <= $jmlhal; $i++) {
                    $off = ($i-1) * $perhal;
                    if($currhal == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        echo "<a href='joinproposaladmin.php?offset=".$off."'>".$i."</a> ";
                    }
                }
                $lastoffset = ($jmlhal - 1) * $perhal;
                echo "<a href='joinproposaladmin.php?offset=".$lastoffset."'>Last</a> ";
            ?>
        </div>
    </section>
</body>
</html>