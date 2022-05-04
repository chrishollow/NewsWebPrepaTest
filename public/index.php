<?php
// use NewsWeb MyPDO class
use NewsWeb\MyPDO;
// Symfony mailer namespaces
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

use NewsWeb\Mapping\theuserMapping;
// dependencies
require_once "../config.php";

// Composer autoload
require_once '../vendor/autoload.php';

// Twig loader
$loader = new \Twig\Loader\FilesystemLoader('../view');
$twig = new \Twig\Environment($loader, [
    //'cache' => '../view/cache',
]);
//instanciation de mailer avec ce que retourne la fonction fromDsn de la class Transport avec la constante
//SMTP définie dans le config
$mailer = new Mailer(Transport::fromDsn('smtp:'.SMTP));
//instanciation de la classe Email pour l'admin
$mailToAdmin = (new Email())->to(ADMIN_MAIL);
$mailToCustomer = (new Email())->from(ADMIN_MAIL);

// Personal autoload
spl_autoload_register(function ($class) {
    include_once '../model/' . $class . '.php';
});

// connect with MyPDO
try {
    $connectMyPDO = new MyPDO(DB_TYPE . ':dbname=' . DB_NAME . ';host=' . DB_HOST . ';charset=' . DB_CHARSET . ';port=' . DB_PORT, DB_LOGIN, DB_PWD, null, PROD);
} catch (Exception $e) {
    die($e->getMessage());
}

// test thearticleMapping

// Call the router
require_once "../controller/routerController.php";

// close connection
$connectMyPDO = null;