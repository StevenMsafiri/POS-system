<?php include ('./includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Products</h4>
            <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $products = getAll('products');
                        if(!$products)
                        {
                            echo '<h4>Something Went Wrong</h4>';
                            return false;
                        }
                        if(mysqli_num_rows($products) > 0)
                        { 
                        ?>
                        <?php foreach($products as $productItem):?>
                        <tr>
                            <td><?=$productItem['id']?></td>
                            <td>
                                <img src ="../<?=$productItem['image'];?>" 
                                style="width:50px;height:50px;" alt="Product Image"/>
                             </td>
                            <td><?=$productItem['name']?></td>
                            <td>
                                <?php

                                if($productItem['status'] == 1)
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
                                <a href="products-edit.php?id=<?=$productItem['id']?>" class="btn btn-success btn-sm">Edit</a>
                                <a href="products-delete.php?id=<?=$productItem['id']?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                            
                        <?php
                        }else
                        {?>
                          
                          <tr>
                            <td colspan = "5">No record found</td>
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