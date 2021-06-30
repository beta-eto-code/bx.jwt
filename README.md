# JWT токены для Bitrix

### Установка

```
composer require beta/bx.jwt
```

### Использование

В админке прописываем ключ для подписи (по-умолчанию уже есть), заголовок для передачи токена 
и время жизни токена - /bitrix/admin/settings.php?lang=ru&mid=bx.jwt&mid_menu=1

Инициализируем сервис JWT:

```php
use Bitrix\Main\Config\Option;
use Bx\JWT\UserTokenService;
use Bx\JWT\Strategy\HS256TokenStrategy;
use Bx\JWT\UserDataPacker;
use Bx\Model\Services\UserService;

$ttl = (int)Option::get('bora.jwt', 'JWT_TTL', 86400);   // время жизни токена
$jwtHeader = (string)Option::get('bora.jwt', 'JWT_HTTP_HEADER', 'X-API-Key');
$userService = new UserService();
$userTokenService = new UserTokenService(
    new HS256TokenStrategy(),               // стратегия для подписи токена
    new UserDataPacker($ttl, $userService), // упаковщик данных (здесь определяется какие данные будут записаны в токене)
    $userService                            // сервис для работы с пользователями
);
```

Генерируем токен пользователя:

```php
use Bx\JWT\Interfaces\UserTokenServiceInterface;

/**
* @var UserTokenServiceInterface $userTokenService
*/
$tokenContext = $userTokenService->createToken(1);  // генерируем токен для пользователя с идентификатором 1
(string)$tokenContext; // текстовое представление токена
```

Читаем полученный токен пользователя:

```php
use Bx\JWT\Interfaces\UserTokenServiceInterface;

/**
* @var UserTokenServiceInterface $userTokenService
*/

$tokenStr = '....'; // JWT токен
$tokenContext = $userTokenService->readToken($tokenStr);
$tokenContext->getUid();    // уникальный идентификатор использованный упаковщиком при генерации токена
$tokenContext->getData();   // запакованные в JWT токен данные в виде stdClass

$userContext = $userTokenService->getUserContext($tokenStr);
$userContext->getUserId();          // идентификатор пользователя
$user = $userContext->getUser();    // модель пользователя
$user->getId();
$user->getName();
$user->getLastName();
$user->getSecondName();
$user->getEmail();
$user->getPhone();
```