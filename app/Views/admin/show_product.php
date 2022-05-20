<?= view('admin/layout/header'); ?>

<div class="wrapper">

    <?= view('admin/layout/sidebar') ?>

    <div class="main">

        <?= view('admin/layout/navbar') ?>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/r-2.2.9/datatables.min.css"/>

        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3">Products</h1>
                
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddProduct">Add Product</button>
                </div>

                <div class="row">
                    <div class="col-12">
                        <table id="dataTable" class="table table-striped bg-light" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>State</th>
                                    <th>SKU</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Product Stock</th>
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
 
        <!-- modalAddProduct -->
        <div class="modal fade" id="modalAddProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddProductLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAddProductLabel">Add Product</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form">
                            <div class="input-control">
                                <input type="text" name="product_name" class="input-field" placeholder="Product Name" required>
                                <label for="product_name" class="input-label">Product Name</label>
                            </div>
                            <div class="input-control mb-5">
                                <textarea style="resize:none" name="description" class="input-field" placeholder="Description"></textarea>
                                <label for="description" class="input-label">Description</label>
                            </div>
                            <div class="input-control">
                                <select name="category" class="input-field form" placeholder="Category" required>
                                    <?php if ($category_data) : ?>
                                        <option value="-1">Select Product Category</option>
                                        <?php foreach ($category_data as $category) : ?>
                                            <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <option value="-1" disabled>No Product Category</option>
                                    <?php endif; ?>
                                </select>
                                <label for="category" class="input-label">Category</label>
                            </div>
                            <div class="input-control">
                                <input type="number" name="price" class="input-field" placeholder="Price" required>
                                <label for="price" class="input-label">Price</label>
                            </div>
                            <div class="input-control">
                                <input type="text" name="sku" class="input-field" placeholder="SKU" required>
                                <label for="sku" class="input-label">SKU</label>
                            </div>
                            <div class="d-flex">
                                <div class="input-control w-50 me-2">
                                    <input type="text" name="ceiling_stock" class="input-field" placeholder="Ceiling Stock" required>
                                    <label for="ceiling_stock" class="input-label" pattern="/^[0-9]+$/">Ceiling Stock</label>
                                </div>
                                <div class="input-control w-50">
                                    <input type="text" name="flooring_stock" class="input-field" placeholder="Flooring Stock" required>
                                    <label for="flooring_stock" class="input-label" pattern="/^[0-9]+$/">Flooring Stock</label>
                                </div>
                            </div>
                            <input class="form-control" id="product_image" type="file" name="product_image" accept=".jpeg,.jpg,.png,.bmp,.tiff,.tif" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnAddProduct" type="button" class="btn btn-primary">Add Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modalEditProduct -->
        <form action="<?= base_url('/admin/product/edit') ;?>" method="POST">
        <div class="modal fade" id="modalEditProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditProductLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditProductLabel">Edit Product</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form">
                            <div class="input-control">
                                <input type="text" name="product_name" class="input-field" placeholder="Product Name" required>
                                <label for="product_name" class="input-label">Product Name</label>
                            </div>
                            <div class="input-control mb-5">
                                <textarea style="resize:none" name="description" class="input-field" placeholder="Description"></textarea>
                                <label for="description" class="input-label">Description</label>
                            </div>
                            <div class="input-control">
                                <select name="category" class="input-field form" placeholder="Category" required>
                                    <?php if ($category_data) : ?>
                                        <option value="-1">Select Product Category</option>
                                        <?php foreach ($category_data as $category) : ?>
                                            <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <option value="-1" disabled>No Product Category</option>
                                    <?php endif; ?>
                                </select>
                                <label for="category" class="input-label">Category</label>
                            </div>
                            <div class="input-control">
                                <input type="number" name="price" class="input-field" placeholder="Price" required>
                                <label for="price" class="input-label">Price</label>
                            </div>
                            <div class="input-control">
                                <input type="text" name="sku" class="input-field" placeholder="SKU" required>
                                <label for="sku" class="input-label">SKU</label>
                            </div>
                            <div class="d-flex">
                                <div class="input-control w-50 me-2">
                                    <input type="text" name="ceiling_stock" class="input-field" placeholder="Ceiling Stock" required>
                                    <label for="ceiling_stock" class="input-label" pattern="/^[0-9]+$/">Ceiling Stock</label>
                                </div>
                                <div class="input-control w-50">
                                    <input type="text" name="flooring_stock" class="input-field" placeholder="Flooring Stock" required>
                                    <label for="flooring_stock" class="input-label" pattern="/^[0-9]+$/">Flooring Stock</label>
                                </div>
                            </div>
                            <div class="preview-product-image"></div>
                            <input class="form-control" id="product_image" type="file" name="product_image" accept=".jpeg,.jpg,.png,.bmp,.tiff,.tif" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="product_id" value="">
                        <button type="submit" class="btn btn-primary">Update Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        </form>


        <!-- modalEnableProduct -->
        <div class="modal fade" id="modalEnableProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEnableProductLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEnableProductLabel">Enable Product</h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to enable <span id="textEnableProduct" class="fw-bold"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hiddenFieldEnableProduct" name="product_id">
                        <input type="hidden" name="state" value="ACTIVE">
                        <button id="btnEnableProduct" type="button" class="btn btn-primary">Enable</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modalDisableProduct -->
        <div class="modal fade" id="modalDisableProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDisableProductLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDisableProductLabel">Disable Product</h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to disable <span id="textDisableProduct" class="fw-bold"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hiddenFieldDisableProduct" name="product_id">
                        <input type="hidden" name="state" value="INACTIVE">
                        <button id="btnDisableProduct" type="button" class="btn btn-primary">Disable</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modalDeleteProduct -->
        <form action="<?= base_url('/admin/product/remove') ;?>" method="POST">
        <div class="modal fade" id="modalDeleteProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteProductLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteProductLabel">Delete Product</h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span id="textDeleteProduct" class="fw-bold"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="hiddenFieldDeleteProduct" name="product_id">
                        <button id="btnDisableProduct" type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        

        <script src="<?= base_url("assets/admin/js/show-product.js"); ?>"></script>

    </div>
</div>

<?= view('admin/layout/footer') ?>