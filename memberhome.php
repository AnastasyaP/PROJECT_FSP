<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
     require_once('teamclass.php');
     $team = new Team();
     $isMember = false;

     if(isset($_POST['btnlogout'])){
        $isMember = false;
     }
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
                if(isset($_GET['login'])){
                    if($_GET['login']=='success'){
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
                    <form action="memberhome.php" method="get">
                        <input type="text" name ="cari" placeholder="Search"  value="<?php echo @$_GET["cari"]; ?>">
                        <a class="reset-button" href="memberhome.php">Reset</a> 
                    </form>
                </div>
            </div>

            <div class="login">
                <form action="login.php" method="post">
                    <?php
                        if($isMember === false){
                            echo "<button class='login-button' type='submit' name='btnlogin' value='login' id=btnprop>Log in🔐</button>";
                        }
                        else if($isMember === true){
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
            <h1>Welcome To Grizz Team Website🎇</h1>
        </div>
    </section>
</body>
</html>