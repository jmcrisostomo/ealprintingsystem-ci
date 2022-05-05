<?= view('admin/layout/header'); ?>

<main class="d-flex w-100">

    <style type="text/css">
    .loginbg {
        position: fixed;
        background-image: url(<?= base_url('assets/img/bg/login_background.jpg') ?>);
        height: 100%;
        width: 100%;
        background-attachment: fixed;
        background-color: rgb(97 97 97 / 75%);
        background-blend-mode: multiply;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        z-index: -1;
        /*#212529*/
    }

    .card {
        background-color: rgb(255 255 255 / 5%);
        box-shadow: #9e9e9e 0 0 25px 15px;
        border-radius: 15px;
        margin-top: 3em;
    }
    </style>

    <!-- image background -->
    <div class="loginbg"></div>

    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2 text-light">Account Login</h1>
                        <p class="lead text-light">
                            Sign in to your account to continue
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <div class="text-center">
                                    <img src="<?= base_url('assets/img/achie/illustrator/EAL_LOGO_TRANSPARENT.png') ?>" alt="User"
                                        class="img-fluid rounded-circle" width="180" height="180" style="background-color: rgb(33 37 41 / 50%); box-shadow: #9e9e9e 0 0 15px 15px;" />
                                </div>
                                <form class="form" method="POST" action="<?= base_url('auth/login') ?>">
                                    <!-- <div class="mb-3">
                                        <label class="form-label text-light">Username</label>
                                        <input class="form-control form-control-lg" type="text" name="username"
                                            placeholder="Enter your username" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-light">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password"
                                            placeholder="Enter your password" />
                                    </div> -->

                                    <div class="mt-5 input-control white-input-label">
                                        <input type="text" name="username" class="input-field" placeholder="Username" required>
                                        <label for="username" class="input-label ">Username</label>
                                    </div>

                                    <div class="mt-3 input-control white-input-label">
                                        <input type="password" name="password" class="input-field" placeholder="Password" required>
                                        <label for="password" class="input-label ">Password</label>
                                    </div>

                                    <div class="text-center mt-3">
                                        <!-- <a href="index.html" class="btn btn-lg btn-primary">Sign in</a> -->
                                        <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/4.0.9/inputmask/inputmask.min.js">
</script>

<script src="<?= base_url('assets/js/login.js'); ?>"></script>

<?= view('admin/layout/footer') ?>