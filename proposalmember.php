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
                            <td>";
                            if($row['status']=='approved'){
                                echo'<a href="proposalmember.php?idmember=' . $idmember . '">View Member</a>';
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
                        echo"</table><br><br>";       
                ?>

                <h3> Your Team Member😎</h3><br>
                <?php
                if(isset($_GET['idmember'])){
                    $idmemberUrl = $_GET['idmember'];
                    $resmemberteam = $team->getMember($idmemberUrl);
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
                    echo"</table><br><br>";
                }
                ?>
            
                    <!--Event Data-->
                 <h3> Your Team Event😎</h3><br>
                <?php
                    $resevent = $event->getEventByID($idmember);
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
                    echo"</table><br><br>";  
                ?>
                 <h3> Your Team Achievement😎</h3><br>
                <?php
                    $resachievement = $achievement->getAchievementBymember($idmember);
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
                    echo"</table><br><br>";  
                ?>
            </div>
        </div>
    </section>
</body>
</html>