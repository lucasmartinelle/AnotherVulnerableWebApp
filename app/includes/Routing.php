<?php
    namespace app\includes;

    class Routing {
        private $_routes = array();
        private $_routesByLabel = array();
        private $_view;
        private $_controller;

        // création d'une nouvelle route
        public function create($url, $label, $name, $controller, $view, $template){
            $this->_routes[$url] = array("label" => $label, "name" => $name, "controller" => $controller, "view" => $view, "template" => $template);
            $this->_routesByLabel[$label] = array("url" => $url, "name" => $name, "controller" => $controller, "view" => $view, "template" => $template);
        }

        public function get($url){
            if(empty($url)){
                header('Location: ' . URL . $this->_routesByLabel[DEFAULT_PAGE]["url"]);
            } else {
                // gestion des erreurs
                $pageLoad = 0;
                $controllerExist = 0;
                $viewExist = 0;
                $templateExist = 0;
                // Initialisation de la variables indiquant que la page à était trouvé
                $find = 0;
                // On commence par regardé dans les routes définis (sans {})
                // On parcourt le tableau des routes
                foreach($this->_routes as $route => $info){
                    // On récupère les éléments de l'URL dans un tableau pour le controller.
                    $constructorController = array();
                    // Initialisation de la variable d'erreur
                    $error = false;
                    // On vérifie que l'URL possède autant d'argument que l'élément du tableau
                    $array_url_piece = explode("/", $route);
                    $url_piece = explode("/", $url);;
                    if(count($array_url_piece) == count($url_piece)){
                        // Parcours de l'url partit par partit pour vérifié l'existance de données relatives ("{}")
                        for($i = 1; $i < count($url_piece); $i++){
                            // Si une partie de l'URL n'est pas égale à l'élément du tableau on regarde si cette élément ne contient pas des "{}"
                            if($url_piece[$i] != $array_url_piece[$i]){
                                $error = true;
                            // L'élément du tableau est égale à l'élément de l'URL
                            } else {
                                array_push($constructorController, htmlspecialchars($url_piece[$i], ENT_QUOTES));
                            }
                        }
                    // pas autant d'argument = erreur
                    } else {
                        $error = true;
                    }

                    if(!$error){
                        // on vérifie si le controller existe
                        if(file_exists("controllers/".$info['controller'].".php")){
                            $controllerExist = 1;
                        } 
                        // on vérifie si le view existe
                        if($info['view'] == null){
                            $viewExist = 1;
                        } else {
                            if(file_exists("views/".$info['view'].".php")){
                                $viewExist = 1;
                            }
                        }
                        // on vérifie si la template existe
                        if($info['template'] == null){
                            $templateExist = 1;
                        } else {
                            if(file_exists("views/template/".$info['template'].".php")){
                                $templateExist = 1;
                            }
                        }
                        // si ils existent on appellent la page
                        if($controllerExist == 1 && $viewExist == 1 && $templateExist == 1){
                            $pageLoad = 1;
                            $find = 1;
                            require_once("controllers/".$info['controller'].".php");
                            $load = 'controllers\\'.$info['controller'];
                            $this->_controller = new $load($info['label'], $info['name'], $info['view'], $info['template'], $constructorController);
                        }
                    }
                }
                if($find == 0){
                    foreach($this->_routes as $route => $info){
                        // On récupère les éléments de l'URL dans un tableau pour le controller.
                        $constructorController = array();
                        // Initialisation de la variable d'erreur
                        $error = false;
                        // On vérifie que l'URL possède autant d'argument que l'élément du tableau
                        $array_url_piece = explode("/", $route);
                        $url_piece = explode("/", $url);;
                        if(count($array_url_piece) == count($url_piece)){
                            // Parcours de l'url partit par partit pour vérifié l'existance de données relatives ("{}")
                            for($i = 1; $i < count($url_piece); $i++){
                                // Si une partie de l'URL n'est pas égale à l'élément du tableau on regarde si cette élément ne contient pas des "{}"
                                if($url_piece[$i] != $array_url_piece[$i]){
                                    if(strpos($array_url_piece[$i], "{") !== false && strpos($array_url_piece[$i], "}") !== false){
                                        // si c'est le cas, on récupère le type entre "{}" et on ajoute l'élément dans le constructeur du controller
                                        $type = $this->get_string_between($array_url_piece[$i], "{", "}");
                                        if($type == "int"){
                                            array_push($constructorController, $url_piece[$i]);
                                        } else if($type == "string"){
                                            array_push($constructorController, $url_piece[$i]);
                                        } else {
                                            // le type est inconnu = erreur
                                            $error = true;
                                        }
                                    } else {
                                        // élement inconnu et pas de "{}" = erreur
                                        $error = true;
                                    }
                                // L'élément du tableau est égale à l'élément de l'URL
                                } else {
                                    array_push($constructorController, htmlspecialchars($url_piece[$i], ENT_QUOTES));
                                }
                            }
                        // pas autant d'argument = erreur
                        } else {
                            $error = true;
                        }

                        if(!$error){
                            // on vérifie si le controller existe
                            if(file_exists("controllers/".$info['controller'].".php")){
                                $controllerExist = 1;
                            } 
                            // on vérifie si le view existe
                            if($info['view'] == null){
                                $viewExist = 1;
                            } else {
                                if(file_exists("views/".$info['view'].".php")){
                                    $viewExist = 1;
                                }
                            }
                            // on vérifie si la template existe
                            if($info['template'] == null){
                                $templateExist = 1;
                            } else {
                                if(file_exists("views/template/".$info['template'].".php")){
                                    $templateExist = 1;
                                }
                            }
                            // si ils existent on appellent la page
                            if($controllerExist == 1 && $viewExist == 1 && $templateExist == 1){
                                $pageLoad = 1;
                                require_once("controllers/".$info['controller'].".php");
                                $load = 'controllers\\'.$info['controller'];
                                $this->_controller = new $load($info['label'], $info['name'], $info['view'], $info['template'], $constructorController);
                            }
                        }
                    }
                }

                if($pageLoad == 0){
                    // sinon, redirection page 404
                    header('Location: ' . URL . $this->_routesByLabel["404"]["url"]);
                }
            }
        }

        public function redirect($label){
            header('Location: ' . URL . $this->_routesByLabel[$label]["url"]);
        }

        public function getURL($label){
            return URL . $this->_routesByLabel[$label]["url"];
        }

        public function getURLReplace($label, $replace){
            $url = $this->_routesByLabel[$label]["url"];
            foreach($replace as $value){
                if(strpos($url, "{int}") !== false){
                    $url = str_replace("{int}", $value, $url);
                } else if(strpos($url, "{string}") !== false){
                    $url = str_replace("{string}", $value, $url);
                }
            }
            return URL . $url;
        }

        // fonction pour récupérer les types entre "{}"
        private function get_string_between($string, $start, $end){
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }
    }
?>