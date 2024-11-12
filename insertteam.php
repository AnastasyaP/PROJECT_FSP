<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSERT TEAM</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        require_once('teamclass.php');
        $team = new Team();
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

        <h3 class="i-name"> Insert Team </h3>
        <div class="tableall">
        <?php 
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
                echo "<b>Hasil pencarian : ".$cari."</b>";
            }
        ?>
        <?php
            if(isset($_GET['result'])){
                if($_GET['result']=='success'){
                    echo "New Team Successfully added😆.<br><br><br>";
                }
            }
        ?>
        
        <form action="insertteam_proses.php" method='post' enctype="multipart/form-data">
            <label for="name">Team Name: </label>
            <input type="text" id="name" name="name"><br><br>

            <label>Upload Team Picture:</label>
            <input type="file" name="photo" accept="image/jpg" id="photo"><br><br>

            <label for="game">Game?</label><br>
            <?php
                $gameData = $team->getGame();

                echo "<div id='tab'>";
                while($row = $gameData->fetch_assoc()){
                    echo "<input type='radio' id='game' name='game[]' value=".$row['idgame'].">".$row['name']."<br>";
                }
                echo "</div>";
            ?>

            <input type="submit" value="Submit" name="btnSubmit">
        </form>
    </section>
</body>
</html>