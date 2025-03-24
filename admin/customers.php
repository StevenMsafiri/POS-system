<?php include ('./includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Customers</h4>
            <a href="customers-create.php" class="btn btn-primary float-end">Add Customer</a>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $customers = getAll('customers');
                        if(!$customers)
                        {
                            echo '<h4>Something Went Wrong</h4>';
                            return false;
                        }
                        if(mysqli_num_rows($customers) > 0)
                        { 
                        ?>
                        <?php foreach($customers as $customerItem):?>
                        <tr>
                            <td><?=$customerItem['id']?></td>
                            <td><?=$customerItem['name']?></td>
                            <td>
                                <?php

                                if($customerItem['status'] == 1)
                                {
                                    echo '<span class="badge bg-danger">Hidden</span>';
                                }
                                else
                                {
                                    echo '<span class="badge bg-primary">Visible</span>';
                                }

                                ?>
                            </td>
                            <td>
                                <a href="customers-edit.php?id=<?=$customerItem['id']?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="customers-delete.php?id=<?=$customerItem['id']?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                            
                        <?php
                        }else
                        {?>
                          
                          <tr>
                            <td colspan = "4">No record found</td>
                          </tr>
                          
                        <?php
                        }
                        ?>
 
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include ('./includes/footer.php');