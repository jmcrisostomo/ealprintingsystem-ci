let modalView;
let modalEnable;
let modalDisable;
let modalDelete;

window.addEventListener('load', () => {

    modalView = new bootstrap.Modal(document.getElementById('modalEditProduct'), {});
    modalEnable = new bootstrap.Modal(document.getElementById('modalEnableProduct'), {});
    modalDisable = new bootstrap.Modal(document.getElementById('modalDisableProduct'), {});
    modalDelete = new bootstrap.Modal(document.getElementById('modalDeleteProduct'), {});

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
            createdRow: function (row, data, dataIndex) {
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

                $(".table").on("click", "#btnView_" + productId, function () {
                    modalView.show();

                    product.fetchProduct(productId);
                })

                $(".table").on("click", "#btnEnable_" + productId, function () {
                    modalEnable.show();
                    product.enableProduct(productId)
                })

                $(".table").on("click", "#btnDisable_" + productId, function () {
                    modalDisable.show();
                    product.disableProduct(productId)
                })

                $(".table").on("click", "#btnDelete_" + productId, function () {
                    modalDelete.show();
                    product.deleteProduct(productId)
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

    let buttonAddProduct = document.getElementById('btnAddProduct');
    buttonAddProduct.addEventListener('click', (evt) => {
        product.createProduct();
    });


    let btnEnableProduct = document.getElementById('modalEnableProduct').querySelector('#btnEnableProduct');
    btnEnableProduct.addEventListener('click', (evt) => {
        product.requestEnableProduct();
    });

    let btnDisableProduct = document.getElementById('modalDisableProduct').querySelector('#btnDisableProduct');
    btnDisableProduct.addEventListener('click', (evt) => {
        product.requestDisableProduct();
    });
});

const product = {
    fetchProduct: (productId) => {
        let req = fetch(base_url + '/admin/product/' + productId, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data) {
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
                    let productId = modal.querySelector('[name="product_id"]');
                    productId.value = data.product_id;

                }
            })
            .catch(err => console.error());
    },
    createProduct: () => {
        let modal = document.getElementById('modalAddProduct');
        let fieldProductName = modal.querySelector('[name="product_name"]');
        let fieldDescription = modal.querySelector('[name="description"]');
        let fieldCategory = modal.querySelector('[name="category"]');
        let fieldPrice = modal.querySelector('[name="price"]');
        let fieldSKU = modal.querySelector('[name="sku"]');
        let fieldCeilingStock = modal.querySelector('[name="ceiling_stock"]');
        let fieldFlooringStock = modal.querySelector('[name="flooring_stock"]');
        let fileProductImage = modal.querySelector('[name="product_image"]');


        let data = new FormData();
        data.append('product_name', fieldProductName.value);
        data.append('description', fieldDescription.value);
        data.append('category', fieldCategory.options[fieldCategory.selectedIndex].value);
        data.append('price', fieldPrice.value);
        data.append('sku', fieldSKU.value);
        data.append('ceiling_stock', fieldCeilingStock.value);
        data.append('flooring_stock', fieldFlooringStock.value);
        data.append('product_image', fileProductImage.files[0]);

        let req = fetch(base_url + '/admin/product/add', {
                method: 'POST',
                body: data
            })
            .then(res => res.json())
            .then(data => {
                if (data) {
                    console.log(data)

                    location.reload();
                }
            })
            .catch(err => console.error());
    },
    enableProduct: (productId) => {
        let req = fetch(base_url + '/admin/product/' + productId, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data) {
                    let productName = document.getElementById('textEnableProduct');
                    let hiddenFieldEnableProduct = document.getElementById('hiddenFieldEnableProduct');
                    productName.innerHTML = data.product_name;
                    hiddenFieldEnableProduct.value = productId;
                }
            })
            .catch(err => console.error());

        
    },

    disableProduct: (productId) => {
        let req = fetch(base_url + '/admin/product/' + productId, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data) {
                    let productName = document.getElementById('textDisableProduct');
                    let hiddenFieldDisableProduct = document.getElementById('hiddenFieldDisableProduct');
                    productName.innerHTML = data.product_name;
                    hiddenFieldDisableProduct.value = productId;
                }
            })
            .catch(err => console.error());

            
    },

    deleteProduct: (productId) => {
        let req = fetch(base_url + '/admin/product/' + productId, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data) {
                    let productName = document.getElementById('textDeleteProduct');
                    let hiddenFieldDeleteProduct = document.getElementById('hiddenFieldDeleteProduct');
                    productName.innerHTML = data.product_name;
                    hiddenFieldDeleteProduct.value = productId;
                }
            })
            .catch(err => console.error());

            
    },

    requestEnableProduct: () => {
        let productNumber = document.getElementById('modalEnableProduct').querySelector('[name="product_id"]');
        let productState = document.getElementById('modalEnableProduct').querySelector('[name="state"]');

        let formData = new FormData();
        formData.append('product_id', productNumber.value);
        formData.append('state', productState.value);

        let req = fetch(base_url + '/admin/product/enable', {
            method: 'POST', body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            location.reload();
        })
        .catch(err => console.error());
    },

    requestDisableProduct: () => {
        let productNumber = document.getElementById('modalDisableProduct').querySelector('[name="product_id"]');
        let productState = document.getElementById('modalDisableProduct').querySelector('[name="state"]');

        let formData = new FormData();
        formData.append('product_id', productNumber.value);
        formData.append('state', productState.value);

        let req = fetch(base_url + '/admin/product/disable', {
            method: 'POST', body: formData
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            location.reload();
        })
        .catch(err => console.error());
    },

}