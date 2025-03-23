<?php

if(isset($_SESSION['loggedIn']))

{
    $email = validate($_SESSION['loggedInUser']['email']);

    $result = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email' LIMIT 1");

    if(mysqli_num_rows($result) == 0)
    {
        logoutSession();
        redirect('../login.php', 'Access Denied');
    }
    else
    {
        $row = mysqli_fetch_assoc($result);

        if($row['is_ban'] == 1)
        {
            logoutSession();
            redirect('../login.php', 'Your account has been banned!. Please contact admin' );
        }

    }
}
else
{
    redirect('../login.php', 'Login to continue...');
}