<?php
require_once('teamclass.php');
$team = new Team();

$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
            $cari = isset($_POST['cari']) ? $_POST['cari'] : "";
            $perhal = 3;
            
            $res = $team->readTeam($cari, $offset, $perhal);
            
            while ($row = $res->fetch_assoc()) {
                $teamPict = $row["idteam"] . ".jpg";
                if (!file_exists("image/" . $teamPict)) {
                    $teamPict = "blank.jpg";
                }
                echo "<div class='team-card'>
                        <img src='image/$teamPict?".time()."' alt='Team Picture' class='team-image'>
                        <div class='teamdetail-container'>
                            <h4 class='team-name'>" . htmlspecialchars($row['teamname']) . "</h4>
                        </div>
                      </div>";
            }
?>