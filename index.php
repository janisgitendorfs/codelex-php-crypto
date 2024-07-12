<?php

require_once 'vendor/autoload.php';

session_start();

use CryptoApp\Repositories\Article\ArticleRepository;
use CryptoApp\Repositories\Article\SqliteArticleRepository;
use CryptoApp\Repositories\Comment\CommentRepository;
use CryptoApp\Repositories\Comment\SqliteCommentRepository;
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
use Respect\Validation\Validator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

$twig->addGlobal('flashMessage', $_SESSION['_message'] ?? null);
$twig->addGlobal('input', $_SESSION['_input'] ?? []);
$twig->addGlobal('errors', $_SESSION['_errors'] ?? []);

$container = new DI\Container();
$container->set(
    CurrencyRepository::class,
    new CoinMarketApiCurrencyRepository($_ENV['APIKEY'])
);
$container->set(
    TransactionRepository::class,
    new SqliteTransactionRepository()
);
$container->set(
    ArticleRepository::class,
    new SqliteArticleRepository()
);
$container->set(
    CommentRepository::class,
    new SqliteCommentRepository()
);
$container->set(
    Validator::class,
    Validator::create()
);

$logger = (new Logger('app'))->pushHandler(
    new StreamHandler('storage/logs/app.log', Logger::DEBUG)
);
$container->set(LoggerInterface::class, $logger);

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

$httpMethod = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo $twig->render('errors/404.twig');
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        //
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;

        try {
            $response = ($container->get($controller))->$method(...array_values($vars));
        } catch (Exception $exception)
        {
            $logger->error($exception);

            echo $twig->render('errors/500.twig');
            return;
        }

        if ($response instanceof \CryptoApp\Response)
        {
            echo $twig->render(
                $response->getTemplate() . '.twig',
                $response->getData()
            );

            // flash message
            unset($_SESSION['_message']);
            unset($_SESSION['_input']);
            unset($_SESSION['_errors']);
        }

        if ($response instanceof \CryptoApp\RedirectResponse)
        {
            header('Location: ' . $response->getLocation());
        }

        break;
}