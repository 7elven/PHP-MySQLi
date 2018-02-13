# PHP-MySQLi
simple php class connect to mysql database

## How to use
```
git clone https://github.com/7elven/PHP-MySQLi.git
```

## Easy Example
```php
require_once '/{path-to}/PHPMySQLi.php';

$db = new PHPMySQLi('localhost','username','password','database');

$sql = "SELECT * FROM users WHERE user = ?";
$params = ["john"]; //$params is array
$result = $db->query($sql,$params);
$fetch = $db->fetch_all($result);

print_r($fetch);
```

## INSERT
```php
$sql = "INSERT INTO users (user,email) VALUES (?,?)";
$params = ["jay","jay@email.com"]; //$params is array
$db->query($sql,$params);
```

