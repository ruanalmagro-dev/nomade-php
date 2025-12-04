<?php
class PropertyController {

    public function list() {
        $model = new Property();
        
        $filters = [
            'city' => $_GET['city'] ?? null,
            'category' => $_GET['category'] ?? null,
            'guests' => $_GET['guests'] ?? null
        ];

        $properties = $model->getAll($filters);
        
        $error_message = null;
        if (isset($_GET['error']) && $_GET['error'] === 'unavailable') {
            $error_message = 'Desculpe, este imóvel já está reservado para o período selecionado. Tente outras datas.';
        }

        require 'views/properties.php';
    }

    public function details() {
        if (!isset($_GET['id'])) {
            header('Location: home');
            exit;
        }

        $model = new Property();
        $property = $model->getById($_GET['id']);

        if (!$property) {
            header('Location: imoveis');
            exit;
        }

        require 'views/details.php';
    }

    public function handleBooking() {
        if (!isset($_SESSION['user'])) {
            header('Location: login?error=auth_required');
            exit;
        }

        if ($_SESSION['user']['type'] === 'proprietario') {
            header('Location: imoveis?error=owner_booking');
            exit;
        }

        $model = new Property();
        $data = [
            'user_id' => $_SESSION['user']['id'],
            'property_id' => $_POST['property_id'],
            'check_in' => $_POST['check_in'],
            'check_out' => $_POST['check_out']
        ];

        if ($model->createBooking($data)) {
            header('Location: perfil?success=booking_created');
        } else {
            header('Location: imoveis?error=unavailable');
        }
    }

    public function handlePayment() {
        if (!isset($_SESSION['user'])) {
            header('Location: login');
            exit;
        }
        
        $user_id = $_SESSION['user']['id'];
        $booking_id = $_POST['booking_id'] ?? null;
        $new_status = $_POST['status'] ?? 'pago';

        if (!$booking_id) {
            header('Location: perfil?error=invalid_booking');
            exit;
        }
        
        $model = new Property();
        
        if ($model->updateBookingStatus($booking_id, $user_id, $new_status)) {
            $msg = ($new_status === 'pago') ? 'payment_confirmed' : 'cancellation_confirmed';
            header("Location: perfil?success=$msg");
        } else {
            header('Location: perfil?error=action_failed');
        }
    }

    public function handleOwnerAction() {
        if (!isset($_SESSION['user'])) {
            header('Location: login');
            exit;
        }

        $user = $_SESSION['user'];
        $is_admin = $user['type'] === 'administrador';

        if ($user['type'] !== 'proprietario' && !$is_admin) {
            header('Location: home');
            exit;
        }

        $action = $_POST['action'] ?? '';
        $model = new Property();
        $owner_id = $user['id'];

        $finalImgPath = 'https://via.placeholder.com/300';
        
        if (isset($_FILES['img_file']) && $_FILES['img_file']['error'] === UPLOAD_ERR_OK) {
            
            $uploadDir = 'assets/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $ext = pathinfo($_FILES['img_file']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('prop_') . '.' . $ext;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['img_file']['tmp_name'], $targetPath)) {
                $finalImgPath = $targetPath;
            }
        } 
        elseif (!empty($_POST['img'])) {
            $finalImgPath = $_POST['img'];
        }
        
        $data = [
            'title' => $_POST['title'] ?? '',
            'city' => $_POST['city'] ?? '',
            'type' => $_POST['type'] ?? 'Apartamento',
            'price' => $_POST['price'] ?? 0,
            'rooms' => $_POST['rooms'] ?? 1,
            'guests' => $_POST['guests'] ?? 2,
            'img' => $finalImgPath
        ];

        if ($action === 'add') {
            $data['owner_id'] = $owner_id;
            $model->add($data);
        } 
        elseif ($action === 'update') {
            $data['id'] = $_POST['id'];
            $model->update($data, $owner_id, $is_admin);
        }
        elseif ($action === 'delete') {
            $id = $_POST['id'];
            $model->delete($id, $owner_id, $is_admin);
        }

        header('Location: perfil');
    }
}