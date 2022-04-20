<?= view('admin/layout/header'); ?>

    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <h1 class="h2">Welcome back, User</h1>
                            <p class="lead">
                                Sign in to your account to continue
                            </p>
                            <h1 class="mb-3">Account Login</h1>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center">
                                        <img src="<?= base_url('assets/admin/img/avatars/avatar.jpg') ?>" alt="User"
                                            class="img-fluid rounded-circle d-none" width="132" height="132" />
                                    </div>
                                    <form>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- <input id="username" type="text" class="form-control mb-3" placeholder="Username" name="username" onkeydown="removeNotAllowedCharacters(event)" required> -->
                                                <input id="username" type="text" class="form-control mb-3" placeholder="Username" name="username" required>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                <input id="password" type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="btnEye" name="password" required>
                                                <button id="btnEye" class="btn" type="button"><i class="fa fa-eye-slash text-light"></i> <span class="text-light"></span></button>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <!-- <button type="submit" class="btn btn-lg d-block w-100">Login</button> -->
                                                <button id="btnLogin" type="button" class="btn btn-lg d-block w-100" val="Login">Login</button>
                                            </div>

                                            <div class="col-md-12">
                                                <hr style="height: 1px; background-color: #000; border: none;">
                                            </div>

                                            <div class="col-md-12">
                                                <a href="<?php echo base_url('home/registration'); ?>" class="btn btn-lg d-block w-100">Register</a>
                                            </div>
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

    <script src="<?= base_url('assets/js/login.js'); ?>"></script>

<?= view('admin/layout/footer') ?>