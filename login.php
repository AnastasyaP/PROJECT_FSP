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
            if(isset($_POST['username']) && isset($_POST['password'])){
                function validate($data){
                    $data = trim($data);
                    $data = stripsplashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                $usn = validate($_POST['username']);
                $pwd = validate($_POST['password']);

                if(empty($usn)){

                }else if(empty($pwd)){
                    
                }else{
                    echo 'Valid input';
                }
            }
        ?>
        
    <div id="login-container">
        <div id="login">
            <form action="">
                <h1>LOGIN</h1>
                <label>Username</label>
                <input type="text" name="username" placeholder="UserName">

                <label>Password</label>
                <input type="password" name="password" placeholder="Password">

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
   
</body>
</html>