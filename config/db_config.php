<!-- Connection à la BDD -->
<?php

class Db {
    // Option pour reçevoir des tableaux associatifs de la base de données
    private static $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

    public static function connectDB($dbName,$dbUsername,$dbPassword){
        try {
            // DSN : Database Source Name -- Type : "mysql" - Nom : "dbname=db_exo1" - Host : "localhost"
            $dsn = "mysql:dbname=".$dbName.";host=localhost";

            // PDO : PHP DATA OBJECT -- Instance de la base de donnée (dsn, user, password, options) 
            return new PDO($dsn, $dbUsername, $dbPassword, DB::$options);

        } catch (PDOExcepetion $error) {
            // Stop le script et affiche l'erreur -- getMessage() transforme l'erreur en châine de caractère
            die("Error :" . $error->getMessage());
        }
    }

}


include_once "dotenv.php";
$db = Db::connectDB($_ENV["DB_NAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);

?>