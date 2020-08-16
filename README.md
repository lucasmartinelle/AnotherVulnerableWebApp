![](https://zupimages.net/up/20/33/m7ef.png)

Simple vulnerable site, created by a beginner for beginners.
This vulnerable site covers several vulnerabilities some from real bugbounty cases encountered in bugbounty, can you find them?

## Installation
```bash
apt-get update && apt-get upgrade -y
apt-get install apache2 php php-mysql mariadb-server
a2enmod rewrite
git clone https://github.com/lucasmartinelle/AnotherVulnerableWebApp
mv AnotherVulnerableWebApp/ /var/www/html/
chown www-data:www-data /var/www/html/ -R && chmod 775 /var/www/html/ -R
```

### Create the database :

```sql
mysql -u root
CREATE DATABASE vulnerability;
GRANT ALL ON vulnerability.* TO 'vulnerability'@'localhost' IDENTIFIED BY '6xUm%3moNghtQaZ8Q';
FLUSH PRIVILEGES;
quit
```
If you want, change the password for `vulnerability` user and also in `/var/www/html/AnotherVulnerableWebApp/app/init.php`

### Import the SQL File :

```bash
cd /var/www/html/AnotherVulnerableWebApp/
mysql -u root vulnerability < base.sql
```

Uncomment `extension=pdo_mysql` on `/etc/php/{version}/apache2/php.ini`  
Change `AllowOverride None` to `AllowOverride All` line 172 on `/etc/apache2/apache2.conf`

On `/etc/apache2/sites-enabled/000-default.conf` change `DocumentRoot /var/www/html/` by `DocumentRoot /var/www/html/AnotherVulnerableWebApp` on line 12

Restart apache2 :
```bash
systemctl restart apache2
```

## Solutions :
You can get information about the current vulnerabilities / solutions [here](https://github.com/lucasmartinelle/AnotherVulnerableWebApp/tree/master/Writeup) with more or less details, the goal being that you also do research on your side to better understand them and build your own methodology / payloads

## Contributions :
This repository is for beginners, don't hesitate to create a PR to improve the code, add vulnerabilities, submit your writeup :)