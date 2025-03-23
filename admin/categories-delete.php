<?php

require "../config/function.php";

$paraResultId = checkParamId('id');

if(is_numeric($paraResultId))
{
    $categoryId = validate($paraResultId);
    
    $category = getById('categories', $categoryId);

    if($category['status'] == 200)
    {
        $categoryDelete = delete('categories', $categoryId);

        if($categoryDelete)
        {
            redirect('categories.php', 'Category Deleted Successfully.');
        }
        else
        {
            redirect('categories.php', 'Something Went Wrong.');
        }
    }
    else
    {
        redirect('categories.php', $category['message']);
    }

}
else
{
    redirect('categories.php', 'Something Went Wrong.');
}