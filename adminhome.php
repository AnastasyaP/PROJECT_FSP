<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
     require_once('teamclass.php');
     $team = new Team();
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

    <section id ="interface">
        <div class="navigation">
            <div class = "n1">
            <div class="search">
                <form action="adminhome.php" method="get">
                    <input type="text" name ="cari" placeholder="Search"  value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="adminhome.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="login">
                <form action="memberhome.php" method="post">
                    <button class='login-button' type='submit' name='btnlogout' value='logout' id=btnprop>Log Out🔒</button>
                </form>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

        <h3 class="i-name"> DashBoard </h3>
        <div class="tableall">
        <?php 
            if(isset($_GET['deleted'])){
                if($_GET['deleted'] == 'success'){
                    echo "Deleted Succsessfull😆";
                } else if($_GET['deleted'] == 'failed'){
                    echo "Failed to delete data😔🙏";
                }
            }

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
                $res = $team->readTeam($_GET['cari'], $offset, $perhal);
                $totaldata = $team->getTotalData($_GET['cari']);
            } else{
                $res = $team->readTeam("", $offset, $perhal);
                $totaldata = $team->getTotalData("");
            }
    
            $jmlhal = ceil($totaldata/$perhal);

            echo "<table>";
            echo "<tr>
                    <th>Team Picture</th>
                    <th>Team ID</th>
                    <th>Team Name</th>
                    <th>Game</th>
                    <th colspan=2>Action</th>
                </tr>";

            while ($row = $res->fetch_assoc()) {
                $teamPict = $row["idteam"].".jpg";
                if(!file_exists("image/".$teamPict)) {
                    $teamPict = "blank.jpg";
                }    

                // function time() memaksa browser untuk selalu memuat gambar yang terbaru setiap kali halaman di-refresh, karena nilai time() selalu berubah.
                echo "<tr>
                        <td><img src='image/$teamPict?".time()."' alt='Team Picture' width=150></td> 
                        <td>".$row['idteam']."</td>
                        <td>".$row['teamname']."</td>
                        <td>".$row['gamename']."</td>
                        <td><a href='editteam.php?idteam=".$row['idteam']."'>EDIT</a></td>
                        <td><a href='deleteteam.php?idteam=" . $row['idteam'] . "'>DELETE</a></td>

                    </tr>";
            }
            echo "</table>";

            // paging tabel team
            echo "<div>Total Data ".$totaldata."</div>";
            echo "<a href='adminhome.php?offset=0'>First</a> ";

            for($i = 1; $i <= $jmlhal; $i++) {
                $off = ($i-1) * $perhal;
                if($currhal == $i) {                
                    echo "<strong style='color:red'>$i</strong>";
                } else {
                    echo "<a href='adminhome.php?offset=".$off."'>".$i."</a> ";
                }
            }
            $lastoffset = ($jmlhal - 1) * $perhal;
            echo "<a href='adminhome.php?offset=".$lastoffset."'>Last</a> ";
            ?>
        </div>
    </section>
</body>
</html>