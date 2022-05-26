<?= view('customer/layout/header') ?>

<?= view('customer/layout/navbar') ?>

<!-- Open Content -->
<section class="bg-light">

    <div class="container pb-5">
        <div class="row">
            <div class="col-md-12">

                <?php if($cart_data) : ?>
                    <h1 class="mt-5">Cart</h1>

                    <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Size</th>
                            <th scope="col">Color</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_data as $product) : ?>
                            <tr>
                                <td>
                                    <img class="img-fluid" style="width: 150px;" src="<?= base_url('assets/img/products/'.$product->product_image) ?>">
                                </td>
                                <td><?= $product->product_name ;?></td>
                                <td><?= $product->size ;?></td>
                                <td><?= $product->color ;?></td>
                                <td>&#x20B1; <span class="price"><?= number_format($product->default_price, 2, '.', ',') ?></td>
                                <td><?= $product->quantity ;?></td>
                                <td>&#x20B1; <span class="price"><?= number_format($product->price, 2, '.', ',') ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                    </table>


                    

                <?php else : ?>
                    <h1 class="mt-5">Cart Empty</h1>
                <?php endif ?>
                
            </div>
        </div>
    </div>
</section>
<!-- Close Content -->

<script>
    let btnColor = document.querySelectorAll('.btn-color');
    btnColor.forEach((elem) => {
        
        elem.addEventListener('click', () => {
            btnColor.forEach((elem2) => {
                elem2.classList.add('btn-success');
            });

            if (elem.classList.contains('btn-success'))
            {
                elem.classList.remove('btn-success');
                elem.classList.add('btn-secondary');
            }

            console.log(elem.innerHTML);
            document.querySelector('[name="product-color"]').value = elem.innerHTML;
        });
    });

    let btnQuantityPlus = document.querySelector('#btn-plus');
    btnQuantityPlus.addEventListener('click', () => {
        let defaultPrice = document.querySelector('[name="default-price"]').value;
        let quantity = document.querySelector('#var-value').innerHTML;

        let total = defaultPrice * quantity;

        console.log(quantity);

        document.querySelector('.price').innerHTML = total.toFixed(2);
        document.querySelector('[name="total-price"]').value = total.toFixed(2);
    });

    let btnQuantityMinus = document.querySelector('#btn-minus');
    btnQuantityMinus.addEventListener('click', () => {
        let defaultPrice = document.querySelector('[name="default-price"]').value;
        let quantity = document.querySelector('#var-value').innerHTML;
        // let quantity = document.querySelector('[name="product-quanity"]').value;

        let total = defaultPrice * quantity;
        document.querySelector('.price').innerHTML = total.toFixed(2);
        document.querySelector('[name="total-price"]').value = total.toFixed(2);
    });

</script>


<?= view('customer/layout/footer') ?>