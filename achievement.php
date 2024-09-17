<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievement</title>
</head>
<body>
    <?php
        include 'koneksi.php';

        $stmt = $mysqli->prepare("SELECT a.idachievement, a.idteam, a.name as achievename, a.description, a.date, t.idteam, t.name as teamname
        FROM achievement a INNER JOIN team t ON a.idteam = t.idteam");
        $stmt->execute();
        $res = $stmt->get_result();

        echo "<table border=1>
            <tr>
                <th>ID</th>
                <th>Team</th>
                <th>Name</th>
                <th>Date</th>
                <th>Description</th>
                <th>Action</th>
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
                </tr>";
            }
        echo "</table>";

        $mysqli->close();
    ?>
</body>
</html>