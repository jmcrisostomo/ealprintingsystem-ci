<?= view('admin/layout/header'); ?>

<div class="wrapper">

    <?= view('admin/layout/sidebar') ?>

    <div class="main">

        <?= view('admin/layout/navbar') ?>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/r-2.2.9/datatables.min.css"/>

        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3">Category</h1>
                
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCategory">Add Category</button>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table id="dataTable" class="table table-striped bg-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>State</th>
                                    <th>Category Name</th>
                                    <th>Date Modified</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Do loop here -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
 
        <!-- modalAddCategory -->
        <div class="modal fade" id="modalAddCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddCategoryLabel">Add Category</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form">
                            <div class="input-control">
                                <input type="text" name="category_name" class="input-field" placeholder="Category Name" required>
                                <label for="category_name" class="input-label">Category Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnAddCategory" type="button" class="btn btn-primary">Add Category</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modalEditCategory -->
        <form action="<?= base_url('/admin/category/edit') ;?>" method="POST">
        <div class="modal fade" id="modalEditCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditCategoryLabel">Edit Category</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form">
                            <div class="input-control">
                                <input type="text" name="category_name" class="input-field" placeholder="Category Name" required>
                                <label for="category_name" class="input-label">Category Name</label>
                            </div>
                            <input type="hidden" name="category_id" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnEditCategory" type="submit" class="btn btn-primary btn">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        </form>

        <!-- modalEnableCategory -->
        <div class="modal fade" id="modalEnableCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEnableCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEnableCategoryLabel">Enable Category</h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to enable <span id="textEnableCategory" class="fw-bold"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button id="btnEnableCategory" type="button" class="btn btn-primary">Enable</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modalDisableCategory -->
        <div class="modal fade" id="modalDisableCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDisableCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDisableCategoryLabel">Disable Category</h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to disable <span id="textDisableCategory" class="fw-bold"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button id="btnDisableCategory" type="button" class="btn btn-primary">Disable</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modalDeleteCategory -->
        <form action="<?= base_url('/admin/category/remove') ;?>" method="POST">
        <div class="modal fade" id="modalDeleteCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteCategoryLabel">Delete Category</h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove <span id="textDeleteCategory" class="fw-bold"></span>?</p>
                        <input type="hidden" name="category_id" >
                    </div>
                    <div class="modal-footer">
                        <button id="btnDeleteCategory" type="submit" class="btn btn-primary">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        <script src="<?= base_url("assets/admin/js/show-product-category.js"); ?>"></script>

    </div>
</div>

<?= view('admin/layout/footer') ?>