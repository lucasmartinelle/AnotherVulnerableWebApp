<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, shrink-to-fit=no">

        <!-- vendor CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/0e68b45e64.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="<?= $asset ?>css/main.css">
        <link rel="stylesheet" href="<?= $asset ?>css/custom.css">
        <link rel="icon" href="<?= $asset ?>img/favicon.png">
        <link rel="stylesheet" href="<?= $asset ?>editormd/css/editormd.css" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <title><?= TITLE . ' | ' . $titre ?></title>
    </head>
    <body id="<?= $idPage ?>">
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background-image: linear-gradient(rgb(11, 83, 148), rgb(180, 167, 214)); background-color: unset;">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $routes->url("dashboard"); ?>">
                    <div class="sidebar-brand-icon">
                        <img src="<?= $asset ?>img/favicon.png" width="40px" height="40px">
                    </div>
                    <div class="sidebar-brand-text mx-1 m-t-sm"><?= TITLE ?></div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= $routes->url("account"); ?>">
                        <i class="fas fa-fw fa-tachometer-alt text-info"></i>
                        <span>Account</span>
                    </a>
                </li>

                <!-- Nav Item - API -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= $routes->urlReplace("api", array($_SESSION['id'])); ?>">
                        <i class="fas fa-bug text-warning"></i>
                        <span>API</span>
                    </a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider d-md-block">
            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-lg-inline text-gray-600 small"><?php if(isset($_SESSION['username'])){ echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); } else if(isset($_COOKIE['username'])){ echo htmlspecialchars($_COOKIE['username'], ENT_QUOTES); } ?></span>
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="<?= $routes->url("logout"); ?>">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <!-- page content -->
                        <?php if(isset($content)){ echo $content; } ?>
                    </div>
                </div>
                <!-- End of Main Content -->
                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; lucasmartinelle 2020</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
        </div>
        <!-- End of Content Wrapper -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" 
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="<?= $asset ?>js/main.js"></script>
        <?php if(isset($script)){ echo $script; } ?>
    </body>
</html>