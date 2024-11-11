<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Event</title>
    <link rel ="stylesheet" type="text/css" href="style.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
        crossorigin="anonymous">
    </script>
<body>
    <?php
        require_once('eventclass.php');
        require_once('event_teamclass.php');
        $event = new Event();
        $eventeam = new Event_Team();
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
                <form action="inserteventnew.php" method="get">
                    <input type="text" name ="cari" placeholder="Search"  value="<?php echo @$_GET["cari"]; ?>">
                    <a class="reset-button" href="inserteventnew.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

            <h3 class="i-name"> Insert Event </h3>
        <div class="tableall">

            <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'success') {
                    echo "Do Successfully 😆";
                } else if ($_GET['status'] == 'failure') {
                    echo "Failed to perform operation";
                }
            }
            ?>
            <?php

                if(isset($_POST['btnSubmit'])){
                    $name = $_POST['name'];
                    $date = $_POST['date'];
                    $description = $_POST['description'];
                    $teams = $_POST['team'];
            
                   $eventData = [
                        'name' => $name,
                        'date' => $date,
                        'description' => $description
                   ];

                   $eventID= $event->insertEvent($eventData);

                   if($eventID){
                        $temaData = [];

                        foreach($teams as $team){
                            $temaData[] = [
                                'idevent' => $eventID,
                                'idteam' => $team
                            ];
                        }

                        if ($eventeam->insertEvenTeam($temaData)) {
                            header("Location: inserteventnew.php?status=success");
                            exit();
                        } else {
                            header("Location: inserteventnew.php?status=failure");
                            exit();
                        }
                    } else {
                        header("Location: inserteventnew.php?status=failure");
                        exit();
                    }
                }
            ?>
            <form action="inserteventnew.php" method ="post">
                <label for="name">Game Event : </label>
                <input type="text" id="name" name="name"><br><br>
                <label for="date" id="date" name="date">Event Date :</label>
                <input type="date" id="date" name="date"><br><br>
                <label for="team">Team : </label><br>
                <?php
                    $res = $eventeam->readEventTeam();
                        while($team = $res->fetch_assoc()){
                            echo"<input type='checkbox' name='team[]'value='" . $team['idteam'] . "'>" . $team['name'] . "<br>";
                        }
               
                ?><br><br>
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
                    $res = $event->readEvent($_GET['cari'], $offset, $perhal);
                    $totaldata = $event->getTotalData($_GET['cari']);
                } else{
                    $res = $event->readEvent("", $offset, $perhal);
                    $totaldata = $event->getTotalData("");
                }
        
                $jmlhal = ceil($totaldata/$perhal);

                echo "<table border = '1'>";
                echo "<tr>
                        <th>ID</th>
                        <th>Nama event</th>
                        <th>Date </th>
                        <th>Description</th>
                        <th>Team</th>
                        <th colspan=2>Action</th>
                    </tr>";
                while($row = $res->fetch_assoc()){
                    $formatrilis = strftime("%d %B %Y", strtotime($row['date']));

                    $reseventeam = $eventeam->readEventWithTeam($row['idevent']);
                    
                    $team = array();
                    while($rowteam = $reseventeam->fetch_assoc()){
                        $team[]=$rowteam['name'];
                    }
                    $team = implode(",",$team);
                    echo"<tr>
                        <td>".$row['idevent']."</td>
                        <td>".$row['name']."</td>
                        <td>".$formatrilis."</td>
                        <td>".$row['description']."</td>
                        <td>".$team."</td>
                        <td><a href='editevent.php?idevent=".$row['idevent']."'>EDIT</a></td>
                        <td><a href='deleteevent.php?idevent=". $row['idevent'] . "' class='remove'>DELETE</a></td>
                    </tr>";
                }
                echo"</table>";

                // paging tabel team
                echo "<div>Total Data ".$totaldata."</div>";
                echo "<a href='inserteventnew.php?offset=0'>First</a> ";

                for($i = 1; $i <= $jmlhal; $i++) {
                    $off = ($i-1) * $perhal;
                    if($currhal == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        echo "<a href='inserteventnew.php?offset=".$off."'>".$i."</a> ";
                    }
                }
                $lastoffset = ($jmlhal - 1) * $perhal;
                echo "<a href='inserteventnew.php?offset=".$lastoffset."'>Last</a> ";
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
        </script>
     </body>
    </head>
</html>