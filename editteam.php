<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT TEAM</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        require_once('teamclass.php');
        $team = new Team();
        $id = $_GET["idteam"];

        if(isset($_POST['btnSubmit'])){
            $game = $_POST['game'];
            $name = $_POST['name'];
            $idteam = $_POST['idteam'];

            $teamData = [
                'idgame' => $game,
                'name' => $name 
            ];

            if($team->updateTeam($teamData, $idteam)){
                header("Location: adminhome.php?idteam=$idteam&result=success");
                exit();
            } else{
                header("Location: adminhome.php?idteam=$idteam&result=failed");
                exit();
            }
        }

        if(isset($_GET['result'])){
            if($_GET['result']=='success'){
                echo "Changes update successfully😆.<br><br><br>";
            } else if($_GET['result']=='failed'){
                echo "Changes failed to update:(<br><br><br>";
            }
        }

        if (isset($_GET['idteam'])) {
            
            $nameData = $team->getTeam($id);
            $row = $nameData->fetch_assoc();
        } else {
            echo "ID event tidak ditemukan.";
            exit();
        }
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
                    <input type="text" name ="cari" placeholder="Search" value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="adminhome.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>
        <h3 class="i-name"> Edit Team </h3>
        <div class="tableall">
            <form action="editteam.php" method='post'>
                <label for="name">Team Name: </label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br><br>

                <?php
                    // if()
                ?>
                <label>Edit Team Picture:</label>
                <input type="file" name="photo" accept="image/jpeg, image/jpg" id="photo" value="<?php echo $row['idteam'].'.' ?>"><br><br>

                <label for="game">Game?</label><br>
                <?php
                    $games = $team->getGame($id);

                    $currentGameId = $row['idgame'];

                    echo "<select name='game' id='game'>";
                    if ($games->num_rows > 0) {
                        while ($game = $games->fetch_assoc()) {
                            $selected = ($game['idgame'] == $currentGameId) ? 'selected' : '';
                            echo "<option value='{$game['idgame']}' $selected>{$game['name']}</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada game tersedia</option>";
                    }
                    echo "</select>";
                ?>

                <input type="hidden" name="idteam" value="<?php echo $row["idteam"]; ?>">
                <input type="submit" value="Submit" name="btnSubmit">
            </form>
        </div>
    </section>
</body>
</html>