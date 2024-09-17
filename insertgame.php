<html>
<head>
    <title>Insert Game</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
        </script>
        <body>
        <section id="menu">
        <div class="logo">
            <img src="image/logo.png" alt="">
            <h2>Grizz Team</h2>
        </div>

        <div class ="items">
            <li><a href="adminhome.php">Dashboard</a></li>
            <li><a href="insertteam.php">Manage Team</a></li>
            <li><a href="insertgame.php">Manage Game</a></li>
            <li><a href="inserteventnew.php">Manage Event</a></li>
            <li></i><a href="achievement.php">Manage Achievement</a></li>
            <li><a href="#">Join Proposal</a></li>
        </div>
        </section>

        <section id="interface">
            <div class="navigation">
                <div class = "n1">
                    <div class="search">
                    </div>
                </div>

                <div class="profile">
                    <i class="bi bi-person-circle"></i>
                </div>
            </div>
                <h3 class="i-name"> Insert Game </h3>
            <div class="tableall">
                <?php

                    include 'koneksi.php';

                    // if(isset($_GET['result'])){
                    //     if($_GET['result'] == 'success'){
                    //         echo "New Game Successfully added😆.<br><br><br>";
                    //     }
                    // }

                    if(isset($_POST['btnSubmit'])){
                        include 'koneksi.php';
                        $name = $_POST['name'];
                        $description = $_POST['description'];
                        
                        $stmt = $mysqli->prepare("INSERT INTO game(name,description) values(?,?)");
                        $stmt->bind_param("ss", $name, $description);
                        $stmt->execute();

                        if ($stmt->affected_rows > 0) {
                            $last_id = $stmt->insert_id;
                            header("Location: insertgame.php?success=1");
                            exit();
                        } else {
                            echo "Failed to add new game.<br><br><br>";
                        }

                        $stmt->close();
                    }
                ?>
                <form action="insertgame.php" method='post'>
                    <label for="name">Game Name : </label>
                    <input type="text" id="name" name="name"><br><br>
                    <label for="description">Description : </label>
                    <textarea name="description" id="description"></textarea><br><br>

                    <input type="submit" value="Submit" name="btnSubmit">
                    </form>

                    <br>

                    <?php
                        $stmt = $mysqli-> prepare("SELECT * from game");
                        $stmt->execute();

                        // Mendapatkan hasil query
                        $result = $stmt->get_result();
                        echo "<table border = '1'>";
                        echo "<tr>
                            <th>Nama Game</th>
                            <th>Description</th>
                            <th colspan=2>Action</th>
                        </tr>";
                        while($row = $result->fetch_assoc()){
                        echo"<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['description']."</td>
                            <td><a href='editgame.php?idgame=".$row['idgame']."'>EDIT</a></td>
                            <td><a href='deletegame.php?idgame=" . $row['idgame'] . "' class='remove'>DELETE</a></td>
                        </tr>";
                        }
                        echo"</table>";
                        $stmt->close();
                        $mysqli->close();
                    ?>
            </div>
        </section>
        </body>
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
    </head>
</html>