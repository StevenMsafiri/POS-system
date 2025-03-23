<?php include('./includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit product</h4>
            <a href="products.php" class="btn btn-danger float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">

                <?php

                $paramValue = checkParamId('id');

                if (!is_numeric($paramValue)) {
                    echo '<h5>Id is not an interger</h5>';

                    return false;
                }

                $product = getById('products', $paramValue);

                if ($product) {
                    if ($product['status'] == 200) {

                ?>
                        <input name="product_id" type="hidden" value="<?=$product['data']['id'];?>"/>
                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label for="name">Select Category *</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <?php
                                    $categories = getAll('categories');
                                    if ($categories) {
                                        if (mysqli_num_rows($categories) > 0) {
                                            foreach ($categories as $category) {
                                                echo '<option value = "' . $category['id'] . '">' . $category['name'];
                                                
                                            if($product['data']['category_id'] == $category['id'])
                                            {
                                                echo '<option value = "' . $category['id'] .'" selected >' . $category['name'];
                                            } 

                                                echo '</option>';
                                            }
                                        } else {
                                            echo '<option value = "">No categories found</option>';
                                        }
                                    } else {
                                        echo '<ption value = "" >Something Went Wrong</ption>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="name">Product Name *</label>
                                <input type="text" name="name" required class="form-control" id="name"
                                value="<?=$product['data']['name'];?>" />
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="price">Price *</label>
                                <input type="number" name="price" required class="form-control" id="price"
                                value="<?=$product['data']['price'];?>" />
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="quantity">Quantity *</label>
                                <input type="number" name="quantity" required class="form-control" id="quantity"
                                value="<?=$product['data']['quantity'];?>" />
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="image">Image*</label>
                                <input type="file" name="image" class="form-control" id="image" 
                                value="../<?=$product['data']['image']?>" />
                                <img name="image" class="form-control" id="image" 
                                src="../<?=$product['data']['image'];?>" style = "width:40px; height:40px; " />
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description">Description *</label>
                                <textarea type="description" name="description" required class="form-control" id="description"><?=$product['data']['description'];?></textarea>
                            </div>

                            <div class="col-md-6 ">
                                <label for="status">Status (Uncheck=Visible, Checked=Hidden)</label>
                                <br />
                                <input type="checkbox" name="status" id="status" style="width:30px;height:30px;" <?=$product['data']['name'] == true ? 'checked': ''; ?>  />
                            </div>

                            <div class="col-md-6 mb-3 text-end">
                                <br />
                                <button type="submit" name="updateProduct" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                <?php

                    } else {
                        echo '<h5>' . $product['message'] . '</h5>';
                    }
                } else {
                    echo 'Something Went Wrong';
                    return false;
                }

                ?>



            </form>
        </div>
    </div>

</div>

<?php include('./includes/footer.php'); ?>