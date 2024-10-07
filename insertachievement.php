<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Achievement</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
    </script>
</head>
<body>
    <?php
        require_once("achievementclass.php");
        $achievement = new Achievement();
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
        <h3 class="i-name"> Insert Achievement </h3>
        <div class="tableall">
            <?php
                if(isset($_GET['result'])){
                    if($_GET['result']=='success'){
                        echo "New Achievement Successfully added😆.<br><br><br>";
                    }
                }

                if(isset($_GET['deleted'])){
                    if($_GET['deleted'] == 'success'){
                        echo "Deleted Succsessfull😆.<br><br><br>";
                     } else if($_GET['deleted'] == 'failed'){
                        echo "Failed to delete data😔🙏.<br><br><br>";
                     }
                 }

                if(isset($_POST['btnSubmit'])){
                    $team = $_POST['team'];
                    $name = $_POST['achievement'];
                    $date = $_POST['date'];
                    $description = $_POST['description'];

                    $achievementData = [
                        'idteam' => $team,
                        'name' => $name,
                        'date' => $date,
                        'description' => $description
                    ];

                    if($achievement->insertAchievement($achievementData)){
                        header("Location: insertachievement.php?result=success");
                        exit();
                    } else{
                        header("Location: insertachievement.php?result=failed");
                        exit();
                    }
                }
            ?>
            <form action="insertachievement.php" method="post">
                <label for="achievement">Name of Achievement: </label>
                <input type="text" id="achievement" name="achievement"><br><br>

                <label for="date">Achievement Date: </label>
                <input type="date" id="date" name="date"><br><br>

                <label for="team">Team? </label>
                <select name="team" id="team">
                    <option value="">Choose a Team</option>
                    <?php
                        $achievementData = $achievement->getTeam();
                        
                        while($row = $achievementData->fetch_assoc()){
                            echo "<option value=".$row['idteam'].">".$row['name']."</option>";
                        }
                    ?>
                </select><br><br>

                <label for="description">Description: </label>
                <textarea name="description" id="description"></textarea><br><br>

                <input type="submit" value="Submit" name="btnSubmit"><br><br>
            </form>
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
                if(isset($_GET['name'])){
                    $res = $achievement->readAchievement($_GET['name'], $offset, $perhal);
                    $totaldata = $achievement->getTotalData($_GET['name']);
                } else{
                    $res = $achievement->readAchievement("", $offset, $perhal);
                    $totaldata = $achievement->getTotalData("");
                }
        
                $jmlhal = ceil($totaldata/$perhal);  

                if($res->num_rows > 0){
                    echo "<table border=1>
                    <tr>
                        <th>ID</th>
                        <th>Team</th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th colspan=2>Action</th>
                    </tr>";

                    while($row = $res->fetch_assoc()){
                        $formatrilis = strftime("%d %B %Y", strtotime($row['date']));

                        echo "<tr>
                        <td>".$row['idachievement']."</td>
                        <td>".$row['teamname']."</td>
                        <td>".$row['achievename']."</td>
                        <td>".$formatrilis."</td>
                        <td>".$row['description']."</td>
                        <td><a href='editachievement.php?idachievement=".$row['idachievement']."'>Edit</a></td>
                        <td><a href='deleteachievement.php?idachievement=" . $row['idachievement'] . "' class='remove'>DELETE</a></td>
                        </tr>";
                    }
                    echo "</table>";
                }
                // paging tabel team
                echo "<div>Total Data ".$totaldata."</div>";
                echo "<a href='insertachievement.php?offset=0'>First</a> ";

                for($i = 1; $i <= $jmlhal; $i++) {
                    $off = ($i-1) * $perhal;
                    if($currhal == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        echo "<a href='insertachievement.php?offset=".$off."'>".$i."</a> ";
                    }
                }
                $lastoffset = ($jmlhal - 1) * $perhal;
                echo "<a href='insertachievement.php?offset=".$lastoffset."'>Last</a> ";
            ?>
        </div>
    </section>
    <script>
        $(document).on("click",".remove",function(e){
            var confirmDelete = confirm("Are you sure you want to delete this Achievement?");
        if (!confirmDelete) {
            e.preventDefault(); // Jika pengguna menekan "Cancel", jangan lakukan apapun
        }
        });

    </script>
</body>
</html>