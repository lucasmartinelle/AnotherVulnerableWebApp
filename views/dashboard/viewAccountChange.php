<?php
    // Load route controller
    require_once("app/Routes.php");
    use app\Routes;
    $routes = new Routes;

    $asset = "../assets/";
    $idPage = "accountChange";
    ob_start();
?>
    <h1 class="h3 mb-4 text-gray-800">Modify your account</h1>
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
        <form enctype="multipart/form-data" method="post" class="w-100 p-b-md">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card m-t-sm" style="min-height: 300px;">
                        <div class="card-body">
                            <h1 class="h4 mb-4 text-gray-800">Change your avatar</h1>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="upload-tab" data-toggle="tab" href="#nav-upload-avatar" role="tab" aria-controls="nav-upload-avatar" aria-selected="true">Upload file</a>
                                    <a class="nav-item nav-link" id="link-tab-avatar" data-toggle="tab" href="#nav-link-avatar" role="tab" aria-controls="nav-link-avatar" aria-selected="false">Use a link</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-upload-avatar" role="tabpanel" aria-labelledby="upload-tab-avatar">
                                    <div class="card indigo text-center z-depth-2 light-version py-4 px-5">
                                        <!-- Custom Bootstrap File Input -->
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="uploadFileAvatar" name="avatarupload">
                                            <label class="custom-file-label" for="uploadFileAvatar">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-link-avatar" role="tabpanel" aria-labelledby="link-tab-avatar">
                                    <!-- Custom Bootstrap File Input -->
                                    <div class="form-row justify-content-center p-sm">
                                        <div class="col-md-6">
                                            <img src="<?= $asset . 'img/default_avatar.png' ?>" width="100%" style="max-width: 200px;" height="auto" class="m-auto" id="renderavatarlink">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="avatarlink">Enter a link</label>
                                            <input type="text" class="form-control" name="avatarlink" placeholder="link" id="avatarlink">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card m-t-sm" style="min-height: 300px;">
                        <div class="card-body">
                            <h1 class="h4 mb-4 text-gray-800">Prove your identity</h1>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="upload-tab" data-toggle="tab" href="#nav-upload" role="tab" aria-controls="nav-upload" aria-selected="true">Upload file</a>
                                    <a class="nav-item nav-link" id="link-tab" data-toggle="tab" href="#nav-link" role="tab" aria-controls="nav-link" aria-selected="false">Use a link</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-upload" role="tabpanel" aria-labelledby="upload-tab">
                                    <div class="card indigo text-center z-depth-2 light-version py-4 px-5">
                                        <!-- Custom Bootstrap File Input -->
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="uploadFile" name="proveupload">
                                            <label class="custom-file-label" for="uploadFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-link" role="tabpanel" aria-labelledby="link-tab">
                                    <!-- Custom Bootstrap File Input -->
                                    <div class="form-row justify-content-center p-sm">
                                        <div class="col-md-6">
                                            <img src="<?= $asset . 'img/default_avatar.png' ?>" width="100%" style="max-width: 200px;" height="auto" class="m-auto" id="renderprovelink">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="provelink">Enter a link</label>
                                            <input type="text" class="form-control" name="provelink" placeholder="link" id="provelink">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card m-t-sm">
                        <div class="card-body">
                            <h1 class="h4 mb-4 text-gray-800">Change your password</h1>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="password" id="password">
                                </div>
                                <div class="col-md-6">
                                    <label for="cpassword">Confirm Password</label>
                                    <input type="password" class="form-control" name="cpassword" placeholder="confirm password" id="cpassword">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card m-t-sm">
                        <div class="card-body">
                            <h1 class="h4 mb-4 text-gray-800">Give us a little description about you.</h1>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 m-t-sm text-center">
                    <button class="btn btn-primary" type="submit">Submit form</button>
                </div>
            </div>
        </form>
    </div>
<?php
    $content = ob_get_clean();
    ob_start();
?>

<script type="application/javascript">
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

    $('#avatarlink').blur(function() {
        var value = $('#avatarlink').val();
        $('#renderavatarlink').attr("src",value);
    });

    $('#provelink').blur(function() {
        var value = $('#provelink').val();
        $('#renderprovelink').attr("src",value);
    });
</script>

<?php
    $script = ob_get_clean();
?>