<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT TEAM</title>
</head>
<body>
    <?php
        require_once('teamclass.php');
        $team = new Team();
        $id = $_GET["idteam"];
    ?>
    <?php
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
    ?>

    <?php
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
    <form action="editteam.php" method='post'>
        <label for="name">Team Name: </label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br><br>

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
</body>
</html>