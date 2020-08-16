<?php
    define('ACTIVE_DEBUG', false); // false to disable debug, true to enable it
    define('URL', 'http://'.$_SERVER['HTTP_HOST']); // don't put "/" at the end of URL
    define('DEFAULT_PAGE', 'login'); // label of default page
    define('TITLE', 'VulnApp'); // Global title
    define('WEBSITE_PATH', '/var/www/html/AnotherVulnerableWebApp/'); // website path. Need a "/" at the end of the path.

    // make sure to enable PDO drivers
    define('DB_HOST', '127.0.0.1'); // host MYSQL
    define('DB_USERNAME', 'vulnerability'); // username MYSQL
    define('DB_PASSWORD', '6xUm%3moNghtQaZ8Q'); // password MYSQL
    define('DB_DATABASE', 'vulnerability'); // Databse MYSQL

    // private and site key of grecaptcha v3
    define('PRIVATE_KEY', '');
    define('SITE_KEY', '');

    // Email variables (default configuration for gmail account).
    // https://www.siteground.com/kb/google_free_smtp_server/
    // To send emails from your gmail address, you need to disable dual authentication and enable the "Less secure application access" option.
    // https://myaccount.google.com/ -> "security" -> "Login to Google" -> "Two-step validation" -> disable it
    // https://myaccount.google.com/ -> "security" -> "Less secure application access" -> disable it
    define('EMAIL_HOST', 'smtp.gmail.com'); // SMTP host server
    define('EMAIL_PORT', 587); // SMTP port server
    define('EMAIL_SMTPSECURE', 'tls'); // SMTP security active
    define('EMAIL_SMTP_ACTIVE_AUTH', true); // Should SMTP authenticate ?
    define('EMAIL_DEBUG', false); // false or 1/2/3/4
    define('EMAIL', 'something@gmail.com'); // EMAIL SENDER
    define('EMAIL_PASSWORD', 'password'); // PASSWORD EMAIL SENDER
    define('EMAIL_FROM', 'sender'); // NAME OF SENDER

    define('PASSWORD_ADMIN', 'Administrator');
    define('IDENTIFIANT_ADMIN', 'password123');
?>