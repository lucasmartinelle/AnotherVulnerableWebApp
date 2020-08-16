# Download

* execute `git clone https://github.com/lucasmartinelle/vulnerability.git` (and add `img` folder in `assets`),

* create a '`vulnerability`' database and paste the tables from the '`base.sql`' file into it,

* Modify the variables in `app/init.php` according to your needs,

* paste this in your "site-enable" configuration for nginx

  ```nginx
  location / {
      if (!-e $request_filename){
          rewrite ^(.*)$ /index.php?url=$1;
      }
  }
  ```

  or this in your .htaccess for apache (don't forget don't allow .htaccess in your apache configuration)

  ```nginx
  RewriteEngine On
  RewriteBase /
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^(.*)$ index.php?url=$1 [L]
  ```

  

* You need to add 'PDO' modules in your php.ini.

* You can also modify the URLS / titles of the pages in `app/Routes.php` in the `initRoutes` function by following the [documentation](https://github.com/lucasmartinelle/blankmvc/blob/master/README.md).

# Vulnerability and solution :

* XSS
  + use of "[htmlspecialchars](https://www.php.net/manual/fr/function.htmlspecialchars.php)"
  + [openclassroom XSS](https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2680167-la-faille-xss)
* iSQL
  + use of "[htmlspecialchars](https://www.php.net/manual/fr/function.htmlspecialchars.php)"
  + [prepared queries](https://www.php.net/manual/fr/pdo.prepared-statements.php) 
  + typing (use of `(int)`, `(string)`, `(float)`, before a variable)
  + [openclassroom iSQL](https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2680180-linjection-sql)
* attack by brute force
  + IP ban after 20 tests
  + [captcha](https://www.google.com/recaptcha/about/)
  + [openclassroom brute force](https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2680183-lattaque-par-force-brute)
* Upload (double extension, content-type, malware, ..)
  + file renaming (generation of a 16 random character string: `bin2hex(openssl_random_pseudo_bytes(32, MCRYPT_DEV_URANDOM)) `)
  + extension control (only accept extensions related to photos for example (`jpg`, `png`, `gif`))
  + checking that the file size is greater than 0
  + checking that the file does not contain any code-like characters (`;`, `<`, `>`, ..)
  + htaccess
  + [openclassroom upload](https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2680177-la-faille-upload) 
* CRSF
  + token (`bin2hex(openssl_random_pseudo_bytes(32, MCRYPT_DEV_URANDOM)) `)
  + referer check (where the request comes from).
  + [openclassroom crsf](https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2863569-la-csrf)
* CRLF
  + deletion of line breaks [str_replace](https://www.php.net/manual/fr/function.str-replace.php)
  + [filter](https://www.php.net/manual/fr/function.filter-var.php)
  + [openclassroom crlf](https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2863578-la-crlf)
* Session steal
  + token between each page check and modify
  + [openclassroom session](https://openclassrooms.com/fr/courses/2091901-protegez-vous-efficacement-contre-les-failles-web/2918871-les-variable-de-session)
