<?php require 'views/layout/header.php'; ?>

<div class="container py-5">
    <h2 class="mb-4">Imóveis Disponíveis</h2>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error_message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card p-3 mb-4 bg-light">
        <form action="imoveis" method="GET" class="row g-3 align-items-end">
            <?php if(isset($_GET['category'])): ?>
                <input type="hidden" name="category" value="<?= htmlspecialchars($_GET['category']) ?>">
                <div class="col-12"><div class="alert alert-primary py-1">Filtro Ativo: Categoria **<?= htmlspecialchars($_GET['category']) ?>**</div></div>
            <?php endif; ?>

            <div class="col-md-4">
                <label class="form-label">Cidade</label>
                <select name="city" class="form-select">
                    <option value="">Todas</option>
                    <option value="Rio de Janeiro" <?= ($_GET['city'] ?? '') == 'Rio de Janeiro' ? 'selected' : '' ?>>Rio de Janeiro</option>
                    <option value="São Paulo" <?= ($_GET['city'] ?? '') == 'São Paulo' ? 'selected' : '' ?>>São Paulo</option>
                    <option value="Salvador" <?= ($_GET['city'] ?? '') == 'Salvador' ? 'selected' : '' ?>>Salvador</option>
                    <option value="Gramado" <?= ($_GET['city'] ?? '') == 'Gramado' ? 'selected' : '' ?>>Gramado</option>
                    <option value="Recife" <?= ($_GET['city'] ?? '') == 'Recife' ? 'selected' : '' ?>>Recife</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
            <div class="col-md-2">
                <a href="imoveis" class="btn btn-outline-secondary w-100">Limpar</a>
            </div>
        </form>
    </div>

    <div class="row">
        <?php if (empty($properties)): ?>
            <div class="col-12 text-center text-muted py-5">
                <h4>Nenhum imóvel encontrado com estes filtros.</h4>
            </div>
        <?php else: ?>
            <?php foreach($properties as $prop): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= $prop['img'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="card-title text-truncate"><?= $prop['title'] ?></h5>
                                <span class="badge bg-success align-self-start">R$ <?= $prop['price'] ?></span>
                            </div>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-map-marker-alt text-danger"></i> <?= $prop['city'] ?> | 
                                <i class="fas fa-home text-primary"></i> <?= $prop['type'] ?>
                            </p>
                            <div class="d-flex justify-content-between small text-secondary mb-3">
                                <span><i class="fas fa-bed"></i> <?= $prop['rooms'] ?> Quartos</span>
                                <span><i class="fas fa-user-friends"></i> <?= $prop['guests'] ?> Pessoas</span>
                            </div>
                            
                            <button type="button" class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#modalBooking<?= $prop['id'] ?>">
                                Reservar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modalBooking<?= $prop['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reservar: <?= $prop['title'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form action="booking_action" method="POST">
                                    <input type="hidden" name="property_id" value="<?= $prop['id'] ?>">
                                    <div class="mb-3">
                                        <label>Check-in</label>
                                        <input type="date" name="check_in" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Check-out</label>
                                        <input type="date" name="check_out" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Confirmar Reserva</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require 'views/layout/footer.php'; ?>