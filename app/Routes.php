<?php
    namespace app;

    require "app/includes/Routing.php";
    use app\includes\Routing;

    // Affirmation des routes
    class Routes extends Routing {
        public function __construct(){
            $this->initRoutes();
        }
        
        public function initRoutes(){
            $this->create(
                "/404",
                "404",
                "404 page introuvable",
                "controllerError",
                "errors/view404",
                "errors"
            );

            $this->create(
                "/auth/login",
                "login",
                "Login",
                "controllerAuth",
                "auth/viewLogin",
                "auth"
            );

            $this->create(
                "/auth/register",
                "register",
                "Register",
                "controllerAuth",
                "auth/viewRegister",
                "auth"
            );

            $this->create(
                "/auth/forgot",
                "forgot",
                "Forgot",
                "controllerAuth",
                "auth/viewForgot",
                "auth"
            );

            $this->create(
                "/auth/validation/{string}",
                "validation",
                "Validation",
                "controllerAuth",
                "auth/viewValidation",
                "auth"
            );

            $this->create(
                "/auth/logout",
                "logout",
                "Logout",
                "controllerAuth",
                null,
                null
            );

            $this->create(
                "/account",
                "account",
                "Account",
                "controllerDashboard",
                "dashboard/viewAccount",
                "dashboard"
            );

            $this->create(
                "/account/change",
                "accountChange",
                "Change Account",
                "controllerDashboard",
                "dashboard/viewAccountChange",
                "dashboard"
            );

            $this->create(
                "/contact",
                "contact",
                "Contact",
                "controllerDashboard",
                null,
                null
            );

            $this->create(
                "/profil/{int}",
                "api",
                "Secret",
                "controllerDashboard",
                "dashboard/viewAPI",
                "dashboard"
            );

            $this->create(
                "/admin/login",
                "adminLogin",
                "Login Admin",
                "controllerAdmin",
                "admin/viewAdminLogin",
                "dashboard"
            );

            $this->create(
                "/admin",
                "admin",
                "Admin",
                "controllerAdmin",
                "admin/viewAdmin",
                "dashboard"
            );
        }

        public function load($label){
            $this->redirect($label);
        }

        public function url($label){
            return $this->getURL($label);
        }

        public function urlReplace($label, $replace){
            return $this->getURLReplace($label, $replace);
        }
    }
?>