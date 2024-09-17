<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Achievement</title>
</head>
<body>
    <?php
        if(isset($_GET['result'])){
            if($_GET['result']=='success'){
                echo "New Achievement Successfully added😆.<br><br><br>";
            }
        }
    ?>

    <form action="insertachievement_proses.php" method="post">
        <label for="achievement">Name of Achievement: </label>
        <input type="text" id="achievement" name="achievement"><br><br>

        <label for="date">Achievement Date: </label>
        <input type="date" id="date" name="date"><br><br>

        <label for="team">Team? </label>
        <?php
            include 'koneksi.php';
            
            $stmt = $mysqli->prepare("SELECT * FROM team");
            $stmt->execute();
            $res = $stmt->get_result();
        ?>
        <select name="team" id="team">
            <option value="">Choose a Team</option>
            <?php
                while($row = $res->fetch_assoc()){
                    echo "<option value=".$row['idteam'].">".$row['name']."</option>";
                }
            ?>
        </select><br><br>

        <label for="description">Description: </label>
        <textarea name="description" id="description"></textarea><br><br>

        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>