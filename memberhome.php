<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel ="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <section id="menu">
        <div class="logo">
            <img src="image/logo.png" alt="">
            <h2>Grizz Team</h2>
        </div>
    </section>
    <section id ="interface">
        <div class="navigation">
            <div class = "n1">
            <div class="search">
                <form action="memberhome.php" method="get">
                <?php
                    if(isset($_POST['idmember'])){
                        $idmember = $_POST['idmember'];
                        echo "<h1>$idmember</h1>";
                    }
                ?>
                    <input type="text" name ="cari" placeholder="Search"  value="<?php echo @$_GET["cari"]; ?>">
                    <a href="memberhome.php">Reset</a> 
                </form>
                </div>
            </div>

            <div class="profile">
                <i class="bi bi-person-circle"></i>
            </div>
        </div>

        <h3 class="i-name"> DashBoard </h3>
        <div class="tableall">
        <?php 

            ?>
        </div>
    </section>
</body>
</html>