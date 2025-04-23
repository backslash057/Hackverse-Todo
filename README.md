# Todo
Todo list app. Users can login, signup and logout. 
## How to install
With a Xampp installation, here are the commands to start the app
```bash
sudo /opt/lampp/lampp startmysql
sudo /opt/lampp/bin/php -S localhost:8080 router.php
```
For other PHP+MySQL installations, the mysql should be started on port 3306 and the PHP dedicated server started with `router.php` as index file

TO use the program with Apache instead of PHP dedicated server, all the request should be redirected to `router.php` because of the project archetiecture. For that redirection, here is the `.htacces` file content to be added in the project directory

```.htacces
RewriteEngine On
RewriteRule ^(.*)$ router.php [L]
```
