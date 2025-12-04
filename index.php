<?php
session_start();

require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Property.php';
require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/PropertyController.php';
require_once 'controllers/DashboardController.php';

$url = isset($_GET['url']) ? explode('/', $_GET['url']) : ['home'];
$page = $url[0];

switch ($page) {
    case 'home':
    case '':
        (new HomeController())->index();
        break;
    
    case 'login':
        (new AuthController())->login();
        break;
        
    case 'register':
        (new AuthController())->register();
        break;
        
    case 'logout':
        (new AuthController())->logout();
        break;

    case 'imoveis':
        (new PropertyController())->list();
        break;

    case 'perfil':
        (new DashboardController())->index();
        break;

    case 'detalhes':
        (new PropertyController())->details();
        break;
        
    // Ações de formulário (POST)
    case 'auth_action':
        (new AuthController())->handleAction();
        break;
        
    case 'booking_action':
        (new PropertyController())->handleBooking();
        break;
        
    case 'property_action':
        (new PropertyController())->handleOwnerAction();
        break;
        
    case 'payment_action':
        (new PropertyController())->handlePayment();
        break;

    default:
        echo "<h1>Página não encontrada (404)</h1>";
        break;
}