<?php
    namespace Models;
    
    use PDO;
    
    abstract class Model {
        private static $_bdd;

        // Instance de la connexion à la BDD
        private static function setBdd(){
            try {
                self::$_bdd = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DATABASE.'', DB_USERNAME, DB_PASSWORD);
                self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$_bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (Exception $e){
                echo $e->getMessage();
            }
        }

        // Récupération de la BDD
        protected function getBdd(){
            if(self::$_bdd == null){
                self::setBdd();
            }
            return self::$_bdd;
        }

        // Récupère toute les données de la table {$table} dans l'objet {$obj}
        protected function getAll($table, $obj){
            $var = [];
            $req = $this->getBdd()->prepare('SELECT * FROM ' . $table . ' ORDER BY id DESC');
            $req->execute();
            while($data = $req->fetch(PDO::FETCH_ASSOC)){
                require_once("models/tables/".$obj.".php");
                $load = 'Model\Tables\\'.$obj;
                $var[] = new $load($data);
            }
            return $var;
            $req->closeCursor();
        }

        // Insert des données dans la table {$table} (ne pas entrer de données initalisé avec une valeur par défaut, dans l'ordre de définition des éléments dans la base de donnée)
        // Exemple [  insert('users', array('id' => '1', 'email' => 'test@test.com', ..))  ]
        protected function insert($table, $donnees){
            try {
                $colonnes = '';
                $values = '';
                foreach($donnees as $colonne => $value){
                    $colonnes .= "`".$colonne."`, ";
                    $values .= "'".$value."', ";
                }
                $colonnes = substr($colonnes, 0, -2);
                $values = substr($values, 0, -2);
                $req = $this->getBdd()->prepare("INSERT INTO `" . $table . "` (".$colonnes.") VALUES (".$values.")");
                $req->execute();
                return true;
            } catch (Exception $e){
                return $e->getMessage();
            }
            $req->closeCursor();
        }

        // Selection des données dans la table {$table} en fonction des informations {$WHERE} et {$LIMIT}
        // Exemple [  select('users', array('id', 'username', 'validity'), array('validity' => 'on'), '0,5')  ]
        protected function select($table, $colonne, $where, $limit){
            $stmt = "SELECT";
            try {
                // Recherche en fonction de colonnes ou non
                if($colonne != null){
                    foreach($colonne as $key){
                        $stmt .= " `".$key."`,";
                    }
                    $stmt = substr($stmt, 0, -1);
                    $stmt .= " FROM `".$table."`";
                } else {
                    $stmt .= " * FROM `".$table."`";
                }

                // si une clause "where" est précisé
                if($where != null){
                    $stmt .= " WHERE";
                    foreach($where as $key => $value){
                        $stmt .= " `".$key."`='".$value."' AND";
                    }
                    $stmt = substr($stmt, 0, -4);
                }

                // si une clause "limit" est précisé
                if($limit != null){
                    $stmt .= " LIMIT " . $limit;
                }

                $req = $this->getBdd()->prepare($stmt);
                $req->execute();
                return $req;
                $req->closeCursor();
            } catch(Exception $e){
                return null;
            }
        }

        // Mise à jour des données dans la table {$table}
        // Exemple [  update('users', array('validity' => 'on', 'updated_at' => '2020-01-01 00:00:00), array('username' => 'test'))  ]
        protected function update($table, $update, $where){
            try {
                $stmt = "UPDATE " . "`".$table."` SET";
                foreach($update as $key => $value){
                    $stmt .= " `".$key."`='".$value."',";
                }
                $stmt = substr($stmt, 0, -1);
                $stmt .= " WHERE";
                foreach($where as $key => $value){
                    $stmt .= " `".$key."`='".$value."' AND";
                }
                $stmt = substr($stmt, 0, -4);
                $req = $this->getBdd()->prepare($stmt);
                $req->execute();
                return true;
                $req->closeCursor();
            } catch (Exception $e){
                return false;
            }
        }

        // Suppresion de donnée dans la table {$table}
        // Exemple [  delete('users', array('id' => '1', 'username' => 'test'))  ]
        protected function delete($table, $where){
            try {
                $stmt = "DELETE FROM `".$table."` WHERE ";
                foreach($where as $key => $value){
                    $stmt .= " `".$key."`='".$value."' AND";
                }
                $stmt = substr($stmt, 0, -4);
                $req = $this->getBdd()->prepare($stmt);
                $req->execute();
                return true;
                $req->closeCursor();
            } catch (Exception $e){
                return false;
            }
        }
    }
?>