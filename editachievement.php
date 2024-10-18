<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Achievement</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
    require_once('achievementclass.php');
    $achievement = new Achievement();
    if(isset($_GET['idachievement'])){
        $id = $_GET['idachievement'];
    }

    if(isset($_POST['btnSubmit'])){
        $team = $_POST['team'];
        $name = $_POST['achievement'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $idachievement = $_POST['idachievement'];

        $achievementData = [
            'idteam' => $team,
            'name' => $name,
            'date' => $date,
            'description' => $description
        ];

        if($achievement->updateAchievement($achievementData, $idachievement)){
            header("Location: insertachievement.php?idteam=$idteam&update=success");
            exit();
        } else{
            header("Location: insertachievement.php?idteam=$idteam&update=failed");
            exit();
        }
    }
    if(isset($_GET['update'])){
        if($_GET['update']=='success'){
            echo "Achievement Updated Successfully😆.<br><br>";
        } else{
            echo "Achievement Updated Failed😔.<br><br>";
        }
    }

    $nameData = $achievement->getAchievement($id);
    $row = $nameData->fetch_assoc();
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
                <form action="insertachievement.php" method="get">
                    <input type="text" name ="cari" placeholder="Search" value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="insertachievement.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>
        <h3 class="i-name"> Edit Achievement </h3>
        <div class="tableall">
            <form action="editachievement.php" method="post">
                <label for="achievement">Name of Achievement: </label>
                <input type="text" id="achievement" name="achievement" value="<?php echo $row['name']; ?>"><br><br>

                <label for="date">Achievement Date: </label>
                <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>"><br><br>

                <label for="team">Team? </label>
                <?php
                    $teams = $achievement->getTeam();

                    $currentTeamId = $row['idteam'];

                    echo "<select name='team' id='team'>";
                    if ($teams->num_rows > 0) {
                        while($teamRow = $teams->fetch_assoc()){
                            $selected = ($teamRow['idteam'] == $currentTeamId) ? "selected" : "";
                            echo "<option value='{$teamRow['idteam']}' $selected>{$teamRow['name']}</option>";                
                        }
                    } else {
                        echo "<option value=''>Tidak ada team tersedia</option>";
                    }
                    echo "</select>";

                ?>
                <br><br>
                
                <label for="description">Description: </label>
                <?php
                    $description = $row['description'];
                ?>
                <textarea name="description" id="description"><?php echo htmlspecialchars($description); ?></textarea><br><br>

                <input type="hidden" name="idachievement" value="<?php echo $row["idachievement"]; ?>">
                <input type="submit" value="Submit" name="btnSubmit">
            </form>
        </div>
    </section>
</body>
</html>