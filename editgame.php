<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> EDIT TEAM</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
    <body>
    <?php
        require_once('gameclass.php');

        if(isset($_POST['btnSubmit'])){

            $name = $_POST['name'];
            $description = $_POST['description'];
            $idgame = $_POST['idgame'];

            $game = new Game();

            $gameData =[
                'name' => $name,
                'description' =>$description,
            ];

            if ($game->updateGame($idgame, $gameData)) {
                header("Location: insertgamenew.php?status=success");
                exit();
            } else {
                header("Location: insertgamenew.php?status=failure");
                exit();
            }
            
        }

        $id = $_GET["idgame"];
        $game = new Game();
        $res = $game->readGameById($id);
        $row = $res->fetch_assoc();
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
                <form action="insertgamenew.php" method="get">
                    <input type="text" name ="cari" placeholder="Search" value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="insertgamenew.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>
        <h3 class="i-name"> Edit Game </h3>
        <div class="tableall">
            <form action="editgame.php" method="post">
                <label for="name">Nama :</label>
                <input type="text" id="name" name="name" value="<?php echo $row["name"]; ?>"><br><br>
                <label for="description">Deskripsi : </label>
                <input type="text" id="description" name="description" value="<?php echo $row["description"]; ?>" ><br><br>
                <input type="hidden" name="idgame" value="<?php echo $row["idgame"]; ?>">
                <input type="submit" value="Submit" name="btnSubmit">
            </form>
        </div>
    </section>
    </body>
</head>
</html>