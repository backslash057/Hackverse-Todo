# Todo
Todo list app. Users can login, signup and logout. 

## How to install
With a Xampp installation, here are the commands to start the app
```bash
sudo /opt/lampp/lampp startmysql
#import database.sql using phpmyadmin
#update the databse credentials in config.php if needed
sudo /opt/lampp/bin/php -S localhost:8080 router.php
```
For other PHP+MySQL installations, the mysql should be started on port 3306 and the PHP dedicated server started with `router.php` as index file

To install the app with Apache instead of PHP dedicated server, all the request should be redirected to `router.php` because of the project archetiecture and the files should be placed at the root of the htdocs folder (not in a subfolder).

Here is the `.htaccess` file content needed for the global requests redirection
```.htaccess
RewriteEngine On
RewriteRule ^(.*)$ router.php [L]
```

## Screenshots
![App screenshot](https://github.com/backslash057/Hackverse-Todo/screenshots/landing.png)