<?php
    // Load route controller
    require_once("app/Routes.php");
    use app\Routes;
    $routes = new Routes;

    $asset = "../assets/";
    $idPage = "account";
    ob_start();
?>
    <h1 class="h3 mb-4 text-gray-800">Your account</h1>
    <?php if(isset($alert) && !empty($alert) && isset($typeAlert) && !empty($typeAlert)){
        if($typeAlert == "success"){
            echo '
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="cardAlert w-100 m-t-sm m-b-md sh-dark">
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
                        <div class="cardAlert w-100 m-t-sm m-b-md sh-dark">
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
                        <div class="cardAlert w-100 m-t-sm m-b-md sh-dark">
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
                        <div class="cardAlert w-100 m-t-sm m-b-md sh-dark">
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
    <div class="container-fluid">
        <div class="card m-t-sm p-md">
            <?php foreach($users as $user): ?>
                <?php if($user->id() == $_SESSION['id']): ?>
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="d-flex">
                                <img src="
                                    <?php if($user->avatar() == "NULL" || $user->avatar() == NULL){ 
                                        echo $asset . 'img/default_avatar.png'; 
                                    } else { 
                                        echo $asset . $user->avatar(); 
                                    } ?>" class="avatar" width="100px" height="auto">
                                    <h1 class="h3 text-gray-800 m-l-sm" style="margin-top: 32px;"><?= $user->username(); ?></h1>
                                </div>
                            </div>
                            <div class="col-md-6" style="text-align: end;">
                                <span class="badge badge-pill badge-warning" style="font-size: 16px"><?= $user->email(); ?></span>
                            </div>
                            <div class="col-12 m-t-xs m-b-xs" height="1px" style="background: #000; opacity: 0.3;"></div>
                            <div class="col-md-8 m-t-xs m-b-md">
                                <p class="text-center"><?= $user->description(); ?></p>
                            </div>
                            <div class="col-12">
                                <div class="d-flex" style="width: max-content; margin: auto;">
                                    <h1 class="h3 text-gray-800 m-r-sm">Identity proof :</h1>
                                    <a href="<?= $asset . $user->identity(); ?>"><img src="
                                        <?php if($user->identity() == "NULL" || $user->identity() == NULL){ 
                                            echo $asset . 'img/default_identity.png'; 
                                        } else {
                                            echo $asset . $user->identity(); 
                                        } ?>" width="200px" height="auto"></a>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid m-t-md text-center">
                            <a class="btn btn-primary" href="<?= $routes->url("accountChange"); ?>" role="button">Modify your account</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="container-fluid">
        <form method="post" class="needs-validation w-100 p-b-md" action="<?= $routes->url('contact'); ?>" novalidate>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card m-t-sm" style="min-height: 300px;">
                        <div class="card-body">
                            <h1 class="h4 mb-4 text-gray-800">Contact us</h1>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" id="name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" id="email">
                            </div>
                            <div class="form-group">
                                <label for="message">Message</label>
                                <textarea class="form-control" id="message" name="message" placeholder="message" rows="3"></textarea>
                            </div>
                            <div class="container-fluid text-center">
                                <button class="btn btn-primary" type="submit">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php
    $content = ob_get_clean();
?>