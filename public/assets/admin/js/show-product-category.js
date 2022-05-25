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
        category.createCategory();
    });

    let buttonEditCategory = document.getElementById('btnEditCategory');
    buttonAddCategory.addEventListener('click', (evt) => {
        category.editCategory();
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

        let data = new FormData();
        data.append('category_name', fieldProductName.value);
        let req = fetch(base_url + '/admin/category/add', {
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
                    let categoryId = modal.querySelector('[name="category_id"]');
                    categoryId.value = data.category_id;
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
                    let modal = document.getElementById('modalDeleteCategory');
                    let categoryName = document.getElementById('textDeleteCategory');
                    categoryName.innerHTML = data.category_name;
                    let categoryId = modal.querySelector('[name="category_id"]');
                    categoryId.value = data.category_id;
                }
            })
            .catch(err => console.error());
    }
}