<?php
    session_start();
    $isMember = false;

    require_once('teamclass.php');
    $team = new Team();

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
    <title>Home</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
    <!-- <style>
        .team-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start; /* Rata kiri */
    gap: 20px; /* Jarak antar card */
    width: 100%; /* Ambil lebar penuh */
    padding: 20px;
}

.team-card {
    flex: 1 1 200px; /* Minimal 200px */
    max-width: 250px; /* Batas maksimal */
}

.team-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.team-container, .team-card, .team-image {
    border: 1px solid red !important; /* Cek batas elemen */
}

.teamdetail-container {
    padding: 15px;
    text-align: center;
}

.team-name {
    font-size: 18px;
    font-weight: bold;
    color: #0b1957;
    margin-top: 10px;
}

.team-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

    </style> -->
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

    <section id ="interface">
        <div class="navigation">
            <div class = "n1">
            <div class="search">
                <form action="team.php" method="get">
                    <input type="text" name ="cari" placeholder="Search" id ="caridata"value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="index.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

        <h3 class="i-name"> Our Team💖 </h3>
        <div class = "team-container">
            <?php
             $totaldata = 0;
             $perhal = 3;
             $currhal = 1;
     
            if(isset($_GET['offset'])){
                 $offset = intval($_GET['offset']);
                 $currhal = ($offset/$perhal+1);
            } else{
                 $offset =0;
                 $currhal = 1;
            }

            if(isset($_GET['cari'])){
                $res = $team->readTeam($_GET['cari'], $offset, $perhal);
                $totaldata = $team->getTotalData($_GET['cari']);
            } else{
                $res = $team->readTeam("", $offset, $perhal);
                $totaldata = $team->getTotalData("");
            }
              while ($row = $res->fetch_assoc()) {
                    $teamPict = $row["idteam"].".jpg";
                    if(!file_exists("image/".$teamPict)) {
                         $teamPict = "blank.jpg";
                    }    
                     
                    echo "<div class ='team-card'>
                            <img src='image/$teamPict?".time()."' alt='Team Picture' width=150 class='team-image'>
                            <div class='teamdetail-container'>
                                <h4 class='team-name'>" . htmlspecialchars($row['teamname']) ."</h4>
                            </div>

                    </div>"; 
                }
            ?>
        </div>

        <div class="paging">
            <?php
                $jmlhal = ceil($totaldata / $perhal);
                echo "<div id=total>Total Data: $totaldata</div>";

                if ($currhal >= 1) {
                    echo "<a href='team.php?offset=0'>First</a> ";
                    $prevOffset = ($currhal - 2) * $perhal; // Offset halaman sebelumnya
                }

                for ($i = 1; $i <= $jmlhal; $i++) {
                    $off = ($i - 1) * $perhal;
                    if ($currhal == $i) {
                        echo "<strong style='color:red;'>$i</strong> ";
                    } else {
                        echo "<a href='team.php?offset=$off'>$i</a> ";
                    }
                }

                if ($currhal <= $jmlhal) {
                    $lastoffset = ($jmlhal - 1) * $perhal;
                    echo "<a href='team.php?offset=$lastoffset'>Last</a> ";
                }
            ?>
        </div>
    </section>
</body>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous"></script>
    <script>
        var offset = 0
        var perhalaman = 2;

        $("body").on("click",'#loadmore',function(){
            var cari = $("#caridata").val();
            offset += perhalaman;
            $.post("getteam.php",{offset:offset,cari:cari},function(data){
                $("#tableteam").append(data);
            });
        });
    </script> -->
</html>