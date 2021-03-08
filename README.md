# statistics

attempt to reboot the statistics project by recovering and updating. 
I havent touched it for almost two years and it was already outdated when i started building it. 
I am hopen to clean it up and revive it to use it until i have a new version. 
<br><br>
*It is worth mentioning that this is already the fourth version of statistics. Every version was designed and written from skratch.*

### stack

all is manually written as i have learned it myself and done it several years ago.
using ` MySQL ` for the database, ` PHP ` and ` jQuery `.

### requirements
It is currently running on ` PHP ` 5.5.38. 

running *secure* on [statistics.johannrohn.de](https://statistics.johannrohn.de)
`name` stats
`pass` 4%&UZffgh

`MySQL Database` statistics `name` stats `pass` 9k?i5vJ9


### goals 
* revive project
* running on ` PHP ` 7
* about page with features
* release
* clean/industrie compliant code
* get new weather API
* using mapbox
* auto setup
* make it public
* css check up
* use modern framwork/library or stack to handle db connection
* encrypted
* additional features

## cheat sheet
updating code to be compliant with `PHP` 7
```php 
# MySQL escaping
$mobile = mysql_real_escape_string($mobile);
# Compliant
$mobile = $mysqli->real_escape_string($mobile);

# Get Rows
$result = mysql_fetch_array(mysql_query("SELECT * FROM user ..."));
# Compliant
$result = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM user ..."));

# MySql Fetch Object
$data = mysql_fetch_object($result);
# Compliant
$data = mysqli_fetch_object($result);

#MySQL insert id
$id = mysql_insert_id();
# Compliant
$id = mysqli_insert_id($mysqli);

# MySQL error
mysql_error();
# Coompliant
mysqli_error($mysqli);

# Charset
mysql_set_charset("utf8");
# Compliant
mysqli_set_charset($mysqli, "utf8");
```
## Errors
- `ajax.php` 'addday' location not given
- Tags 'w' not accepted

## notes 
- [MySQL Queries](https://websitebeaver.com/php-pdo-vs-mysqli)

## structure

### files
- ` index.php ` deprcated 
- `today.php` main page
- ` menu.php ` file for the menu 
- ` login.php ` login page
- ` logout.php ` log user out
- ` config.php ` connect to database

### unknowns
- ` offline.php ` ?
- ` dayview.sql ` ?