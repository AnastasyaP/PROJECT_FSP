<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
</head>
<body>

<?php
    include 'koneksi.php';

    // Cek apakah form disubmit
    if (isset($_POST['btnSubmit'])) {
        echo "<pre>";
        print_r($_POST); // Debug: Tampilkan data yang dikirim dari form
        echo "</pre>";

        $name = $_POST['name'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $teams = $_POST['team'] ?? [];
        $idevent = $_POST['idevent']; // Ambil idevent dari POST

        $stmt = $mysqli->prepare("UPDATE event SET name=?, date=?, description=? WHERE idevent=?");
        $stmt->bind_param("sssi", $name, $date, $description, $idevent);
        $stmt->execute();
        $stmt->close();

        $stmt2 = $mysqli->prepare("DELETE FROM event_teams WHERE idevent=?");
        $stmt2->bind_param("i", $idevent);
        $stmt2->execute();
        $stmt2->close();

        if (!empty($teams)) {
            $stmt3 = $mysqli->prepare("INSERT INTO event_teams(idevent, idteam) VALUES(?, ?)");
            foreach ($teams as $team) {
                $stmt3->bind_param("ii", $idevent, $team);
                $stmt3->execute();
            }
            $stmt3->close();
        }

        header("Location: inserteventnew.php");
        exit();
    }

    // Jika halaman diakses dengan GET, ambil data event
    if (isset($_GET['idevent'])) {
        $id = $_GET["idevent"];
        $stmt = $mysqli->prepare("SELECT * FROM event WHERE idevent = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        // Ambil tim yang sudah terkait dengan event
        $stmt2 = $mysqli->prepare("SELECT * FROM event_teams WHERE idevent = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $res_team = $stmt2->get_result();

        $selected_teams = [];
        while ($team = $res_team->fetch_assoc()) {
            $selected_teams[] = $team['idteam'];
        }

        $stmt2->close();
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
    $stmt3 = $mysqli->prepare("SELECT idteam, name FROM team");
    $stmt3->execute();
    $res = $stmt3->get_result();

    while ($team = $res->fetch_assoc()) {
        $checked = in_array($team['idteam'], $selected_teams) ? "checked" : ""; // Tandai jika sudah dipilih
        echo "<input type='checkbox' name='team[]' value='" . $team['idteam'] . "' " . $checked . "> " . $team['name'] . "<br>";
    }
    $stmt3->close();
    ?><br>

    <label for="description">Description : </label>
    <textarea name="description" id="description"><?php echo $row['description']; ?></textarea><br><br>
    <input type="hidden" name="idevent" value="<?php echo $row['idevent']; ?>">
    <input type="submit" value="submit" name="btnSubmit">
</form>
</body>
</html>

