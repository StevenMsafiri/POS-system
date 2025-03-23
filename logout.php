<?php

require_once 'config/function.php';

if($_SESSION['loggedIn'])
{
    logoutSession();

    redirect('login.php', 'Logged Out Successfully');

}
