<?php

include ('../config/function.php');

if(!isset($_SESSION['productItems']))
{
    $_SESSION['productItems'] = [];
}

if(!isset($_SESSION['productItemIds']))
{
    $_SESSION['productItemIds'] = [];
}


if (isset($_POST['addItem'])) {

    $product_id = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $checkProduct = mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id'");

    if ($checkProduct) {

        if (mysqli_num_rows($checkProduct) > 0) {
            $row = mysqli_fetch_assoc($checkProduct);

            if ($row['quantity'] < $quantity) {
                redirect('orders-create.php', 'Only' . $row['quantity'] . 'quantity available!');
            }

            $productData = [

                'product_id' => $row['id'],
                'name' => $row['name'],
                'price' => $row['price'],
                'quantity' => $quantity,
            ];

            if (!in_array($row['id'], $_SESSION['productItemIds']))
            {


                array_push($_SESSION['productItemIds'], $row['id']);
                array_push($_SESSION['productItems'], $productData);
                

            } 
            else 
            {
                foreach ($_SESSION['productItems'] as $key => $productSessionItem) {
                    if ($productSessionItem['product_id'] == $row['id']) {

                        $newQuantity = $productSessionItem['quantity'] + $quantity;


                        $productData = [

                            'product_id' => $row['id'],
                            'name' => $row['name'],
                            'price' => $row['price'],
                            'quantity' => $newQuantity,
                        ];

                        $_SESSION['productItems'][$key] = $productData;
                    }
                }
            }

            redirect('orders-create.php', 'Item Added'. $row['name']);

        } else {
            redirect('orders-create.php', 'No such product found!');
        }
    } else {
        redirect('orders-create.php', 'Something Went Wrong!');
    }
}

if(isset($_POST['productIncDec']))
{

    $productId = validate($_POST['product_id']);
    $quantity = validate($_POST['quantity']);

    $flag = false;
    foreach($_SESSION['productItems'] as $key =>$item)
    {
        if($item['product_id'] == $productId)
        {
            $flag = true;
            $_SESSION['productItems'][$key]['quantity'] = $quantity;
        }
    }

    if($flag)
    {
        jsonResponses(200, 'success', 'Quantinty updated');
    }
    else
    {
        jsonResponses(500, 'success', 'Somethind Went Wrong. Please re-fresh');
    }
}

if(isset($_POST['proceedToPlaceOrderBtn']))
{
    $phone = validate($_POST['cphone']);
    $payment_mode = validate($_POST['payment_mode']);

    $checkCustomer = mysqli_query($conn, "SELECT * FROM  customers WHERE phone = '$phone' LIMIT 1");
    if($checkCustomer)
    {
        if(mysqli_num_rows($checkCustomer) > 0)
        {
            $_SESSION['invoice_no'] = "INV-".rand(111111,999999);
            $_SESSION['cphone'] = $phone;
            $_SESSION['payment_mode'] = $payment_mode;
            jsonResponses(200, 'success', "Customer Found");
        }

        else
        {
            $_SESSION['cphone'] = $phone;
            jsonResponses(404, 'Warning', "Customer Not Found");
        }
    }
    else
    {
        jsonResponses(500, 'Error', "Something Went Wrong");
    }

}


if(isset($_POST['saveCustomerBtn']))
{
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);

    if(!empty($name) || !empty($phone))
    {

        $data = [
            'name' =>$name,
            'phone' =>$phone,
            'email'=>$email
        ];

        $result = insert('customers', $data);

        if($result)
        {
            jsonResponses(200, "success", "Customer created successfully");
        }
        else
        {
            jsonResponses(500, "error", "Failed to create Customer");
        }
    }
    else
    {
        jsonResponses(422, "warning", "Please fill required fields");
    }
}

if(isset($_POST['saveOrder']))
{
    $phone = validate($_SESSION['cphone']);
    $invoice_no = validate($_SESSION['invoice_no']);
    $payment_mode = validate($_SESSION['payment_mode']);
    $order_placed_by_id = $_SESSION['loggedInUser']['user_id'];

    $checkCustomer = mysqli_query($conn, "SELECT * FROM customers WHERE phone = '$phone' LIMIT 1");

    if(!$checkCustomer)
    {
        jsonResponses(500, 'error', 'Something Went Wrong');
    }

    if(mysqli_num_rows($checkCustomer))
    {
        $customerData = mysqli_fetch_assoc($checkCustomer);

        if(!isset($_SESSION['productItems']))
        {
            jsonResponses(404, 'warning', 'No items to place order');
        }

        $sessionProducts = $_SESSION['productItems'];

        $totalAmount = 0;
        
        foreach($sessionProducts as $amItem)
        {
            $totalAmount += $amItem['price'] * $amItem["quantity"];
        }

        $data = [
            'customer_id' =>$customerData['id'],
            'tracking_no' => rand(11111, 99999),
            'invoice_no' => $invoice_no,
            'total_amount' =>$totalAmount,
            'order_date' => date('Y-m-d'),
            'order_status' => 'booked',
            'payment_mode' =>$payment_mode,
            'order_placed_by_id' =>$order_placed_by_id
        ];

        $result = insert('orders', $data);
        $lastOrderId = mysqli_insert_id($conn);

        foreach($sessionProducts as $prodItem)
        {
            $productId = $prodItem['product_id'];
            $price = $prodItem['price'];
            $quantity = $prodItem['quantity'];


            $dataOrderItem = [

                'order_id' => $lastOrderId,
                'product_id' => $productId,
                'price' => $price,
                'quantity' => $quantity
            ];

            $orderItemQuery = insert('order_items', $dataOrderItem);


            $chekProductQuantity = mysqli_query($conn, "SELECT * FROM products WHERE id = '$productId'");

            $productQtyData = mysqli_fetch_assoc($chekProductQuantity);

            $totalProductQty = $productQtyData['quantity'] - $quantity;

            $dataUpdate = [

                'quantity' => $totalProductQty
            ];


            $updateProductQty = update('products', $productId, $dataUpdate);

        }

        unset($_SESSION['productItemIds']);
        unset($_SESSION['productItems']);
        unset($_SESSION['cphone']);
        unset($_SESSION['payment_mode']);
        unset($_SESSION['invoice_no']);

        jsonResponses(200, 'success', 'Order placed Successfully');
    }
    else
    {
        jsonResponses(404, 'Warning', 'No customer found');
    }
}