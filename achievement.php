<?php
    session_start();
    $isMember = false;

    require_once("achievementclass.php");
    $achievement = new Achievement();

    if(isset($_SESSION['idmember'])){
        $idmember = $_SESSION['idmember'];
        $isMember =true;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Achievement</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
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
                if($isMember === true){
                    echo '<li><a href="proposalmember.php">Join Proposal</a></li>';
                }
            ?>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class = "n1">
                <div class="search">
                <form action="achievement.php" method="get">
                    <input type="text" name ="cari" placeholder="Search" value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="memberhome.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>
        <h3 class="i-name"> What We Achieve🏅 </h3>
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
                    $res = $achievement->readAchievement($_GET['cari'], $offset, $perhal);
                    $totaldata = $achievement->getTotalData($_GET['cari']);
                } else{
                    $res = $achievement->readAchievement("", $offset, $perhal);
                    $totaldata = $achievement->getTotalData("");
                }
        
                $jmlhal = ceil($totaldata/$perhal);  

                if($res->num_rows > 0){
                    echo "<table border=1>
                    <tr>
                        <th>ID</th>
                        <th>Team</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Description</th>
                    </tr>";

                    while($row = $res->fetch_assoc()){
                        $formatrilis = strftime("%d %B %Y", strtotime($row['date']));

                        echo "<tr>
                        <td>".$row['idachievement']."</td>
                        <td>".$row['teamname']."</td>
                        <td>".$row['achievename']."</td>
                        <td>".$formatrilis."</td>
                        <td>".$row['description']."</td>
                        </tr>";
                    }
                    echo "</table>";
                }

                echo "<div>Total Data ".$totaldata."</div>";
                echo "<a href='achievement.php?offset=0'>First</a> ";

                for($i = 1; $i <= $jmlhal; $i++) {
                    $off = ($i-1) * $perhal;
                    if($currhal == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        echo "<a href='achievement.php?offset=".$off."'>".$i."</a> ";
                    }
                }
                $lastoffset = ($jmlhal - 1) * $perhal;
                echo "<a href='achievement.php?offset=".$lastoffset."'>Last</a> ";
            ?>
        </div>
    </section>
</body>
</html>