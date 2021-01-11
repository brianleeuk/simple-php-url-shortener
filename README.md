# Simple PHP/ MySQL URL Shortener
## A simple URL shortener for your own domain/ webserver.
### To install!
1. Ensure you have Apache2, PHP, and MySQL/ MariaDB installed and running on your webserver with .htaccess enabled
2. Create the database structure using the 'url_shortener.sql' script
3. Create a username and password for your database
4. Change the 'username' and 'password' fields in 'index.php'
5. For security you may wish to move the $con variable/ mysqli() function to a php file away from a public directory. Use a PHP require statement to do this!
