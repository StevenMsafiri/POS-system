<?php include('./includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Edit admin</h4>
            <a href="admins.php" class="btn btn-danger float-end">Back</a>
        </div>
        <div class="card-body">
            <?php alertMessage() ?>
            <form action="code.php" method="POST">
                <?php
                if (isset($_GET['id'])) {
                    if (!empty($_GET['id'])) {
                        $adminId = $_GET['id'];
                    }
                } else {
                    echo '<h5>No Id Found</h5>';
                    return false;
                }

                $adminData = getById('admins', $adminId);

                if ($adminData) {
                    if ($adminData['status'] == 200) { ?>
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>" />
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name">Name *</label>
                                <input type="text" name="name" required class="form-control" id="name" value="<?= $adminData['data']['name']; ?>" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email">Email *</label>
                                <input type="email" name="email" required class="form-control" id="email" value="<?= $adminData['data']['email'];?>" />
                            </div>

                            <div class=" col-md-6 mb-3">
                                <label for="password">Password *</label>
                                <input type="password" name="password" class="form-control" id="password"/>
                            </div>

                            <div class=" col-md-6 mb-3">
                                <label for="phone">Phone *</label>
                                <input type="phone" name="phone" required class="form-control" id="phone" 
                                value="<?= $adminData['data']['phone'];?>" />
                            </div>

                            <div class=" col-md-3 mb-3">
                                <label for="is_ban">Is Ban *</label>
                                <br/>
                                <input type="checkbox" name="is_ban" id="is_ban"
                                <?= $adminData['data']['is_ban'] === '1' ? 'checked = "checked"': '';?> style="width:30px;height:30px;" />
                            </div>

                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                            </div>
                        </div>

                <?php
                    } else {
                        echo '<h5>' . $adminData['message'] . '</h5>';
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