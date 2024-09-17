<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Achievement</title>
</head>
<body>
<?php
    include 'koneksi.php';

    if(isset($_GET['result'])){
        if($_GET['result']=='success'){
            echo "Achievement Updated Successfully😆.<br><br>";
        }
    }

    $id = $_GET['idachievement'];

    $stmt = $mysqli->prepare("SELECT * FROM achievement WHERE idachievement=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    $teamId = $row['idteam'];
    $description = $row['description'];
?>
<form action="editachievement_proses.php" method="post">
        <label for="achievement">Name of Achievement: </label>
        <input type="text" id="achievement" name="achievement" value="<?php echo $row['name']; ?>"><br><br>

        <label for="date">Achievement Date: </label>
        <input type="date" id="date" name="date" value="<?php echo $row['date']; ?>"><br><br>

        <label for="team">Team? </label>
        <select name="team" id="team">
        <option value="">Choose a Team</option>
        <?php
            $stmt = $mysqli->prepare("SELECT * FROM team");
            $stmt->execute();
            $res = $stmt->get_result();
                while($teamRow = $res->fetch_assoc()){
                    $selected = ($teamRow['idteam'] == $teamId) ? "selected" : "";
                    echo "<option value='".$teamRow['idteam']."' ".$selected.">".$teamRow['name']."</option>";                
                }

            $mysqli->close();
        ?>
        </select><br><br>
        
        <label for="description">Description: </label>
        <textarea name="description" id="description"><?php echo htmlspecialchars($description); ?></textarea><br><br>

        <input type="hidden" name="idachievement" value="<?php echo $row["idachievement"]; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>