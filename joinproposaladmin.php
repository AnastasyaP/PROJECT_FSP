<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="stylesheet" type="text/css" href="style.css">
    <title>Join Proposal</title>
</head>
<body>
    <?php
        require_once('proposalclass.php');
        $proposal = new Proposal();

        $resproposal = $proposal->getProposalWaiting();
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
                 </div>
             </div>
             <div class="profile">
                 <i class="bi bi-person-circle"></i>
             </div>
        </div>

        <div class="tableall">
            <?php
                echo"<table border = '1'>";
                echo "<tr>
                    <th>Nama Member</th>
                    <th>Nama Team</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";

                    while($row = $resproposal->fetch_assoc()){
                    echo"<tr>
                        <td>".$row['member_name']."</td>
                        <td>".$row['team_name']."</td>
                        <td>".$row['description']."</td>
                        <td>".$row['status']."</td>
                        <td>
                         <form method='POST'>
                            <input type='hidden' name='idjoin_proposal' value='" . $row['idjoin_proposal'] . "'>
                            <button type='submit' name='action' value='approve' id=btnprop>Approve</button>
                            <button type='submit' name='action' value='reject' id=btnprop>Reject</button>
                        </form>
                        </td>
                        </tr>" ;
                    }
                echo"</table>";
            ?>
        </div>
    </section>
</body>
</html>