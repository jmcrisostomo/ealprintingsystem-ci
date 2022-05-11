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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Update Category</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

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
                        <button type="button" class="btn btn-primary">Enable</button>
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
                        <button type="button" class="btn btn-primary">Disable</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- modalDeleteCategory -->
        <div class="modal fade" id="modalDeleteCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteCategoryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteCategoryLabel">Delete Category</h5>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to remove <span id="textDisableCategory" class="fw-bold"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> -->
        <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> -->
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.6.0/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-html5-2.2.2/r-2.2.9/datatables.min.js"></script>


        <script>
            let modalView;
            let modalEnable;
            let modalDisable;
            let modalDelete;
            
            window.addEventListener('load', () => {

                modalView = new bootstrap.Modal(document.getElementById('modalEditCategory'), {});
                modalEnable = new bootstrap.Modal(document.getElementById('modalEnableCategory'), {});
                modalDisable = new bootstrap.Modal(document.getElementById('modalDisableCategory'), {});
                modalDelete = new bootstrap.Modal(document.getElementById('modalDeleteCategory'), {});

                (($) => {
                    $('#dataTable').DataTable({
                        scrollY: '50vh',
                        responsive: true,
                        scrollX: true,
                        ajax: {
                            url: base_url + "/admin/category/all",
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
                            let categoryId = doc.firstChild.innerHTML;

                            $(".table").on("click", "#btnView_" + categoryId, function() {
                                modalView.show();
                                category.fetchCategory(categoryId);
                            })

                            $(".table").on("click", "#btnDisable_" + categoryId, function() {
                                modalDisable.show();
                            })

                            $(".table").on("click", "#btnEnable_" + categoryId, function() {
                                modalEnable.show();
                            })

                            $(".table").on("click", "#btnDelete_" + categoryId, function() {
                                modalDelete.show();
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

                let buttonAddCategory = document.getElementById('btnAddCategory');
                buttonAddCategory.addEventListener('click', (evt) => {
                    product.createCategory();
                });
            });

            const category = {
                fetchCategory: (categoryId) => {
                    let req = fetch( base_url + '/admin/category/' + categoryId, {
                        method: 'GET'
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(data);
                        if (data)
                        {
                            let modal = document.getElementById('modalEditCategory');
                            let categoryName = modal.querySelector('[name="category_name"]');
                            categoryName.value = data.category_name;
                        }
                    })
                    .catch(err => console.error());
                },
                createCategory: () => {
                    let modal = document.getElementById('modalAddCategory');
                    let fieldProductName = modal.querySelector('[name="category_name"]');
                    let fieldDescription = modal.querySelector('[name="description"]');
                    let fieldCategory = modal.querySelector('[name="category"]');
                    let fieldPrice = modal.querySelector('[name="price"]');
                    let fieldSKU = modal.querySelector('[name="sku"]');
                    let fieldCeilingStock = modal.querySelector('[name="ceiling_stock"]');
                    let fieldFlooringStock = modal.querySelector('[name="flooring_stock"]');


                    let data = new FormData();
                    data.append('category_name', fieldProductName.value);
                    data.append('description', fieldDescription.value);
                    data.append('category', fieldCategory.options[fieldCategory.selectedIndex].value);
                    data.append('price', fieldPrice.value);
                    data.append('sku', fieldSKU.value);
                    data.append('ceiling_stock', fieldCeilingStock.value);
                    data.append('flooring_stock', fieldFlooringStock.value);

                    let req = fetch( base_url + '/admin/product/add', {
                        method: 'POST', body: data
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data)
                        {
                            console.log(data)
                            
                            location.reload();
                        }
                    })
                    .catch(err => console.error());
                },
                stateCategory: (state) => {

                    let modalStateCategoryLabel = document.getElementById('modalStateCategoryLabel')
                    let contextModal = document.getElementById('contextModal')
                    let btnStateSubmit = document.querySelector('.btn-state')

                    switch (state) {
                        case 'disable':

                            modalStateCategoryLabel.innerHTML = 'Disable Category';
                            contextModal.innerHTML = 'Are you sure you want to disable this category?';
                            

                            break;
                    
                        default:
                            break;
                    }
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