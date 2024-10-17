<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
        session_start();
        require_once("memberclass.php");

        $member = new Member();

        if(isset($_POST['username']) && isset($_POST['password'])){
            $usn = $_POST['username'];
            $pwd = $_POST['password'];
            $encpwd = md5($pwd);

            $memberData = [
                'username' => $usn,
                'password' => $encpwd
            ];

            if(empty($usn)){
                header("Location: login.php?error=Username cannot be empty");
            }else if(empty($pwd)){
                header("Location: login.php?error=Password cannot be empty");
            }else{
                $res = $member->checkLogin($memberData);
                if($res->num_rows == 1){
                    if($row = $res->fetch_assoc()){
                        if($row['profile']=='member'){
                            $_SESSION['idmember'] = $row['idmember'];
                            header("Location: memberhome.php?idmember=".$row['idmember']."&login=success");
                            exit();
                        } else if($row['profile']=='admin'){
                            header("Location: adminhome.php?login=success");
                            exit();
                        }

                       // header("Location: memberhome.php?idmember=".$row['idmember']."login=success");
                        // header("Location: proposalmember.php");
                        // exit();
                    }
                } else{
                    header("Location: login.php?login=failed");
                    exit();
                }
            }
        }
    ?>

    <div id="login-container">
        <div id="login">
            <form action="login.php" method="post">
                <h1>LOGIN</h1>
                <?php
                    if(isset($_GET['error'])){
                        $psnerror = $_GET['error'];
                        echo "<p class='error'>$psnerror</p>";

                    }
                    if(isset($_GET['register'])){
                        $psn = $_GET['register'];
                        echo "<p class='success'>$psn</p>";
                    }
                ?>
                <label>Username</label>
                <input type="text" name="username" placeholder="UserName">

                <label>Password</label>
                <input type="password" name="password" placeholder="Password">

                <input type="hidden" name="idmember">
                <button type="submit">Login</button><br>

                <label id="regis">Don't have an account yet?<a href="register.php"> Register here</a></label>
            </form>

        </div>
    </div>
   
</body>
</html>