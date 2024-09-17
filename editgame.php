<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> EDIT TEAM</title>
    <body>
    <?php
    if(isset($_POST['btnSubmit'])){
        include 'koneksi.php';
            extract($_POST);

            $stmt = $mysqli->prepare("UPDATE game SET name=?, description=? WHERE idgame=?");
            $stmt->bind_param("ssi",$name,$description,$idgame);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;

            $stmt->close();
            $mysqli->close();
            header("Location: insertgame.php?");
            exit();
    }
        
     ?>
        <?php
                // if(isset($_GET['result'])){
                //     If($_GET['result']=='success'){
                //         echo "Update saved successfully😆.<br><br><br>";
                //     }
                // }
                
                include 'koneksi.php';

                $id = $_GET["idgame"];

                $stmt = $mysqli->prepare("SELECT * from game WHERE idgame = ?");
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $res = $stmt->get_result();

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