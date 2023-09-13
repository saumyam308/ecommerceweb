<?php 
include 'connection.php';
session_start();
if(isset($_POST['submit-btn'])) {
   

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn,$filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn,$filter_password);

    
    $select_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('query failed');

    if(mysqli_num_rows($select_user)>0) {
        $row = mysqli_fetch_assoc($select_user);
        if($row['user_type']== 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_pannel.php');
        }elseif($row['user_type']== 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:index.php');
        } else{
            $message[] = 'incorrect email or password';
        }
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Register page</title>
</head>
<body>

    <section class=form-container>
    <?php
    if (isset($message)) {
        if (is_array($message)) {
            foreach ($message as $msg) {
                echo '
                <div class="message">
                    <span>' . $msg . '</span>
                    <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                </div>
                ';
            }
        } else {
            echo '
            <div class="message">
                <span>' . $message . '</span>
                <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
            </div>
            ';
        }
    }
    ?>
         <form action="" method="post">
               <h1>Login now</h1>
               <div class="input-field">
                <label for="">Your email</label><br>
                <input type="email" name="email" placeholder="enter your email" required>
               </div>

             <div class="input-field">
                 <label for="">Your password</label><br>
                 <input type="password" name="password" placeholder="enter your password" required>
               </div>
               
               <input type="submit" name="submit-btn" value="login now" class="btn" >
               <p>do not have an account <a href="register.php">register here</a></p>
         </form>
    </section>
</body>
</html>