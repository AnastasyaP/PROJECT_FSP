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

        if(isset($_POST['idteam'])){
            $id = $_POST["idteam"];
        }

        if(isset($_POST['btnSubmit'])){
            if(isset($_FILES['photo']) && ($_FILES['photo']['name'])){
                if(!$_FILES['photo']['error']){
                    $file_info = getimagesize($_FILES['photo']['tmp_name']);
                    if(empty($file_info)){
                        $message = "The uploaded file doesn't seem to be an image.";
                    } else{
                        $imgFileType = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                        
                        if($imgFileType === 'jpg'){
                            $teamName = $_POST['name'];
                            $games = $_POST['game'];
    
                            $oldPict = "image/{$id}.jpg";
                            if (file_exists($oldPict)) {
                                unlink($oldPict); // Hapus file gambar lama
                            }

                            $target_dir = "image/";
                            $newname = $target_dir . $id . "." . $imgFileType;
    
                            if(move_uploaded_file($_FILES['photo']['tmp_name'], $newname)){
    
                                foreach($games as $game){
                                    $teamData = [
                                        'idgame' => $game,
                                        'name' => $teamName
                                    ];
                                }

                                $game = $_POST['game'];
                                $name = $_POST['name'];
                    
                                $teamData = [
                                    'idgame' => $game,
                                    'name' => $name 
                                ];

                                // $message = 'Congratulations! Your file was accepted.';
                    
                                if($team->updateTeam($teamData, $id)){
                                    header("Location: adminhome.php?idteam=$id&result=success");
                                    exit();
                                } else{
                                    header("Location: adminhome.php?idteam=$id&result=failed");
                                    exit();
                                }
                            } else {
                                $message = 'File upload failed. Please check permissions and file path.';
                            }
                        } else{
                            $message = "Your file is not jpg!";
                        }
                    }
                } else{
                    $message = 'Ooops! Your upload triggered the following error: ' . $_FILES['photo']['error'];
                }
            } else{
                $message = 'You did not select any file!'; 
            }
        }

        if(isset($_GET['result'])){
            if($_GET['result']=='success'){
                echo "Changes update successfully😆.<br><br><br>";
            } else if($_GET['result']=='failed'){
                echo "Changes failed to update:(<br><br><br>";
            }
        }


        // ini buat ngambil id dari form sebelumnya dan menampilkan data2 dari form sebelumnya
        if (isset($_GET['idteam'])) {
            
            $nameData = $team->getTeam($_GET['idteam']);
            $row = $nameData->fetch_assoc();
        } else {
            echo "ID team tidak ditemukan.";
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
            <form action="editteam.php" method='post' enctype="multipart/form-data">
                <label for="name">Team Name: </label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br><br>

                <label>Edit Team Picture:</label>
                <input type="file" name="photo" accept="image/jpg" id="photo"><br><br>

                <label for="game">Game?</label><br>
                <?php
                    $games = $team->getGame($_GET['idteam']);

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