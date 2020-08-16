<?php
    define('ACTIVE_DEBUG', false); // false to disable debug, true to enable it
    define('URL', 'http://'.$_SERVER['HTTP_HOST']); // don't put "/" at the end of URL
    define('DEFAULT_PAGE', 'login'); // label of default page
    define('TITLE', 'VulnApp'); // Global title
    define('WEBSITE_PATH', '/var/www/html/'); // website path. Need a "/" at the end of the path.

    // make sure to enable PDO drivers
    define('DB_HOST', '127.0.0.1'); // host MYSQL
    define('DB_USERNAME', 'vulnerability'); // username MYSQL
    define('DB_PASSWORD', '6xUm%3moNghtQaZ8Q'); // password MYSQL
    define('DB_DATABASE', 'vulnerability'); // Databse MYSQL

    // private and site key of grecaptcha v3
    define('PRIVATE_KEY', '');
    define('SITE_KEY', '');

    // email informations
    define('EMAIL_SENDER', '');
    define('PASSWORD_SENDER', '');
    define('FROM_SENDER', '');

    define('PASSWORD_ADMIN', 'Administrator');
    define('IDENTIFIANT_ADMIN', 'password123');
?>