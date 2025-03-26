<?php 


require '../config/function.php';


$paramResult = checkParamId('index');

if(is_numeric(($paramResult)))
{
    $indexValue =  validate($paramResult);

    if(isset($_SESSION['productItems'][$indexValue]) && isset($_SESSION['productItemIds']))
    {
        unset ($_SESSION['productItems'][$indexValue]);
        unset ($_SESSION['productItemIds'][$indexValue]);

        redirect('orders-create.php', 'Item removed successfully');
    }
    else
    {
        redirect('orders-create.php', 'No item removed');
    }
}
else
{
   redirect('orders-create.php', 'param not numeric');
}