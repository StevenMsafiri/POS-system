<?php

require_once 'config/function.php';

if(isset($_POST['loginBtn']))

{
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);


    if(!empty($email) && !empty($password))
    {
        $result = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email' LIMIT 1");
        
        if($result)
        { 
            if(mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_assoc($result);

                $hashedPassword = $row['password'];

                if(!password_verify($password, $hashedPassword))
                {
                    redirect('login.php', 'Invalid Password');
                }


                if($row['is_ban'] == 1)
                {
                    redirect('login', 'Your account has been banned. Contact you Admin');
            
                }

                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [

                    'user_id' =>$row['id'],
                    'name'=>$row['name'],
                    'email'=>$row['email'],
                    'phone'=>$row['phone']
                ];

                redirect('admin/index.php', 'Logged In Successfully');

            }
            else 
            {
                redirect('login.php', 'Invalid Email Address');
            }
        }
        else
        {
            redirect('login.php', 'Something Went Wrong!');
        }
    }
    else
    {
        redirect('login.php', 'All fields are manandatory');
    }
}

?>