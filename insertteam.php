<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSERT TEAM</title>
</head>
<body>
    <?php
        if(isset($_GET['result'])){
            if($_GET['result']=='success'){
                echo "New Team Successfully added😆.<br><br><br>";
            }
        }
    ?>
    <form action="insertteam_proses.php" method='post'>
        <label for="name">Team Name: </label>
        <input type="text" id="name" name="name"><br><br>

        <label for="game">Game?</label><br>
        <?php
            include 'koneksi.php';

            $stmt = $mysqli->prepare("SELECT * FROM game");
            $stmt->execute();
            $res = $stmt->get_result();

            while($row = $res->fetch_assoc()){
                echo "<input type='radio' id='game' name='game[]' value=".$row['idgame'].">".$row['name']."<br>";
            }
        ?>

        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>