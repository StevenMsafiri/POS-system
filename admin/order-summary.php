<?php

include('./includes/header.php');


if (!isset($_SESSION['productItems'])) {
    echo '<script> window.location.href = "orders-create.php"</script>';
}

?>



<div class="modal fade" id="orderSuccessModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="mb-3 p-4">
            <h5 id="orderPlaceSuccessMessage"></h5>
        </div>
        <a href="orders.php" class="btn btn-secondary">Close</a>
        <button type="button" class="btn btn-danger saveCustomer">Print</button>
        <button type="button" class="btn btn-warning saveCustomer">Download PDF</button>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid px-4 " style="margin-top: 12px;">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Order Summary</h4>
                    <a href="orders-create.php" class="btn btn-danger">Back to create order</a>
                </div>
                <div class="card-body">
                    <?php alertMessage(); ?>

                    <div id="myBillingArea">

                        <?php
                        if (isset($_SESSION['cphone'])) {
                            $phone = validate($_SESSION['cphone']);
                            $invoceNo = validate($_SESSION['invoice_no']);

                            $customerDetailsQuery = mysqli_query($conn, "SELECT * FROM customers WHERE phone='$phone' LIMIT 1");

                            if ($customerDetailsQuery) {
                                if (mysqli_num_rows($customerDetailsQuery) > 0) {
                                    $cRowData = mysqli_fetch_assoc($customerDetailsQuery);
                        ?>

                                    <table style="width: 100%; margin-bottom:20px;">
                                        <tr>
                                            <td style="text-align: center;" colspan="2">
                                                <h4 style="line-height:30px; font-size: 23px; margin:2px; padding:0;">JACKIES ENTERPRISES</h4>
                                                <p style="font-size: 16px; line-height:24px; margin:2px; padding:0;">#37305, Miti Mirefu, 2nd house, Majengo</p>
                                                <p style="font-size: 16px; line-height:24px; margin:2px; padding:0;">www.jackies.co.tz</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <h5 style="font-size: 20px; line-height:30px; margin:0; padding:0;">Customer Details</h5>
                                                <p style="font-size: 14px; line-height:20px; margin:0; padding:0;">Customer Name: <?= $cRowData['name'] ?></p>
                                                <p style="font-size: 14px; line-height:20px; margin:0; padding:0;">Customer Phone No: <?= $cRowData['phone'] ?></p>
                                                <p style="font-size: 14px; line-height:20px; margin:0; padding:0;">Customer Email Id: <?= $cRowData['email'] ?></p>
                                            </td>

                                            <td align="end">
                                                <h5 style="font-size: 20px; line-height:30px; margin:0; padding:0;">Invoice Details</h5>
                                                <p style="font-size: 14px; line-height:20px; margin:0; padding:0;">Invoice No:<?= $invoceNo; ?></p>
                                                <p style="font-size: 14px; line-height:20px; margin:0; padding:0;">Invoice Date:<?= date('d M Y'); ?></p>
                                                <p style="font-size: 14px; line-height:20px; margin:0; padding:0;">Address: #37305, Miti Mirefu, 2nd house, Majengo</p>
                                            </td>
                                        </tr>
                                    </table>

                        <?php
                                } else {
                                    echo '<h5>No customer found</h5>';
                                }
                            } else {
                                echo '<h5>Something Went Wrong</h5>';
                            }
                        }
                        ?>

                        <?php

                        if (isset($_SESSION['productItems'])) {
                            $sessionProducts = $_SESSION['productItems'];
                        ?>

                            <div class="table-responsive mb-3 mt-6">
                                <table style="width: 100%;" cellpadding="5">
                                    <thead>
                                        <tr>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="5%">ID</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;">Product Name</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Price</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="10%">Quantity</th>
                                            <th align="start" style="border-bottom: 1px solid #ccc;" width="15%">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $i = 1;
                                        $totalAmount = 0;

                                        foreach ($sessionProducts as $key => $row):
                                            $totalAmount += $row['price'] * $row['quantity']
                                        ?>
                                            <tr>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $i++ ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['name']; ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= number_format($row['price'], 0) ?></td>
                                                <td style="border-bottom: 1px solid #ccc;"><?= $row['quantity'] ?></td>
                                                <td style="border-bottom: 1px solid #ccc;" class="fw-bold">
                                                    <?= number_format($row['price'] * $row['quantity'], 0) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <tr>
                                            <td colspan="4" align="end" style="font-weight: bold;">Grand Total</td>
                                            <td colspan="1" style="font-weight: bold;"><?= number_format($totalAmount, 0); ?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="5">
                                                Payment Mode: <?= $_SESSION['payment_mode']; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        <?php
                        }

                        ?>

                    </div>

                    <?php if(isset($_SESSION['productItems'])) :?>
                        <div class="mt-4 text-end">
                            <button type="button" class="btn btn-primary px-4 mx-1" id="saveOrder">Save</button>
                        </div>
                    <?php endif;?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('./includes/footer.php'); ?>