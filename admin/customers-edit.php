<?php include('./includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit customer</h4>
            <a href="customers.php" class="btn btn-danger float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>
            <form action="code.php" method="POST">
                <?php

                $paramValue = checkParamId('id');

                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not an interger</h5>';

                    return false;
                }

                $customerData = getById('customers', $paramValue);

                if ($customerData) {
                    if ($customerData['status'] == 200) {
                        ?>
                        <input type="hidden" name="customerId" value="<?= $customerData['data']['id']; ?>" />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Name *</label>
                                <input type="text" name="name" required class="form-control" id="name" value="<?= $customerData['data']['name']; ?>" />
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email">Email *</label>
                                <input type="email" name="email" required class="form-control" id="email" value="<?= $customerData['data']['email'];?>" />
                            </div>

                            <div class=" col-md-12 mb-3">
                                <label for="phone">Phone *</label>
                                <input type="phone" name="phone" required class="form-control" id="phone" 
                                value="<?= $customerData['data']['phone'];?>" />
                            </div>

                            <div class=" col-md-6 mb-3">
                                <label for="status">Is Ban *</label>
                                <br/>
                                <input type="checkbox" name="status" id="status"
                                <?= $customerData['data']['status'] === '1' ? 'checked = "checked"': '';?> style="width:30px;height:30px;" />
                            </div>

                            <div class="col-md-6 mb-3 mt-3 text-end">
                                <button type="submit" name="updateCustomer" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                <?php
                    } else {
                        echo '<h5>' . $customerData['message'] . '</h5>';
                    }
                }else
                {
                    echo 'Something Went Wrong';
                    return false;
                }

                ?>
            </form>
        </div>
    </div>

</div>

<?php include('./includes/footer.php'); ?>