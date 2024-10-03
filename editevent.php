<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>

<?php
    //include 'koneksi.php';
    require_once("event_teamclass.php");
    require_once("eventclass.php");

    // Cek apakah form disubmit
    if (isset($_POST['btnSubmit'])) {

        $name = $_POST['name'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $teams = $_POST['team'];
        $idevent = $_POST['idevent']; // Ambil idevent dari POST

        $event= new Event();
        $event_team = new Event_Team();

        $eventdata =[
            'name' => $name,
            'date' => $date,
            'description' => $description
        ];

        $event->updateEvent($idevent,$eventdata);
        $event_team->deleteEvenTeam($idevent);

        $data = [];
        foreach($teams as $team){
            $data[]= [
                'idevent' => $idevent,
                'idteam' => $team
            ];
        }

        if(!empty($data)){
            $event_team->insertEvenTeam($data);
        }

        header("Location: inserteventnew.php");
        exit();
    }
?>
    <?php
    // Jika halaman diakses dengan GET, ambil data event
    if (isset($_GET['idevent'])) {
        $id = $_GET["idevent"];
        
        $event = new Event();
        $eventeam = new Event_Team();

        $res = $event->getEvent($id);
        $row = $res->fetch_assoc();

        $event_team = $eventeam->getEventTeam($id);
        $selected_teams = [];
        while ($team = $event_team->fetch_assoc()) {
            $selected_teams[] = $team['idteam'];
        }
    } else {
        echo "ID event tidak ditemukan.";
        exit();
    }
    ?>

<form action="editevent.php" method="post">
    <label for="name">Game Event : </label>
    <input type="text" id="name" name="name" value="<?php echo $row["name"]; ?>"><br><br>
    <label for="date">Event Date :</label>
    <input type="date" id="date" name="date" value="<?php echo $row["date"]; ?>"><br><br>
    <label for="team">Team :</label><br>
    <?php
    // Ambil semua tim untuk ditampilkan
    $event_team = new Event_Team();
    $teams = $event_team->readEventTeam();

    while ($team = $teams->fetch_assoc()) {
        $checked = in_array($team['idteam'], $selected_teams) ? "checked" : ""; // Tandai jika sudah dipilih
        echo "<input type='checkbox' name='team[]' value='" . $team['idteam'] . "' " . $checked . "> " . $team['name'] . "<br>";
    }
    ?><br>

    <label for="description">Description : </label>
    <textarea name="description" id="description"><?php echo $row['description']; ?></textarea><br><br>
    <input type="hidden" name="idevent" value="<?php echo $row['idevent']; ?>">
    <input type="submit" value="submit" name="btnSubmit">
</form>
</body>
</html>

