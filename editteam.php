<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT TEAM</title>
</head>
<body>
    <?php
        include 'koneksi.php';

        if(isset($_GET['result'])){
            if($_GET['result']=='success'){
                echo "Changes saved successfully😆.<br><br><br>";
            }
        }

        $id = $_GET['idteam'];

        $stmt = $mysqli->prepare("SELECT t.idteam, t.name as teamname, t.idgame, g.name as gamename
        FROM team t INNER JOIN game g ON t.idgame = g.idgame WHERE t.idteam = ?");
        $stmt->bind_param("i",$id);

        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_assoc();
    ?>
    <form action="editteam_proses.php" method='post'>
        <label for="name">Team Name: </label>
        <input type="text" id="name" name="name" value="<?php echo $row['teamname']; ?>"><br><br>

        <label for="game">Game?</label><br>
        <input type="text" id="game" name="game" value="<?php echo $row['gamename']; ?>" disabled>

        <input type="hidden" name="idteam" value="<?php echo $row["idteam"]; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>