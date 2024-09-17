<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel ="stylesheet" href="style.css">
</head>
<body>
    <?php
    include 'koneksi.php';
    ?>
    <section id="menu">
        <div class="logo">
            <img src="image/logo.png" alt="">
            <h2>Grizz Team</h2>
        </div>
        <div class ="items">
            <li><a href="adminhome.php">Dashboard</a></li>
            <li><a href="insertteam.php">Manage Team</a></li>
            <li><a href="insertgame.php">Manage Game</a></li>
            <li><a href="inserteventnew.php">Manage Event</a></li>
            <li></i><a href="achievement.php">Manage Achievement</a></li>
            <li><a href="#">Join Proposal</a></li>
        </div>
    </section>
    <section id ="interface">
        <div class="navigation">
            <div class = "n1">
            <div class="search">
                <form action="adminhome.php" method="get">
                    <input type="text" name ="cari"placeholder="Search">
                    <a href="adminhome.php" class="reset-button">Reset</a>
                </form>
                </div>
            </div>
            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>
        <h3 class="i-name"> DashBoard </h3>
        <div class="tableall">
        <?php 
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
                echo "<b>Hasil pencarian : ".$cari."</b>";
            }
        ?>
        <?php
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
                $stmt = $mysqli->prepare("SELECT t.idteam, t.name as teamname, t.idgame, g.name as gamename FROM team t INNER JOIN game g ON t.idgame = g.idgame WHERE t.name LIKE '%".$cari."%' OR g.name LIKE '%".$cari."%'");
            }else{
                $stmt = $mysqli->prepare("SELECT t.idteam, t.name as teamname, t.idgame, g.name as gamename FROM team t INNER JOIN game g ON t.idgame = g.idgame");
            }
            $stmt->execute();
            $res = $stmt->get_result();
            
            echo "<table>";
            echo "<tr>
                    <th>Team ID</th>
                    <th>Game</th>
                    <th>Team Name</th>
                    <th colspan=2>Action</th>
                </tr>";

            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td>".$row['idteam']."</td>
                        <td>".$row['gamename']."</td>
                        <td>".$row['teamname']."</td>
                        <td><a href='editteam.php?idteam=".$row['idteam']."'>EDIT</a></td>
                        <td><a href='deleteteam.php?idteam=" . $row['idteam'] . "'>DELETE</a></td>

                    </tr>";
            }
            echo "</table>";
            $mysqli->close();
        ?>
        </div>
    </section>
</body>
</html>