# Simple PHP/ MySQL URL Shortener
## https://github.com/starpepsi/simple-php-url-shortener
A simple URL shortener for your own domain/ webserver.

### To install!
1. Ensure you have Apache2, PHP, and MySQL installed and running on your webserver with .htaccess enabled
2. Create the database structure using 'url-shortener.sql'
3. Create a username and password for your database
4. Change the 'username' and 'password' fields in 'index.php'
5. For security you may wish to move the $con variable/ mysqli() function to a php file away from a public directory. Use a PHP require statement to do this!
