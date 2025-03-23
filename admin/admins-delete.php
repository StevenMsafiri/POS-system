<?php

require "../config/function.php";

$paraResultId = checkParamId('id');

if(is_numeric($paraResultId))
{
    $adminId = validate($paraResultId);
    
    $admin = getById('admins', $adminId);

    if($admin['status'] == 200)
    {
        $adminDelete = delete('admins', $adminId);

        if($adminDelete)
        {
            redirect('admins.php', 'Admin Deleted Successfuly.');
        }
        else
        {
            redirect('admins.php', 'Something Went Wrong.');
        }
    }
    else
    {
        redirect('admins.php', $admin['message']);
    }

}
else
{
    redirect('admins.php', 'Something Went Wrong.');
}