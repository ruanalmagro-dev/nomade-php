<?php
if (!isset($property)) {
    http_response_code(404);
    exit;
}
?>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title"><?= $property['title'] ?></h5>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= $property['img'] ?>" class="img-fluid rounded mb-3" style="object-fit: cover; height: 250px; width: 100%;">
                
                <p><i class="fas fa-map-marker-alt text-danger me-1"></i> <?= $property['city'] ?></p>
                <p><i class="fas fa-home text-primary me-1"></i> <?= $property['type'] ?></p>
                
                <ul class="list-unstyled small mt-2">
                    <li><i class="fas fa-bed me-1"></i> <?= $property['rooms'] ?> Quartos</li>
                    <li><i class="fas fa-user-friends me-1"></i> Max. <?= $property['guests'] ?> Hóspedes</li>
                </ul>
            </div>
            
            <div class="col-md-6">
                <h4 class="text-success">R$ <?= $property['price'] ?> <small class="text-muted">/ dia</small></h4>
                
                <hr>
                
                <h5>Solicitar Reserva</h5>
                <form action="booking_action" method="POST">
                    <input type="hidden" name="property_id" value="<?= $property['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Check-in</label>
                        <input type="date" name="check_in" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Check-out</label>
                        <input type="date" name="check_out" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-lg">Reservar Agora</button>
                </form>
            </div>
        </div>
    </div>
</div>