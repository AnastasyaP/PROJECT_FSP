<?php
    require_once("teamclass.php");

    if(isset($_POST['btnSubmit'])){
        if($_FILES['photo']['name']){
            if(!$_FILES['photo']['error']){
                $file_info = getimagesize($_FILES['photo']['tmp_name']);
                if(empty($file_info)){
                    $message = "The uploaded file doesn't seem to be an image.";
                } else{
                    $imgFileType = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                    
                    if($imgFileType === 'jpg'){
                        $teamName = $_POST['name'];
                        $games = $_POST['game'];

                        $team = new Team();

                        foreach($games as $game){
                            $teamData = [
                                'idgame' => $game,
                                'name' => $teamName
                            ];
                        }
                        $idteam = $team->insertTeam($teamData);

                        $target_dir = "image/";
                        $newname = $target_dir . $idteam . "." . $imgFileType;

                        if(move_uploaded_file($_FILES['photo']['tmp_name'], $newname)){
                            $message = 'Congratulations! Your file was accepted.';
                        } else {
                            $message = 'File upload failed. Please check permissions and file path.';
                        }

                        header("Location: insertteam.php?result=success");
                        exit();
                    } else{
                        $message = "Your file is not jpg!";
                    }
                }
            } else{
                $message = 'Ooops! Your upload triggered the following error: ' . $_FILES['photo']['error'];
            }
        } else{
            $message = 'You did not select any file!'; 
        }
        echo $message;
    }
?>