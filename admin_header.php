<?php
include 'connection.php';
session_start();

if (isset($_SESSION['admin_name']) && isset($_SESSION['admin_email'])) {
    $adminName = $_SESSION['admin_name'];
    $adminEmail = $_SESSION['admin_email'];
} else {
    
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
    <header class="header">
        <div class="flex">
            <a href="admin_pannel.php" class="logo">  <img src="img/pngtree-abstract-bee-and-honey-logo-symbols-vector-illustration-image_317538.jpg" height="80px" width="200px" alt="">

</a>
            <nav class="navbar">
                <a href="admin_pannel.php"><b>HOME</b></a>
                <a href="admin_product.php"><b>PRODUCT</b></a>
                <a href="admin_order.php"><b>ORDER</b></a>
                <a href="admin_user.php"><b>USERS</b></a>
                <a href="admin_message.php"><b>MESSAGE</b></a>
            </nav>
            <div class="icons">
                <i class="bi bi-person" id="user-btn"></i>
                <i class="bi bi-list" id="menu-btn"></i>
            </div>
            <div class="user-box">
   <p>username : <span><?php echo isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : ''; ?></span></p>
   <p>Email : <span><?php echo isset($_SESSION['admin_email']) ? $_SESSION['admin_email'] : ''; ?></span></p>
   <form action="" method="post">
    <button type="submit" class="logout-btn">log out</button>
   </form>
</div>

        </div>
    </header>
    <div class="banner">
        <div class="detail">
            <h1>Admin dashboard</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, placeat. Tempore est voluptate quod earum.</p>
        </div>
    </div>

    <div class="line4"></div>
          <section class="dashboard">
          <div class="box-container">
          <div class="box">
                <?php  
                $total_pendings = 0;
                $select_pendings = mysqli_query($conn, "SELECT * FROM `order` WHERE payment_status = 'pending'") or die('query failed');
                while ($fetch_pending = mysqli_fetch_assoc($select_pendings)) {
                    $total_pendings += $fetch_pending['total_price']; 
                }
                ?>
                <h3>$ <?php echo $total_pendings; ?>/-</h3>
                <p>total pendings</p>
            </div>
           
            <div class="box">
                <?php  
                $total_completes = 0;
                $select_completes = mysqli_query($conn, "SELECT * FROM `order` WHERE payment_status = 'complete'") or die('query failed');
                while ($fetch_completes= mysqli_fetch_assoc($select_completes)) {
                    $total_completes += $fetch_completes['total_price']; 
                }
                ?>
                <h3>$ <?php echo $total_completes; ?>/-</h3>
                <p>total completes</p>
            </div>

            <div class="box">
                <?php  
                $select_orders = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
                $num_of_orders = mysqli_num_rows($select_orders);
                ?>
                <h3> <?php echo $num_of_orders; ?> </h3>
                <p>order placed</p>
            </div>

            <div class="box">
                <?php  
                $select_products = mysqli_query($conn, "SELECT * FROM `order`") or die('query failed');
                $num_of_products = mysqli_num_rows($select_products);
                ?>
                <h3> <?php echo $num_of_products; ?> </h3>
                <p>product added</p>
            </div>
            
            <div class="box">
                <?php  
        
                $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
                $num_of_users = mysqli_num_rows($select_users);
                ?>
                <h3> <?php echo $num_of_users; ?> </h3>
                <p>total normal users</p>
            </div>

            <div class="box">
                <?php  
                $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                $num_of_admins = mysqli_num_rows($select_admins);
                ?>
                <h3> <?php echo $num_of_admins; ?> </h3>
                <p>total admin</p>
            </div>

            <div class="box">
                <?php  
                $select_users = mysqli_query($conn, "SELECT * FROM `users` ") or die('query failed');
                $num_of_users = mysqli_num_rows($select_users);
                ?>
                <h3> <?php echo $num_of_users; ?> </h3>
                <p>total registered users</p>
            </div>

            <div class="box">
                <?php  
                $select_message = mysqli_query($conn, "SELECT * FROM `message` ") or die('query failed');
                $num_of_message = mysqli_num_rows($select_message);
                ?>
                <h3> <?php echo $num_of_message; ?> </h3>
                <p>new messages</p>
            </div>
            
          </div>
           
          </section>
        

          
    <script type="text/javascript" src="script.js"></script>
</body>
</html>