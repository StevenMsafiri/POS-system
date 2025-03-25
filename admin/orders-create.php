<?php include ('./includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Add Order</h4>
            <a href="orders.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
        <?php alertMessage() ?>

            <form action="order-code.php" method="POST">

                <div class="d-flex flex-row  justify-content-start align-items-center gap-4">
                    <div>
                       <label for="" class="d-flex flex-column">Select Product *</label>
                       <select name="product_id" class="form-delect mySelect2 py-3" >
                        <option>-- Select Product --</option>

                        <?php
                        
                        $products = getAll('products');

                        if($products)
                        {
                            if(mysqli_num_rows($products) > 0)
                            {
                                foreach($products as $prodItem)
                                {
                                    ?>

                                    <option value="<?=$prodItem['id']?>"><?=$prodItem['name']?></option>

                                    <?php
                                }
                            }
                            else
                            {
                                echo '<option value = "">No product found</option>';
                            }
                        }
                        else
                        {
                            echo '<option value = "">Something Went Wrong</option>';
                        }
                        
                        ?>
                       </select>
                    </div>

                    <div>
                       <label for="quantity">Quantity *</label>
                       <input type="number" name="quantity" value="1" required class="form-control" id="quantity"/>
                    </div>
                
                    <div>
                        <br/>
                       <button type="submit" name = "addItem" class="btn btn-primary">Add Item</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Products</h4>
        </div>
        <div class="card-body" id="productArea">
            <?php
            if(isset($_SESSION['productItems']))
            {
            ?>

<div class="table-responsive mb-3" id="productContent">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php

                        $i=1;
                        foreach($_SESSION['productItems'] as $key => $item) :
                        
                       ?>
                        <tr>
                            <td><?=$i++; ?></td>
                            <td><?=$item['name']?></td>
                            <td><?=$item['price']?></td>
                            <td>
                                <div class="input_group d-flex gap-2 qtyBox">
                                    <input type="hidden" value="<?=$item['product_id'];?>" class="prodId" />
                                    <button class="input-group-text decrement">-</button>
                                    <input type="text" value="<?=$item['quantity'];?>"class="qty quantityInput"/>
                                    <button class="input-group-text increment">+</button>
                                </div>
                            </td>

                            <td><?=number_format($item['price'] * $item['quantity'], 0);?></td>
                            <td>
                                <a href="order-item-delete?index="<?=$key;?> class="btn btn-danger">Remove</a>
                            </td>
                        </tr>

                        <?php endforeach;?>

                    </tbody>
                </table>
            </div>

            <?php

            }
            else
            {
                echo '<h5>No items added</h5>';
            }
            ?>
        </div>
    </div>

</div>

<?php include ('./includes/footer.php');?>