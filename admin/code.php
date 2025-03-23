<?php

include '../config/function.php';

if (isset($_POST['saveAdmin'])) 
{
    $name = isset($_POST['name']) ? validate($_POST['name']) : '';
    $email = isset($_POST['email']) ? validate($_POST['email']) : '';
    $password = isset($_POST['password']) ? validate($_POST['password']) : '';
    $phone = isset($_POST['phone']) ? validate($_POST['phone']) : '';
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

   
    if (empty($name) || empty($email) || empty($password)) {
        redirect('admins-create.php', 'Please fill required fields.');
    }

    // Check if email already exists
    $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email'"); 

    if ($emailCheck && mysqli_num_rows($emailCheck) > 0) {
        redirect('admins-create.php', 'Email already used by another user.');
    }

   
    $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);

    // Data to insert
    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $bcrypt_password, 
        'phone' => $phone,
        'is_ban' => $is_ban
    ];

    // Insert data
    $result = insert('admins', $data);

    if ($result) {
        redirect('admins.php', 'Admin created successfully!');
    } else {
        redirect('admins-create.php', 'Something went wrong.');
    }
}

if(isset($_POST['updateAdmin']))
{
    
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);

    if($adminData['status'] != 200)
    {
        redirect('admins-edit.php?id='.$adminId, 'Please fill required fields.');
    }


    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if (empty($name) || empty($email)){
        redirect('admins-create.php', 'Please fill required fields.');
    }

    // Check if email already exists
    $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email' AND  id!='$adminId'"); 

    if ($emailCheck && mysqli_num_rows($emailCheck) > 0) {
        redirect('admins-edit.php', 'Email already used by another user.');
    }

    if(!empty($password))
    {
        $harshedPassword = password_hash($password, PASSWORD_BCRYPT);
    }else
    {
        $harshedPassword = $adminData['data']['password'];
        
    }

    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $harshedPassword, 
        'phone' => $phone,
        'is_ban' => $is_ban
    ];

    // Updates data

    $result = update('admins', $adminId, $data);

    if ($result) {
        redirect('admins-edit.php?id='.$adminId, 'Admin Updated successfully!');
    } else {
        redirect('admins-edit.php?id='.$adminId, 'Something went wrong.');
    }
   

}


if(isset($_POST['saveCategory']))
{
    $data = [
        'name' => validate($_POST['name']),
        'description' => validate($_POST['description']),
        'status' => validate($_POST['status']) == true ? 1:0
    ];

    // Insert data
    $result = insert('categories', $data);

    if ($result) {
        redirect('categories.php', 'Admin created successfully!');
    } else {
        redirect('categories-create.php', 'Something went wrong.');
    }
}

if (isset($_POST['updateCategory']))
{
    $categoryId = validate($_POST['categoryId']);

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = validate($_POST['status']) == true ? 1:0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    // updates data
    $result = update('categories', $categoryId, $data);

    if ($result) {
        redirect('categories-edit.php?id='.$categoryId, 'Category update successfully!');
    } else {
        redirect('categories-edit.php?id='.$categoryId, 'Something went wrong.');
    }
}


if (isset($_POST['saveProduct']))

{
    $categoryId = validate($_POST['category']);
    $name = validate($_POST['name']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $description = validate($_POST['description']);
    $status = validate($_POST['status']) == true ? 1:0;

    if ($_FILES['image']['size'] > 0) {
        $path = '../assets/uploads/products';
    
        if (!is_dir($path)) {
            mkdir($path, 0777, true); 
        }
    
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;
    
        if(move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename)) {
            $finalImage = "assets/uploads/products/" . $filename;
        } else {
            $finalImage = '';
        }
    } else {
        $finalImage = '';
    }

    $data = [
        'category_id' => $categoryId,
        'name' => $name,
        'price' => $price,
        'image' =>$finalImage,
        'quantity' => $quantity,
        'description' => $description,
        'status' => $status
    ];

    $result = insert('products', $data);

    if ($result) {
        redirect('products.php', 'Product created successfully!');
    } else {
        redirect('products-create.php','Something went wrong.');
    }

}

if (isset($_POST['updateProduct']))

{

    $productId = validate($_POST['product_id']);

    $productData = getById('products',$productId);

    if(!$productData)
    {
        redirect('products.php', 'No such product found');
    }


    $categoryId = validate($_POST['category']);
    $name = validate($_POST['name']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $description = validate($_POST['description']);
    $status = validate($_POST['status']) == true ? 1:0;

    if ($_FILES['image']['size'] > 0) {
        $path = '../assets/uploads/products';
    
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = time() . '.' . $image_ext;
    
        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename);

        $finalImage = "assets/uploads/products/" . $filename;

        $deleteImage = "../".$productData['data']['image'];

        if(file_exists($deleteImage))
        {
            unlink($deleteImage);
        }
         
    } else {
        $finalImage = $productData['data']['image'];
    }

    $data = [
        'category_id' => $categoryId,
        'name' => $name,
        'price' => $price,
        'image' =>$finalImage,
        'quantity' => $quantity,
        'description' => $description,
        'status' => $status
    ];

    $result = update('products',$productId,  $data);

    if ($result) {
        redirect('products-edit.php?id='.$productId, 'Product updated successfully!');
    } else {
        redirect('products-edit.php?id='.$productId,'Something went wrong.');
    }

}

?>
