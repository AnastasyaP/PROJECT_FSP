<html>
<head>
    <title>Insert Game</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
        </script>
</head>
        <body>
        <?php
            require_once('gameclass.php');
            $game = new Game();
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
                        <form action="insertgamenew.php" method="get">
                            <input type="text" name ="cari" placeholder="Search" value="<?php echo @$_GET["cari"]; ?>">
                            <a class="reset-button" href="insertgamenew.php">Reset</a> 
                        </form>
                    </div>
                </div>

                <div class="profile">
                    <i class="bi bi-person-circle"></i>
                </div>
            </div>

            <h3 class="i-name"> Insert Game </h3>
            <div class="tableall">
            <?php                
                if (isset($_GET['status'])) {
                    if ($_GET['status'] == 'success') {
                        echo "Do Successfully 😆";
                    } else if ($_GET['status'] == 'failure') {
                        echo "Failed to perform operation";
                    }
                }

                if(isset($_POST['btnSubmit'])){
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    
                    $gameData =[
                        'name' => $name,
                        'description' => $description
                    ];

                    if ($game->insertGame($gameData)) {
                        header("Location: insertgamenew.php?status=success");
                        exit();
                    } else {
                        header("Location: insertgamenew.php?status=failure");
                        exit();
                    }

                }
            ?>
            <form action="insertgamenew.php" method='post'>
                <label for="name">Game Name : </label>
                <input type="text" id="name" name="name"><br><br>
                <label for="description">Description : </label>
                <textarea name="description" id="description"></textarea><br><br>

                <input type="submit" value="Submit" name="btnSubmit">
            </form>

            <br>

            <?php
                $totaldata = 0;
                $perhal = 5;
                $currhal = 1;
        
                if(isset($_GET['offset'])){
                    $offset = intval($_GET['offset']);
                    $currhal = ($offset/5+1);
                } else{
                    $offset =0;
                }
        
                // search name
                if(isset($_GET['cari'])){
                    $res = $game->readGame($_GET['cari'], $offset, $perhal);
                    $totaldata = $game->getTotalData($_GET['cari']);
                } else{
                    $res = $game->readGame("", $offset, $perhal);
                    $totaldata = $game->getTotalData("");
                }
        
                $jmlhal = ceil($totaldata/$perhal);

                echo "<table border = '1'>";
                echo "<tr>
                    <th>ID</th>
                    <th>Nama Game</th>
                    <th>Description</th>
                    <th colspan=2>Action</th>
                </tr>";
                while($row = $res->fetch_assoc()){
                echo"<tr>
                    <td>".$row['idgame']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['description']."</td>
                    <td><a href='editgame.php?idgame=".$row['idgame']."'>EDIT</a></td>
                    <td><a href='deletegame.php?idgame=" . $row['idgame'] . "' class='remove'>DELETE</a></td>
                </tr>";
                }
                echo"</table>";

                // paging tabel game
                echo "<div>Total Data ".$totaldata."</div>";
                echo "<a href='insertgamenew.php?offset=0'>First</a> ";

                for($i = 1; $i <= $jmlhal; $i++) {
                    $off = ($i-1) * $perhal;
                    if($currhal == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        echo "<a href='insertgamenew.php?offset=".$off."'>".$i."</a> ";
                    }
                }
                $lastoffset = ($jmlhal - 1) * $perhal;
                echo "<a href='insertgamenew.php?offset=".$lastoffset."'>Last</a> ";
            ?>
            </div>
        </section>
        <script>
        $(document).on("click",".remove",function(e){
            var confirmDelete = confirm("Are you sure you want to delete this game?");
        if (!confirmDelete) {
            e.preventDefault(); // Jika pengguna menekan "Cancel", jangan lakukan apapun
        }
        });

        // $(document).ready(function() {
        //     console.log("jQuery is working!");
        // });
        </script>
</body>
</html>