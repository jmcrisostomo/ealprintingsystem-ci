<?= view('admin/layout/header'); ?>

<main class="d-flex w-100">
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Account Login</h1>
                        <p class="lead">
                            Sign in to your account to continue
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="m-sm-4">
                                <div class="text-center">
                                    <img src="<?= base_url('assets/img/achie/EAL_LOGO.png') ?>" alt="User"
                                        class="img-fluid rounded-circle" width="132" height="132" />
                                </div>
                                <form method="POST" action="<?= base_url('auth/login') ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input class="form-control form-control-lg" type="text" name="username"
                                            placeholder="Enter your username" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password"
                                            placeholder="Enter your password" />
                                    </div>
                                    <!-- <div>
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" value="remember-me"
                                                name="remember-me" checked>
                                            <span class="form-check-label">
                                                Remember me next time
                                            </span>
                                        </label>
                                    </div> -->
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