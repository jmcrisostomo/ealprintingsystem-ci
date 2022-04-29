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
                        <table id="dataTable" class="table table-striped" style="width:100%">
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
                        <button type="button" class="btn btn-primary">Add Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modalEditProduct -->
        <div class="modal fade" id="modalEditProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditProductLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditProductLabel">Add Product</h5>
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
                        <button type="button" class="btn btn-primary">Add Product</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/r-2.2.9/datatables.min.js"></script>


        <script>
            let modalView;

            window.addEventListener('load', () => {

                modalView = new bootstrap.Modal(document.getElementById('modalEditProduct'), {});

                (($) => {
                    $('#dataTable').DataTable({
                        scrollY: '50vh',
                        responsive: true,
                        scrollX: true,
                        ajax: {
                            url: base_url + "/admin/product/all",
                        },
                        initComplete: function (settings, json) {
                            addClassDataTableAcceptedTR();
                        },
                        deferRender: true,
                        order: [],
                        createdRow: function(row, data, dataIndex) {
                            // Set the data-status attribute, and add a class
                            // $(row).find('td:eq(1)')
                            //     .addClass('text-start');
                            // $(row).find('td:eq(3)')
                            //     .addClass('text-end');
                            // $(row)
                            //     .attr('id', 'trAccount_' + data[0].replace('TXN-', ''))
                            //     .addClass('text-center');
                            let doc = new DOMParser().parseFromString(data[0], "text/xml");
                            let productId = doc.firstChild.innerHTML;

                            $(".table").on("click", "#btnView_" + productId, function() {
                                modalView.show();
                                product.fetchProduct(productId);
                            })
                        }
                    });
                    let addClassDataTableAcceptedTR = () => {
                        document.querySelectorAll('#dataTable > tbody > tr')
                            .forEach((element, index) => {
                                element.classList.add('text-center');
                            });
                    }
                })(jQuery)
            });

            const product = {
                fetchProduct: (productId) => {
                    let req = fetch( base_url + '/admin/product/' + productId, {
                        method: 'GET'
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (data)
                        {
                            let modal = document.getElementById('modalEditProduct');
                            let productName = modal.querySelector('[name="product_name"]');
                            productName.value = data.product_name;
                            let productDescription = modal.querySelector('[name="description"]');
                            productDescription.innerText = data.description;
                            let productPrice = modal.querySelector('[name="price"]');
                            productPrice.value = data.price;
                            let productSKU = modal.querySelector('[name="sku"]');
                            productSKU.value = data.sku;
                            let productCeilingStock = modal.querySelector('[name="ceiling_stock"]');
                            productCeilingStock.value = data.ceiling_stock;
                            let productFlooringStock = modal.querySelector('[name="flooring_stock"]');
                            productFlooringStock.value = data.flooring_stock;
                            let productCategorySelect = modal.querySelector('[name="category"]');
                            productCategorySelect.options[data.category_id].selected = true;

                        }
                    })
                    .catch(err => console.error());
                }
            }
        </script>

        <!-- <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <p class="mb-0">
                            <a class="text-muted" href="https://adminkit.io/"
                                target="_blank"><strong>AdminKit</strong></a> &copy;
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer> -->
    </div>
</div>

<?= view('admin/layout/footer') ?>