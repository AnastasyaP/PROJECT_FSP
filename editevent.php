<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>

    <?php
    if(isset($_POST['btnSubmit'])){
        include 'koneksi.php';
        extract($_POST);

        $stmt = $mysqli->prepare("UPDATE event SET name=?, date =?,description=? WHERE idevent=?");
        $stmt->bind_param("sssi",$name,$date,$description,$idevent);
        $stmt->execute();
        $jumlah = $stmt->affected_rows;

        $stmt->close();
        $mysqli->close();
        header("Location:  inserteventnew.php");
        exit();

        }
    
    ?>
    <?php

        // if(isset($_GET['result'])){
        //     if($_GET['result'] == 'success'){
        //         echo "New Game Successfully added😆.<br><br><br>";
        //     }
        // }

        include 'koneksi.php';

        $id = $_GET["idevent"];
        
        include 'koneksi.php';

        $stmt = $mysqli->prepare("SELECT * from event WHERE idevent = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
    ?>
    <form action="editevent.php" method ="post">
        <label for="name">Game Event : </label>
        <input type="text" id="name" name="name" value="<?php echo $row["name"]?>"><br><br>
        <label for="date" id="date" name="date">Event Date :</label>
        <input type="date" id="date" name="date" value="<?php echo $row["date"]?>"><br><br>
        <label for="description">Description : </label>
        <textarea name="description" id="description"><?php echo $row['description']?></textarea><br><br>
        <input type="hidden" name="idevent" value="<?php echo $row["idevent"]; ?>">
        <input type="submit" value="submit" name="btnSubmit">
    </form> 
</body>
</html>