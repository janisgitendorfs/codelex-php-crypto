<?php

require_once 'vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use CryptoApp\Repositories\Currency\CoinMarketApiCurrencyRepository;
use CryptoApp\Repositories\Currency\CurrencyRepository;
use CryptoApp\Repositories\Transaction\SqliteTransactionRepository;
use CryptoApp\Repositories\Transaction\TransactionRepository;
use CryptoApp\Repositories\User\SqliteUserRepository;
use CryptoApp\Services\User\AuthUserService;
use CryptoApp\Wallet;
use Dotenv\Dotenv;
use Psr\Log\LoggerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

$container = new DI\Container();
$container->set(
    CurrencyRepository::class,
    new CoinMarketApiCurrencyRepository($_ENV['APIKEY'])
);
$container->set(
    TransactionRepository::class,
    new SqliteTransactionRepository()
);

// build logger
switch ($_ENV['APP_LOGGER'])
{
    case 'monolog':
        $logger = (new Logger('app'))->pushHandler(
            new StreamHandler('storage/logs/app.log', Logger::DEBUG)
        );
        break;
    default:
        $logger = new \CryptoApp\EmptyLogger();
        break;
}

$container->set(
    LoggerInterface::class,
    $logger
);

// $log = new Logger('name');
//$log->pushHandler(new StreamHandler('path/to/your.log', Level::Warning));


$transactionRepository = new SqliteTransactionRepository();

$wallet = new Wallet(1000, $transactionRepository);

$userRepository = new SqliteUserRepository();
$service = new AuthUserService($userRepository);

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $routes = include('routes.php');
    foreach ($routes as $route)
    {
        [$method, $url, $controller] = $route;
        $r->addRoute($method, $url, $controller);
    }
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        var_dump('404 not found.');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        //
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        $response = ($container->get($controller))->$method(...array_values($vars));

        if ($response instanceof \CryptoApp\Response)
        {
            echo $twig->render(
                $response->getTemplate() . '.twig',
                $response->getData()
            );
        }

        if ($response instanceof \CryptoApp\RedirectResponse)
        {
            header('Location: ' . $response->getLocation());
        }

        break;
}