<?php
    session_start();
    $isMember = false;

    require_once('teamclass.php');
    $team = new Team();

    if(isset($_POST['btnlogout'])){
       $isMember = false;
       session_destroy();
       header("Location: index.php");
       exit();
    }

    if(isset($_SESSION['idmember'])){
        $idmember = $_SESSION['idmember'];
        $isMember =true;
    }

    $name = $_SESSION['name'] ?? 'Guest';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

    <section id ="interface">
        <div class="navigation">
            <div class = "n1">
                <div class="search">
                    <form action="index.php" method="get">
                        <input type="text" name ="cari" placeholder="Search"  value="<?php echo @$_GET["cari"]; ?>">
                        <a class="reset-button" href="index.php">Reset</a> 
                    </form>
                </div>
            </div>

            <div class="login">
                <form action="login.php" method="post">
                    <?php

                        if($isMember === false){
                            echo "<button class='login-button' type='submit' name='btnlogin' value='login' id=btnprop>Log in🔐</button>";
                        }
                    ?>
                </form>
                <form action="index.php" method="post">
                    <?php
                        if($isMember === true){
                            echo "<button class='login-button' type='submit' name='btnlogout' value='logout' id=btnprop>Log Out🔒</button>";
                        }
                    ?>
                </form>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

        <h3 class="i-name"> </h3>
        <div class="tableall">
            <?php echo "<h1>Welcome $name, To Grizz Team Website🎇</h1>"; ?>
        </div>
    </section>
</body>
</html>