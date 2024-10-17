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
        require_once('memberclass.php');
        $member = new Member();

        if(isset($_POST['btnregis'])){
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if($password == $repassword){
                $ecnpassword = md5($password);
                $profile = 'member';
    
                $newMember = [
                    'fname' => $fname,
                    'lname' => $lname,
                    'username' => $username,
                    'password' => $ecnpassword,
                    'profile' => $profile
                ];
    
                $member->register($newMember);
            } else {
                header("Location: register.php?error=Incorrect Repeat Password");
                exit();
            }
            header("Location: login.php?register=Successfully Registered🎇");
            exit();
        }

    ?>  
    <div id="login-container">
        <div id="login">
            <form action="register.php" method="post">
                <h1>REGISTER</h1>
                <?php
                    if(isset($_GET['error'])){
                        $psnerror = $_GET['error'];
                        echo "<p class='error'>$psnerror</p>";
                        
                    }
                ?>

                <label>First Name</label>
                <input type="text" name="fname" placeholder="FirstName">

                <label>Last Name</label>
                <input type="text" name="lname" placeholder="LastName">

                <label>Username</label>
                <input type="text" name="username" placeholder="UserName">

                <label>Password</label>
                <input type="password" name="password" placeholder="Password">

                <label>Repeat Password</label>
                <input type="password" name="repassword" placeholder="RepeatPassword">

                <button type="submit" name="btnregis">Register</button>
            </form>
        </div>
    </div>
   
</body>
</html>