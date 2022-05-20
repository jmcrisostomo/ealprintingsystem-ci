<?= view('customer/layout/header') ?>

<?= view('customer/layout/navbar') ?>

<!-- Open Content -->
<section class="bg-light">

    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-5 mt-5">
                <div class="card mb-3">
                    <img class="card-img img-fluid" src="<?= base_url('assets/img/products/'.$product_single->product_image) ?>" alt="Card image cap"
                        id="product-detail">
                </div>
                <div class="row d-none">
                    <!--Start Controls-->
                    <div class="col-1 align-self-center">
                        <a href="#multi-item-example" role="button" data-bs-slide="prev">
                            <i class="text-dark fas fa-chevron-left"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                    </div>
                    <!--End Controls-->
                    <!--Start Carousel Wrapper-->
                    <div id="multi-item-example" class="col-10 carousel slide carousel-multi-item "
                        data-bs-ride="carousel">
                        <!--Start Slides-->
                        <div class="carousel-inner product-links-wap" role="listbox">

                            <!--First slide-->
                            <div class="carousel-item active">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= base_url('assets/img/product_single_01.jpg') ?>"
                                                alt="Product Image 1">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= base_url('assets/img/product_single_02.jpg') ?>"
                                                alt="Product Image 2">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= base_url('assets/img/product_single_03.jpg') ?>"
                                                alt="Product Image 3">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/.First slide-->

                            <!--Second slide-->
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= base_url('assets/img/product_single_04.jpg') ?>"
                                                alt="Product Image 4">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= base_url('assets/img/product_single_05.jpg') ?>"
                                                alt="Product Image 5">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="<?= base_url('assets/img/product_single_06.jpg') ?>"
                                                alt="Product Image 6">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/.Second slide-->

                            <!--Third slide-->
                            <div class="carousel-item">
                                <div class="row">
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="assets/img/product_single_07.jpg"
                                                alt="Product Image 7">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="assets/img/product_single_08.jpg"
                                                alt="Product Image 8">
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <a href="#">
                                            <img class="card-img img-fluid" src="assets/img/product_single_09.jpg"
                                                alt="Product Image 9">
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/.Third slide-->
                        </div>
                        <!--End Slides-->
                    </div>
                    <!--End Carousel Wrapper-->
                    <!--Start Controls-->
                    <div class="col-1 align-self-center">
                        <a href="#multi-item-example" role="button" data-bs-slide="next">
                            <i class="text-dark fas fa-chevron-right"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <!--End Controls-->
                </div>
            </div>
            <!-- col end -->

            <div class="col-lg-7 mt-5">
                <div class="card">

                    <div class="card-body">

                        <?php if ($breadcrumb_data) : ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url('products') ?>">Shop</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url('products?category='.$breadcrumb_category_id) ?>"><?= $breadcrumb_data ?></a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?= $product_single->product_name ?></li>
                                </ol>
                            </nav>
                        <?php endif ?>

                        <h1 class="h2"><?= $product_single->product_name ?></h1>
                        <p class="h3 py-2">&#x20B1; <span class="price"><?= number_format($product_single->price, 2, '.', ',') ?></span></p>
                        <!-- <p class="py-2">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
                        </p> -->
                        <!-- <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Brand:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>Easy Wear</strong></p>
                            </li>
                        </ul> -->

                        <h6>Description:</h6>
                        <p><?= $product_single->description ?></p>

                        <h3>Customization</h3>

                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Avaliable Color :</h6>
                            </li>
                            <!-- <li class="list-inline-item"> -->
                                <!-- add product attribute here -->
                                
                                <!-- <p class="text-muted"><strong>White</strong></p>
                                <p class="text-muted"><strong>White / Black</strong></p>
                            </li> -->
                            <li class="list-inline-item"><span class="btn btn-success btn-color">White</span>
                            <li class="list-inline-item"><span class="btn btn-success btn-color">Black</span>
                        </ul>

                        <!-- <h6>Specification:</h6>
                        <ul class="list-unstyled pb-3">
                            <li>Lorem ipsum dolor sit</li>
                            <li>Amet, consectetur</li>
                            <li>Adipiscing elit,set</li>
                            <li>Duis aute irure</li>
                            <li>Ut enim ad minim</li>
                            <li>Dolore magna aliqua</li>
                            <li>Excepteur sint</li>
                        </ul> -->

                        <form action="<?= base_url('/product/add-to-cart') ;?>" method="POST">
                            <input type="hidden" name="product-id" value="<?= $product_single->product_id ;?>">
                            <input type="hidden" name="product-name" value="<?= $product_single->product_name ;?>">
                            <input type="hidden" name="product-color" value="Black">
                            <input type="hidden" name="product-size" id="product-size" value="S">
                            <input type="hidden" name="product-quanity" id="product-quanity" value="1">
                            <input type="hidden" name="default-price" value="<?= number_format($product_single->price, 2, '.', ',') ?>">
                            <input type="hidden" name="total-price" value="<?= number_format($product_single->price, 2, '.', ',') ?>">

                            <div class="row">
                                <div class="col-auto">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item">Size :
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success btn-size">S</span>
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success btn-size">M</span>
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success btn-size">L</span>
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success btn-size">XL</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-auto">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item text-right">
                                            Quantity
                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                id="btn-minus">-</span></li>
                                        <li class="list-inline-item"><span class="badge bg-secondary"
                                                id="var-value">1</span></li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                id="btn-plus">+</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <!-- <div class="col d-grid"> -->
                                    <!-- <button type="submit" class="btn btn-success btn-lg" name="submit" value="buy">Buy</button> -->
                                <!-- </div> -->
                                <div class="col d-grid">
                                    <button type="submit" class="btn btn-success btn-lg" name="submit"
                                        value="addtocard">Add To Cart</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
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