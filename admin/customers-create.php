<?php include ('./includes/header.php');?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Add customer</h4>
            <a href="customers.php" class="btn btn-primary float-end">Back</a>
        </div>
        <div class="card-body">
        <?php alertMessage() ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                       <label for="name">Name *</label>
                       <input type="text" name="name" required class="form-control" id="name"/>
                    </div>
               
                    <div class="col-md-12 mb-3">
                       <label for="email">Email *</label>
                       <input type="email" name="email" required class="form-control" id="email"/>
                    </div>
    
                    <div class="col-md-12 mb-3">
                       <label for="phone">Phone *</label>
                       <input type="phone" name="phone" required class="form-control" id="phone"/>
                    </div>
               
                    <div class="col-md-6 mb-3">
                       <label for="status">Status (Unchecked=Visible, Checked=Hidden) *</label>
                       <br/>
                       <input type="checkbox" name="status" id="status" style = "width:30px;height:30px;"/>
                    </div>
                
                    <div class="col-md-6 mb-2 mt-3 text-end">
                       <button type="submit" name="saveCustomer" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<?php include ('./includes/footer.php');?>