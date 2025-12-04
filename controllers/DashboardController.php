<?php
class DashboardController {
    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: login');
            exit;
        }

        $user = $_SESSION['user'];
        $propertyModel = new Property();
        
        $myProperties = [];
        $allProperties = [];
        $myBookings = [];

        $is_admin = $user['type'] === 'administrador';
        $is_owner = $user['type'] === 'proprietario';
        $is_renter = $user['type'] === 'locatario';

        if ($is_owner) {
            $myProperties = $propertyModel->getByOwner($user['id']);
        } elseif ($is_admin) {
            $allProperties = $propertyModel->getAll();
        }

        if ($is_renter || $is_admin) {
            $myBookings = $propertyModel->getAllBookingsByUser($user['id']);
        }

        require 'views/dashboard.php';
    }
}