<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Event</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        require_once('eventclass.php');
        require_once('event_teamclass.php');
        $event = new Event();
        $eventeam = new Event_Team();
    ?>
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

            if ($isMember == 'true') {
                echo '<li><a href="proposalmember.php">Join Proposal</a></li>';
            }
            ?>
        </div>
    </section>

    <section id="interface">
        <div class="navigation">
            <div class = "n1">
                <div class="search">
                <form action="event.php" method="get">
                    <input type="text" name ="cari" placeholder="Search"  value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="memberhome.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

            <h3 class="i-name"> Our Activity🤩 </h3>
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
                    $res = $event->readEvent($_GET['cari'], $offset, $perhal);
                    $totaldata = $event->getTotalData($_GET['cari']);
                } else{
                    $res = $event->readEvent("", $offset, $perhal);
                    $totaldata = $event->getTotalData("");
                }
        
                $jmlhal = ceil($totaldata/$perhal);

                echo "<table border = '1'>";
                echo "<tr>
                        <th>Nama event</th>
                        <th>Date </th>
                        <th>Description</th>
                        <th>Team</th>
                    </tr>";
                while($row = $res->fetch_assoc()){
                    $formatrilis = strftime("%d %B %Y", strtotime($row['date']));

                    $reseventeam = $eventeam->readEventWithTeam($row['idevent']);
                    
                    $team = array();
                    while($rowteam = $reseventeam->fetch_assoc()){
                        $team[]=$rowteam['name'];
                    }
                    $team = implode(",",$team);
                    echo"<tr>
                        <td>".$row['name']."</td>
                        <td>".$formatrilis."</td>
                        <td>".$row['description']."</td>
                        <td>".$team."</td>
                    </tr>";
                }
                echo"</table>";

                // paging tabel team
                echo "<div>Total Data ".$totaldata."</div>";
                echo "<a href='event.php?offset=0'>First</a> ";

                for($i = 1; $i <= $jmlhal; $i++) {
                    $off = ($i-1) * $perhal;
                    if($currhal == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        echo "<a href='event.php?offset=".$off."'>".$i."</a> ";
                    }
                }
                $lastoffset = ($jmlhal - 1) * $perhal;
                echo "<a href='event.php?offset=".$lastoffset."'>Last</a> ";
            ?>
        </div>
    </section>
     </body>
</html>