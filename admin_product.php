<?php
include 'connection.php';

if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'img/' . $image;

    if (file_exists($image_tmp_name)) {
        if (move_uploaded_file($image_tmp_name, $image_folder)) {
            // Image was successfully uploaded.
            $insert_product = mysqli_query($conn, "INSERT INTO `products`(`name`,`price`,`product_detail`,`image`) VALUES ('$product_name','$product_price','$product_detail','$image')") or die('query failed');
            if ($insert_product) {
                $message[] = 'Product successfully added.';
            } else {
                $message[] = 'Failed to add product to the database.';
            }
        } else {
            $message[] = 'Failed to move the uploaded file to the destination directory.';
        }
    } else {
        $message[] = 'No uploaded file found.';
    }
}
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
    unlink('image/' .$fetch_delete_image['image']);

    mysqli_query($conn,"DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    mysqli_query($conn,"DELETE FROM `cart` WHERE pid = '$delete_id'") or die('query failed');
    mysqli_query($conn,"DELETE FROM `wishlist` WHERE pid = '$delete_id'") or die('query failed');

    header('location:admin_product.php');

}

if (isset($_POST['update_product'])) {
    $update_id = $_POST['$update_id'];
    $update_name = $_POST['$update_name'];
    $update_price = $_POST['$update_price'];
    $update_detail = $_POST['$update_detail'];
    $update_image = $_POST['$update_image']['name'];
    $update_image_folder = 'image/' .$update_image;

    $update_query = mysqli_query($conn, "UPDATE `products` SET `id`= '$update_id',`name`= '$update_name',`price`= '$update_price',`product_detail`='$update_detail',`image`='$update_image' WHERE id = '$update_id'") or die('query failed');
    if ($update_query) {
       move_uploaded_file($update_image_tmp_name, $update_image_folder);
       header('location:admin_product.php');
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
    
    <title>Document</title>
    <style>

.add-products {
    margin: 200px; 
    margin-top: 80px;
    margin-left: 150px;
    padding: 20px;
    background-color: cornsilk;
    border: 1px solid black;
    border-radius: 5px;
    max-width: 600px; 
    margin-right: 120px;
    font-weight: bold;
}

.input-field {
    margin-bottom: 15px;
    margin-right: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
textarea {
    width: 100%;
    padding: 7px;
    border: 1px solid black;
    border-radius: 5px;
    font-size: 16px;
}
input[type="file"]{
    width: 100%;
    padding: 7px;
    border: 1px solid black;
    border-radius: 5px;
    font-size: 16px;
}
input[type="submit"]{
    width: 100%;
    padding: 7px;
    border: 1px solid black;
    border-radius: 5px;
    font-size: 16px;
}
.btn {
    background-color: #fff;
    color: orange;
    margin-top: 20px;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.btn:hover {
    background-color: #000;
}

    </style>
</head>
<body>


<div class="line2"></div>
<div class="add-products">
    <form  method="post" action="" enctype="multipart/form-data">
        <div class="input-field">
            <label>PRODUCT NAME:</label>
            <input type="text" name="name" required>
        </div>
        <div class="input-field">
            <label>PRODUCT PRICE:</label>
            <input type="text" name="price" required>
        </div>
        <div class="input-field">
            <label>PRODUCT DETAIL:</label>
           <textarea name="detail" id="" cols="30" rows="10" required></textarea>
        </div>
        <div class="input-field">
            <label>PRODUCT IMAGE</label>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" required>
        </div>
        <input type="submit" name="add_product" value="Add product" class="btn">
    </form>
</div>
<div class="line3"></div>
<div class="line4"></div>
<section class="show-products">
    <div class="box-container">
    <?php    
      $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
      if (mysqli_num_rows($select_products)>0) {
            while($fetch_products = mysqli_fetch_assoc($select_products)){

            
      
    ?>    
    
    <div class="box">

           <img src="http://localhost/ecommerceshop/img/656086.jpg" <?php echo $fetch_products['image']; ?> height="200px" width="200px" alt="">
            <p>price : $<?php echo $fetch_products['price']; ?></p>
            <h4><?php echo $fetch_products['name']; ?></h4>
            <details><?php echo $fetch_products['product_detail']; ?></details>
            <a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">Edit</a>
            <a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="return confirm(' want to delete this product');">Delete</a>

            </div>
        <?php 
            }  
         }else {
            echo '
            <div class="empty">
       <p>no products added yet!</p>
   </div>
            ';
        }
        ?>
        
    </div>
    <div class="update-container">
    <?php 
    if (isset($_GET['edit'])) {
        $edit_id = $_GET['edit'];
        $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$edit_id'") or die(mysqli_error($conn));

        if (mysqli_num_rows($edit_query) > 0) {
            while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                // Display the form for editing here
    ?>
    <?php
            }
        } else {
            echo "No product found for editing.";
        }
        echo " <script document.querySelector('.update-container').style.display='block'></script>";
    }
    ?>
</div>
<form method="post" class="swing" enctype="multipart/form-data">
                    <img src="image/<?php echo isset($fetch_edit['image']) ? $fetch_edit['image'] : ''; ?>" alt="">
                    <input type="hidden" name="update_id" value="<?php echo isset($fetch_edit['id']) ? $fetch_edit['id'] : ''; ?>">
                    <input type="text" name="update_name" value="<?php echo isset($fetch_edit['name']) ? $fetch_edit['name'] : ''; ?>">
                    <input type="number" name="update_price" min="0" value="<?php echo isset($fetch_edit['price']) ? $fetch_edit['price'] : ''; ?>">
                    <textarea name="update_detail" cols="30" rows="10"><?php echo isset($fetch_edit['product_detail']) ? $fetch_edit['product_detail'] : ''; ?></textarea>
                    <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png, image/webp">
                    <input type="submit" name="update_product" value="update" class="edit">
                    <input type="reset" name="" value="cancel" class="option-btn btn" id="close-form">
                </form>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>