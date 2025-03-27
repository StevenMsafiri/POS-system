<?php include ('./includes/header.php');?>

<!-- Modal -->
<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label for="c_name">Enter Customer Name</label>
            <input name="c_name" id="c_name" type="text" class="form-control"/>
        </div>

        <div class="mb-3">
            <label for="c_number">Enter Customer Phone No.</label>
            <input name="c_number" id="c_number" type="text" class="form-control"/>
        </div>

        <div class="mb-3">
            <label for="c_email">Enter Customer Email(optional)</label>
            <input name="c_email" id="c_email" type="text" class="form-control"/>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary saveCustomer">Save</button>
      </div>
    </div>
  </div>
</div>

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
                if(empty($_SESSION['productItems'])){

                    unset($_SESSION['productItems']);
                    unset($_SESSION['productItemIds']);
                }
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
                        foreach($_SESSION['productItems'] as $key => $item):    
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
                                <a href="order-item-delete.php?index=<?php echo $key?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>

                        <?php endforeach;?>

                    </tbody>
                </table>

                <div class="mt-2 mb-3">
                <hr>
                <div class="row">
                    <div class="col-md-4">
                    <label for="payment mb-1">Select Payment Mode</label>
                    <select class="form-select" id="payment">
                        <option value=" ">-- Select payment mode --</option>
                        <option value="Cash Payment">Cash Payment</option>
                        <option value="Online Payment">Online Payment</option>
                    </select>
                    </div>

                    <div class="col-md-4">
                        <label for="number">Enter Customer Phone number</label>
                        <input type="number" id="number" class="form-control" value=""/>
                    </div>

                    <div class="col-md-4">
                        <br/>
                        <button type="button" class="btn btn-warning w-100 proceedToPlaceOrder">Proceed to place order</button>
                    </div>
                </div>
            </div>
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