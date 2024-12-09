<?php
session_start();
require_once("proposalclass.php");
require_once("eventclass.php");
require_once("achievementclass.php");  
require_once("teamclass.php"); 

if(!isset($_SESSION['idmember'])){
    header("Location: login.php");
    exit();
}

$join = new Proposal();
$event = new Event();
$team = new Team();
$achievement = new Achievement();

$idmember = $_SESSION['idmember'];

$isMember = false;

if(isset($_POST['btnlogout'])){
    session_destroy();
   $isMember = false;
}

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
        header("Location:proposalmember.php?success=Successfully do Join proposal");
        exit();
    }else{
        header("Location:proposalmember.php?failed=Cannot do Join proposal");
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

    <section id="menu">
        <div class="logo">
            <img src="image/logo.png" alt="">
            <h2>Grizz Team</h2>
        </div>

        <div class ="items">
            <li><a href="memberhome.php">Dashboard</a></li>
            <li><a href="team.php">Team</a></li>
            <li><a href="game.php">Game</a></li>
            <li><a href="event.php">Event</a></li>
            <li><a href="achievement.php">Achievement</a></li>
            <?php
                $isMember = false; 

                if(isset($idmember)){
                    if($idmember){
                        $isMember = true;
                        echo '<li><a href="proposalmember.php">Join Proposal</a></li>';
                    } else{
                        $isMember = false;
                    }
                }
            ?>
        </div>
    </section>

    <section id ="interface">
        <div class="navigation">
            <div class = "n1">
                <div class="search">
                <form action="insertachievement.php" method="get">
                    <input type="text" name ="cari" placeholder="Search" value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="insertachievement.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>
        <h3 class="i-name"> Join Proposal😎 </h3>

        <div class="tableall"> <!-- id="proposal-container" -->
            <div> <!-- id="join" -->
                <form action="proposalmember.php" method="post">
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
                    <label for="team">Select Team : </label>
                    <select name="team" id="team">
                        <option value="">Choose a Team</option>
                        <?php
                            $proposalData = $join->getTeam();
                            
                            while($row = $proposalData->fetch_assoc()){
                                echo"<option value=".$row['idteam'].">".$row['name']."</option>";
                            }
                        ?>
                    </select><br><br>

                    <label for="description">Description</label>
                    <textarea name="description" id="description"></textarea><br><br>

                    <input type="submit" name="btnSubmit" value="Submit"><br><br>
                    <!-- <label id=detail>You Wanna see your join Proposal?<a href="detailproposal.php"> Detail Proposal</a></label> -->
                </form>
                <!-- detail join proposal -->

                <?php

                if(!isset($_GET['view'])){


                    $totaldata = 0;
                    $perhal = 2;
                    $currhal = 1;
            
                    if(isset($_GET['offset'])){
                        $offset= intval($_GET['offset']);
                        $currhal = ($offset/2+1);
                    } else{
                        $offset =0;
                    }

                    $res = $join->getProposalbymember($idmember, $offset, $perhal);
                    $totaldata = $join->getTotalDataPropByMember($idmember);

                    $jmlhal = ceil($totaldata/$perhal);

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
                            <td>";
                            if($row['status']=='approved'){
                                echo '<a href="proposalmember.php?idmember=' . $idmember .  '&idteam=' . $row['idteam'] .'&view=true">View Member</a>';
                            }
                            elseif($row['status']=='rejected'){
                                echo'<a href="deleteprop.php?idjoin_proposal=' . $row['idjoin_proposal'] . '">DELETE</a>';
                            }
                            else{
                                echo 'Tidak Tersedia';
                            }
                                
                            echo "</td>
                            </tr>";
                        }
                        echo"</table>";       
                        echo "<div>Total Data ".$totaldata."</div>";
                        echo "<a href='proposalmember.php?offset=0'>First</a> ";
            
                        for($i = 1; $i <= $jmlhal; $i++) {
                            $off = ($i-1) * $perhal;
                            if($currhal == $i) {                
                                echo "<strong style='color:red'>$i</strong>";
                            } else {
                                echo "<a href='proposalmember.php?offset=".$off."'>".$i."</a> ";
                            }
                        }
                        $lastoffset = ($jmlhal- 1) * $perhal;
                        echo "<a href='proposalmember.php?offset=".$lastoffset."'>Last</a><br><br>";
                    }
                ?>

                <?php
                if(isset($_GET['idmember']) && isset($_GET['idteam']) && $_GET['view'] && $_GET['view']=='true'){
                    echo "<h3> Your Team Member😎</h3><br>";
                    $idmemberUrl = $_GET['idmember'];
                    $idteam = $_GET['idteam'];

                    $totaldatamem = 0;
                    $perhalmem = 2;
                    $currhalmem = 1;
        
                    if(isset($_GET['offsetmem'])){
                        $offsetmem = intval($_GET['offsetmem']);
                        $currhalmem = ($offsetmem/2+1);
                    } else{
                        $offsetmem =0;
                    }
                    $resmemberteam = $team->getMember($idmemberUrl,$idteam,$offsetmem,$perhalmem);
                    $totaldatamem = $team->getTotalDatamemberTeam($idmemberUrl,$idteam);

                    $jmlhalmem = ceil($totaldatamem/$perhalmem);
                    echo "<table border='1'>";
                    echo"<tr>
                        <th>Team Member</th>
                        <th>Team Name</th>
                    </tr>";

                    while($row = $resmemberteam->fetch_assoc()){
                        echo"<tr>
                            <td>".$row['memberName']."</td>
                            <td>".$row['teamName']."</td>

                        </tr>";
                    }
                    echo"</table>";
                    echo '<a class="btn" href="proposalmember.php">Back</a>';
                    echo "<div>Total Data ".$totaldatamem."</div>";
                    echo "<a href='proposalmember.php?offset=0'>First</a> ";
            
                        for($i = 1; $i <= $jmlhalmem; $i++) {
                            $offmem = ($i-1) * $perhalmem;
                            if($currhalmem == $i) {                
                                echo "<strong style='color:red'>$i</strong>";
                            } else {
                                echo "<a href='proposalmember.php?offset=".$offmem."'>".$i."</a> ";
                            }
                        }
                    $lastoffsetmem = ($jmlhalmem- 1) * $perhalmem;
                    echo "<a href='proposalmember.php?offsetmem=".$lastoffsetmem."'>Last</a><br><br>";
                }
                ?>
            
                    <!--Event Data-->
                 <h3> Your Team Event😎</h3><br>
                <?php
                    $totaldataevent = 0;
                    $perhalevent= 2;
                    $currhalevent = 1;

                    if(isset($_GET['offsetevent'])){
                        $offsetevent = intval($_GET['offsetevent']);
                        $currhalevent = ($offsetevent/2+1);
                    } else{
                        $offsetevent =0;
                    }
            
                    $resevent = $event->getEventByID($idmember,$offsetevent,$perhalevent);
                    $totaldataevent= $event->getTotalDataEvent($idmember);

                    $jmlhalevent = ceil($totaldataevent/$perhalevent);

                    echo"<table border = '1'>";
                    echo"<tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Description</th>
                    </tr>";

                    while($row = $resevent->fetch_assoc()){
                        echo"<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['date']."</td>
                            <td>".$row['description']."</td>
                        </tr>";
                    }
                    echo"</table>";
                    echo "<div>Total Data ".$totaldataevent."</div>";
                        echo "<a href='proposalmember.php?offsetevent=0'>First</a> ";
            
                        for($i = 1; $i <= $jmlhalevent; $i++) {
                            $offevent = ($i-1) * $perhalevent;
                            if($currhalevent== $i) {                
                                echo "<strong style='color:red'>$i</strong>";
                            } else {
                                echo "<a href='proposalmember.php?offsetevent=".$offevent."'>".$i."</a> ";
                            }
                        }
                        $lastoffsetevent = ($jmlhalevent - 1) * $perhalevent;
                        echo "<a href='proposalmember.php?offsetevent=".$lastoffsetevent."'>Last</a><br><br>";  
                ?>
                 <h3> Your Team Achievement😎</h3><br>
                <?php
                     $totaldataach = 0;
                     $perhalach = 2;
                     $currhalach = 1;
 
                    if(isset($_GET['offsetach'])){
                        $offsetach= intval($_GET['offsetach']);
                        $currhalach = ($offsetach/2+1);
                    } else{
                        $offsetach =0;
                    }

                    $resachievement = $achievement->getAchievementBymember($idmember,$offsetach,$perhalach);
                    $totaldataach = $achievement->getTotalDataAchievement($idmember);

                    $jmlhalach = ceil($totaldataach/$perhalach);

                    echo"<table border = '1'>";
                    echo"<tr>
                        <th>Achievement Name</th>
                        <th>Achievement Date</th>
                        <th>Description</th>
                    </tr>";

                    while($row = $resachievement->fetch_assoc()){
                        echo"<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['date']."</td>
                            <td>".$row['description']."</td>
                        </tr>";
                    }
                    echo"</table>";
                    echo "<div>Total Data ".$totaldataach."</div>";
                        echo "<a href='proposalmember.php?offset=0'>First</a> ";
            
                        for($i = 1; $i <= $jmlhalach;$i++) {
                            $offach = ($i-1) * $perhalach;
                            if($currhalach == $i) {                
                                echo "<strong style='color:red'>$i</strong>";
                            } else {
                                echo "<a href='proposalmember.php?offsetach=".$offach."'>".$i."</a> ";
                            }
                        }
                    $lastoffsetach= ($jmlhalach - 1) * $perhalach;
                    echo "<a href='proposalmember.php?offset=".$lastoffsetach."'>Last</a><br><br>";    
                ?>
            </div>
        </div>
    </section>
</body>
</html>