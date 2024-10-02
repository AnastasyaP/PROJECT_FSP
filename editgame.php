<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> EDIT TEAM</title>
    <body>
    <?php
        require_once('gameclass.php');
    ?>
    <?php
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
        
     ?>
        <?php
                $id = $_GET["idgame"];
                $game = new Game();
                $res = $game->readGameById($id);
                $row = $res->fetch_assoc();
        ?> 
        <form action="editgame.php" method="post">
            <label for="name">Nama :</label>
            <input type="text" id="name" name="name" value="<?php echo $row["name"]; ?>"><br><br>
            <label for="description">Deskripsi : </label>
            <input type="text" id="description" name="description" value="<?php echo $row["description"]; ?>" ><br><br>
            <input type="hidden" name="idgame" value="<?php echo $row["idgame"]; ?>">
            <input type="submit" value="Submit" name="btnSubmit">
        </form>
    </body>
</head>
</html>