<?php
    // Load route controller
    require_once("app/Routes.php");
    use app\Routes;
    $routes = new Routes;

    $asset = "../assets/";
    $idPage = "register";
    ob_start();
?>

<div class="container-fluid">
    <?php if(isset($alert) && !empty($alert) && isset($typeAlert) && !empty($typeAlert)){
        if($typeAlert == "success"){
            echo '
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="cardAlert w-100 m-t-lg m-b-xl sh-dark">
                            <div class="container-fluid d-flex p-0 rightAlertParent">
                                <div class="bg-success rightAlert"></div>
                                <div class="card-content bg-white px-4 py-2 text-center">
                                    <h1 class="h5 m-sm" style="margin-bottom: 25px !important;">'.$alert.'</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        } else if($typeAlert == "error"){
            echo '
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="cardAlert w-100 m-t-lg m-b-xl sh-dark">
                            <div class="container-fluid d-flex p-0 rightAlertParent">
                                <div class="bg-danger rightAlert"></div>
                                <div class="card-content bg-white px-4 py-2 text-center">
                                    <h1 class="h5 m-sm" style="margin-bottom: 25px !important;">'.$alert.'</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    } else if(isset($_SESSION['alert']) && !empty($_SESSION['alert']) && isset($_SESSION['typeAlert']) && !empty($_SESSION['typeAlert'])){
        $alert = $_SESSION['alert'];
        $typeAlert = $_SESSION['typeAlert'];
        $_SESSION['alert'] = '';
        $_SESSION['typeAlert'] = '';
        if($typeAlert == "success"){
            echo '
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="cardAlert w-100 m-t-lg m-b-xl sh-dark">
                            <div class="container-fluid d-flex p-0 rightAlertParent">
                                <div class="bg-success rightAlert"></div>
                                <div class="card-content bg-white px-4 py-2 text-center">
                                    <h1 class="h5 m-sm" style="margin-bottom: 25px !important;">'.$alert.'</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        } else if($typeAlert == "error"){
            echo '
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="cardAlert w-100 m-t-lg m-b-xl sh-dark">
                            <div class="container-fluid d-flex p-0 rightAlertParent">
                                <div class="bg-danger rightAlert"></div>
                                <div class="card-content bg-white px-4 py-2 text-center">
                                    <h1 class="h5 m-sm" style="margin-bottom: 25px !important;">'.$alert.'</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
    } ?>
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-9 col-md-10 col-sm-11 col-12">
            <div class="card w-100 m-t-lg m-b-xl sh-dark">
                <div class="container-fluid d-flex p-0 rightDivParent">
                    <div class="bg-success h-100 rightDiv">
                        <div class="d-table h-100">
                            <div class="d-table-cell text-center h-100">
                                <img src="https://zupimages.net/up/20/22/nfeb.png" width="100%" height="auto">
                                <h1 class="h3 text-light"><span class="badge badge-primary">Join us</span></h1>
                            </div>
                        </div>
                    </div>
                    <div class="card-content px-4 py-2 text-center">
                        <h1 class="m-sm">Sign up</h1>
                        <form method="post" class="needs-validation" novalidate>
                            <div class="form-row justify-content-center">
                                <div class="col-xl-5 mb-3 m-sm">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                    <div class="invalid-feedback text-left">
                                        That field is required
                                    </div>
                                </div>
                                <div class="col-xl-5 mb-3 m-sm">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback text-left">
                                        That field is required
                                    </div>
                                </div>
                            </div>
                            <div class="form-row justify-content-center">
                                <div class="col-xl-5 mb-3 m-sm">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <div class="invalid-feedback text-left">
                                        That field is required
                                    </div>
                                </div>
                                <div class="col-xl-5 mb-3 m-sm">
                                    <label for="cpassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                                    <div class="invalid-feedback text-left">
                                        That field is required
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <input type="hidden" id="token" name="token" value="<?= $token ?>">
                            <div class="container-fluid text-center m-t-sm">
                                <button class="btn btn-success" type="submit">Sign up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid text-center" style="margin-bottom: 120px !important;">
    <h1 class="h4 text-success link"><a href="<?= $routes->url("login"); ?>" class="badge badge-success"><i class="fas fa-arrow-left"></i> Already have an account ? login here</a></h1>
</div>

<footer class="footer fixed-bottom">
    <div class="container-fluid px-3 py-3 bg-success text-center">
        <h1 class="h5"><span class="badge badge-pill badge-primary">Copyright All Right Reserved © Lucas Martinelle</span></h1>
    </div>
</footer>

<?php
    $content = ob_get_clean();
?>