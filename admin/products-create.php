<?php include ('./includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Add product</h4>
            <a href="products.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
        <?php alertMessage() ?>

            <form action="code.php" method="POST" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-md-12 mb-3">
                       <label for="name">Select Category *</label>
                       <select name="category" class="form-select">
                          <option value="">Select Category</option>
                          <?php
                          $categories = getAll('categories');
                          if($categories)
                          {
                            if(mysqli_num_rows($categories) > 0)
                            {
                                foreach($categories as $category)
                                {
                                    echo '<option value = "'.$category['id'].'">'.$category['name'].'</option>';
                                }
                            }
                            else
                            {
                                echo '<option value = "">No categories found</option>';
                            }
                          }
                          else
                          {
                            echo '<ption value = "" >Something Went Wrong</ption>';
                          }
                          ?>
                       </select>
                    </div>
                    <div class="col-md-12 mb-3">
                       <label for="name">Product Name *</label>
                       <input type="text" name="name" required class="form-control" id="name"/>
                    </div>

                    <div class="col-md-4 mb-3">
                       <label for="price">Price *</label>
                       <input type="number" name="price" required class="form-control" id="price"/>
                    </div>

                    <div class="col-md-4 mb-3">
                       <label for="quantity">Quantity *</label>
                       <input type="number" name="quantity" required class="form-control" id="quantity"/>
                    </div>

                    <div class="col-md-4 mb-3">
                       <label for="image">Image*</label>
                       <input type="file" name="image" class="form-control" id="image"/>
                    </div>
               
                    <div class="col-md-12 mb-3">
                       <label for="description">Description *</label>
                       <textarea type="description" name="description" required class="form-control" id="description"></textarea>
                    </div>

                    <div class="col-md-6 ">
                       <label for="status">Status (Uncheck=Visible, Checked=Hidden)</label>
                       <br/>
                       <input type="checkbox" name="status" id="status" style = "width:30px;height:30px;"/>
                    </div>
                
                    <div class="col-md-6 mb-3 text-end">
                        <br/>
                       <button type="submit" name = "saveProduct" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<?php include ('./includes/footer.php');?>