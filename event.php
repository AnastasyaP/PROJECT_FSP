<?php
    session_start();
    $isMember = false;

    require_once('eventclass.php');
    require_once('event_teamclass.php');
    $event = new Event();
    $eventeam = new Event_Team();

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
    <title> Event</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <section id="menu">
        <div class="logo">
            <img src="image/logo.png" alt="">
            <h2>Grizz Team</h2>
        </div>

        <div class ="items">
            <li><a href="index.php">Dashboard</a></li>
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
                <form action="event.php" method="get">
                    <input type="text" name ="cari" placeholder="Search" id="caridata" value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="index.php">Reset</a> 
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
                $perhal = 4;
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

                echo "<table border = '1' id='tableevent'>";
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
                // echo "<a href='event.php?offset=0'>First</a> ";

                // for($i = 1; $i <= $jmlhal; $i++) {
                //     $off = ($i-1) * $perhal;
                //     if($currhal == $i) {                
                //         echo "<strong style='color:red'>$i</strong>";
                //     } else {
                //         echo "<a href='event.php?offset=".$off."'>".$i."</a> ";
                //     }
                // }
                // $lastoffset = ($jmlhal - 1) * $perhal;
                // echo "<a href='event.php?offset=".$lastoffset."'>Last</a> ";
            ?>
            <button type="button" id=loadmore>Load More</button>
        </div>
    </section>
    </body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous"></script>
    <script>
        var offset = 0;
        var perhalaman = 4;

        $("body").on("click", "#loadmore",function(){
            var cari = $("#caridata").val();
            offset += perhalaman;
            $.post("getevent.php",{offset:offset,cari:cari},function(data){
                $("#tableevent").append(data);
            });
        });
    </script>
</html>