<?php
include 'connection.php';

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
   
    mysqli_query($conn,"DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    $message[] = 'user removed successfully';

    header('location:admin_user.php');
}
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    
    <title>Document</title>
</head>
<body>
<?php include 'admin_header.php';?>
<?php 
    if (isset($message)) {
        foreach ($msg as $message) {
            echo '
            <div class="message">
              <span>".$msg."</span>   
            <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>      
            </div>
            ';
        }
    }

?>
<div class="line4"></div>
<section class="message-container">
    <h1 class="title">Total user account</h1>
    <div class="box-container">
        <?php 
        $select_users = mysqli_query($conn,"SELECT * FROM `users`") or die('query failed');
        if (mysqli_num_rows($select_users)>0) {
                while ($fetch_users = mysqli_fetch_assoc($select_users)) {
                    ?>
                    <div class="box">
                        <p>user id: <span><?php echo $fetch_users['id']; ?></span></p>
                        <p>name: <span><?php echo $fetch_users['name']; ?></span></p>
                        <p>email: <span><?php echo $fetch_users['email']; ?></span></p>
                        <p>user type : <span style="color: <?php if($fetch_users['user_type']== 'admin'){echo 'orange';} ?>"><?php echo $fetch_users['user_type']; ?></span></p>
                        <a href="admin_user.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this message');">Delete</a>
                    </div>
                    <?php
                }
        }else {
            echo '
            <div class="empty">
       <p><b>No products added yet!</b></p>
   </div>
            ';
        }
    ?>
    </div>

</section>

<div class="line"></div>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>