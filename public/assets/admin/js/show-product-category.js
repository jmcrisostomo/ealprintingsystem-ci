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
                let categoryId = doc.firstChild.innerHTML;

                $(".table").on("click", "#btnView_" + categoryId, function () {
                    modalView.show();
                    category.editCategory(categoryId, "modalEditCategory");
                })

                $(".table").on("click", "#btnDisable_" + categoryId, function () {
                    modalDisable.show();
                    category.editCategory(categoryId);
                })

                $(".table").on("click", "#btnEnable_" + categoryId, function () {
                    modalEnable.show();
                    category.enableCategory(categoryId);
                })

                $(".table").on("click", "#btnDelete_" + categoryId, function () {
                    modalDelete.show();
                    category.deleteCategory(categoryId);
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

    let buttonEditCategory = document.getElementById('btnEditCategory');
    buttonAddCategory.addEventListener('click', (evt) => {
        product.createCategory();
    });
});

const category = {
    fetchCategory: (categoryId, modal) => {
        let req = fetch(base_url + '/admin/category/' + categoryId, {
            method: 'GET'
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data) {
                let modal = document.getElementById(modal);
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
    editCategory: (categoryId) => {
        let req = fetch(base_url + '/admin/category/' + categoryId, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data) {
                    let modal = document.getElementById('modalEditCategory');
                    let categoryName = modal.querySelector('[name="category_name"]');
                    categoryName.value = data.category_name;
                }
            })
            .catch(err => console.error());
    },
    enableCategory: (categoryId) => {
        let req = fetch(base_url + '/admin/category/' + categoryId, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data) {
                    let categoryName = document.getElementById('textEnableCategory');
                    categoryName.innerHTML = data.category_name;
                }
            })
            .catch(err => console.error());
    },
    disableCategory: (categoryId) => {
        let req = fetch(base_url + '/admin/category/' + categoryId, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data) {
                    let categoryName = document.getElementById('textDisableCategory');
                    categoryName.innerHTML = data.category_name;
                }
            })
            .catch(err => console.error());
    },
    deleteCategory: (categoryId) => {
        let req = fetch(base_url + '/admin/category/' + categoryId, {
                method: 'GET'
            })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data) {
                    let categoryName = document.getElementById('textDeleteCategory');
                    categoryName.innerHTML = data.category_name;
                }
            })
            .catch(err => console.error());
    }
}