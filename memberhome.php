<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        require_once("teamclass.php");
        $team = new Team();
        $idmember = $_GET['idmember']; 
    ?>
    <section id="menu">
        <div class="logo">
            <img src="image/logo.png" alt="">
            <h2>Grizz Team</h2>
        </div>

        <div class ="items">
            <form action="memberhome.php" method="POST">
                <input type="hidden" name="idmember" value="<? php echo $idmember?>">
                <button id=btnmember type="submit">Dashboard</button>
            </form>
            <li><a href="proposalmember.php?idmember=<?php echo $idmember; ?>">Join Proposal</a></li>
            <li><a href="detailproposal.php">Detail Proposal</a></li>
        </div>
    </section>
    <section id ="interface">
        <div class="navigation">
            <div class = "n1">
            <div class="search">
                <form action="memberhome.php" method="get">
                <?php
                    if(isset($_POST['idmember'])){
                        $idmember = $_POST['idmember'];
                        echo "<h1>$idmember</h1>";
                    }
                ?>
                    <input type="text" name ="cari" placeholder="Search"  value="<?php echo @$_GET["cari"]; ?>">
                    <a href="memberhome.php">Reset</a> 
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
            $resreadteam = $team->getTeamById($idmember);
            echo "<table border=1>
            <tr>
                <th>Team Name</th>
                <th>Game Name</th>
            </tr>";

            while($row = $resreadteam-> fetch_assoc()){
                echo "<tr>
                <td>".$row['teamname']."</td>
                <td>".$row['gamename']."</td>
                </tr>";
            }
            echo "</table>";  
        ?>
        </div>
    </section>
</body>
</html>