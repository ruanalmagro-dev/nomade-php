<?php
class Property {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::connect();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM properties WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll($filters = []) {
        $sql = "SELECT * FROM properties";
        $conditions = [];
        $params = [];
        
        if (!empty($filters['city'])) {
            $conditions[] = "city = ?";
            $params[] = $filters['city'];
        }
        if (!empty($filters['category'])) {
            $conditions[] = "type = ?";
            $params[] = $filters['category'];
        }
        if (!empty($filters['guests'])) {
            $conditions[] = "guests >= ?";
            $params[] = $filters['guests'];
        }
        
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByOwner($ownerId) {
        $stmt = $this->pdo->prepare("SELECT * FROM properties WHERE owner_id = ?");
        $stmt->execute([$ownerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBookingsByUser($userId) {
        $stmt = $this->pdo->prepare("
            SELECT b.*, p.title, p.city, p.price 
            FROM bookings b 
            JOIN properties p ON b.property_id = p.id 
            WHERE b.user_id = ?
            ORDER BY b.id ASC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($data) {
        $stmt = $this->pdo->prepare("INSERT INTO properties (owner_id, title, city, type, price, rooms, guests, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['owner_id'], $data['title'], $data['city'], $data['type'], $data['price'], $data['rooms'], $data['guests'], $data['img']]);
    }

    public function update($data, $ownerId, $isAdmin = false) {
        $sql = "UPDATE properties SET title = ?, city = ?, type = ?, price = ?, rooms = ?, guests = ?, img = ? WHERE id = ?";
        $params = [$data['title'], $data['city'], $data['type'], $data['price'], $data['rooms'], $data['guests'], $data['img'], $data['id']];

        if (!$isAdmin) {
            $sql .= " AND owner_id = ?";
            $params[] = $ownerId;
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id, $ownerId, $isAdmin = false) {
        $sql = "DELETE FROM properties WHERE id = ?";
        $params = [$id];

        if (!$isAdmin) {
            $sql .= " AND owner_id = ?";
            $params[] = $ownerId;
        }
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function createBooking($data) {
        $check = $this->pdo->prepare("SELECT id FROM bookings WHERE property_id = ? AND status != 'cancelado' AND ((check_in BETWEEN ? AND ?) OR (check_out BETWEEN ? AND ?))");
        $check->execute([$data['property_id'], $data['check_in'], $data['check_out'], $data['check_in'], $data['check_out']]);
        
        if ($check->rowCount() > 0) return false;

        $stmt = $this->pdo->prepare("INSERT INTO bookings (property_id, user_id, check_in, check_out, status) VALUES (?, ?, ?, ?, 'pendente')");
        return $stmt->execute([$data['property_id'], $data['user_id'], $data['check_in'], $data['check_out']]);
    }

    public function updateBookingStatus($bookingId, $userId, $newStatus) {
        $stmt = $this->pdo->prepare("
            UPDATE bookings 
            SET status = ? 
            WHERE id = ? AND user_id = ?
        ");
        return $stmt->execute([$newStatus, $bookingId, $userId]);
    }
}