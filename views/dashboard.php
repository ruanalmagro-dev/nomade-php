<?php require 'views/layout/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Painel de Controle - <?= ucfirst($user['type']) ?></h2>
        <a href="logout" class="btn btn-outline-danger">Sair</a>
    </div>
    <hr>
    
    <?php if(isset($_GET['success'])): ?>
        <?php if($_GET['success'] === 'payment_confirmed'): ?>
            <div class="alert alert-success">Pagamento confirmado com sucesso!</div>
        <?php elseif($_GET['success'] === 'cancellation_confirmed'): ?>
            <div class="alert alert-info">Reserva cancelada com sucesso!</div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if($user['type'] === 'administrador'): ?>
        
        <h4 class="mb-3">Gerenciamento de Imóveis (Todos)</h4>
        <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#modalAddPropertyAdmin">
            <i class="fas fa-plus-circle me-2"></i>Listar imóvel para locação
        </button>

        <div class="modal fade" id="modalAddPropertyAdmin" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Novo Imóvel (Admin)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="property_action" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-6">
                                    <label class="small">Título</label>
                                    <input name="title" class="form-control" placeholder="Título" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small">Cidade</label>
                                    <input name="city" class="form-control" placeholder="Cidade" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small">Tipo</label>
                                    <select name="type" class="form-select">
                                        <option value="Apartamento">Apartamento</option>
                                        <option value="Casa">Casa</option>
                                        <option value="Hotel">Hotel</option>
                                        <option value="Resort">Resort</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="small">Preço/Dia</label>
                                    <input name="price" type="number" class="form-control" placeholder="R$" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="small">Foto Principal</label>
                                    <input type="file" name="img_file" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-2">
                                    <label class="small">Quartos</label>
                                    <input name="rooms" type="number" class="form-control" value="1" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="small">Hóspedes</label>
                                    <input name="guests" type="number" class="form-control" value="2" required>
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Adicionar Imóvel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <table class="table table-striped table-bordered">
            <thead class="table-dark"><tr><th>ID</th><th>Título</th><th>Preço</th><th>Imagem</th><th>Ações</th></tr></thead>
            <tbody>
                <?php foreach($allProperties as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['title'] ?></td>
                    <td>R$ <?= $p['price'] ?></td>
                    <td><img src="<?= $p['img'] ?>" height="30"></td>
                    <td>
                        <form action="property_action" method="POST" onsubmit="return confirm('Confirmar exclusão?');" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    
    <?php elseif($user['type'] === 'proprietario'): ?>
        
        <h4 class="mb-3">Meus Imóveis Anunciados (<?= count($myProperties) ?>)</h4>
        <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#modalAddPropertyOwner">
            <i class="fas fa-plus-circle me-2"></i>Listar imóvel para locação
        </button>

        <div class="modal fade" id="modalAddPropertyOwner" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Listar imóvel para locação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="property_action" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="add">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-6">
                                    <label class="small">Título</label>
                                    <input name="title" class="form-control" placeholder="Ex: Casa na Praia" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small">Cidade</label>
                                    <input name="city" class="form-control" placeholder="Ex: Recife" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small">Tipo</label>
                                    <select name="type" class="form-select">
                                        <option value="Apartamento">Apartamento</option>
                                        <option value="Casa">Casa</option>
                                        <option value="Hotel">Hotel</option>
                                        <option value="Resort">Resort</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="small">Preço/Dia</label>
                                    <input name="price" type="number" class="form-control" placeholder="0.00" required>
                                </div>
                                <div class="col-md-5">
                                    <label class="small">Foto</label>
                                    <input type="file" name="img_file" class="form-control" accept="image/*">
                                </div>
                                <div class="col-md-2">
                                    <label class="small">Quartos</label>
                                    <input name="rooms" type="number" class="form-control" value="1">
                                </div>
                                <div class="col-md-2">
                                    <label class="small">Hóspedes</label>
                                    <input name="guests" type="number" class="form-control" value="2">
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Publicar Imóvel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <table class="table table-striped">
            <thead class="table-light"><tr><th>Título</th><th>Cidade</th><th>Preço</th><th>Ações</th></tr></thead>
            <tbody>
                <?php foreach($myProperties as $p): ?>
                <tr>
                    <td><?= $p['title'] ?></td>
                    <td><?= $p['city'] ?></td>
                    <td>R$ <?= $p['price'] ?></td>
                    <td>
                        <form action="property_action" method="POST" onsubmit="return confirm('Confirmar exclusão?');" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <?php if($user['type'] === 'locatario' || $user['type'] === 'administrador'): ?>
        <h4 class="mt-5">Minhas Reservas</h4>
        <table class="table table-bordered mt-3">
            <thead class="table-light"><tr><th>Imóvel</th><th>Check-in</th><th>Check-out</th><th>Status</th><th>Total (Est.)</th><th>Ação</th></tr></thead>
            <tbody>
                <?php if (empty($myBookings)): ?>
                    <tr><td colspan="6">Nenhuma reserva encontrada.</td></tr>
                <?php else: ?>
                    <?php foreach($myBookings as $b): 
                        $in = new DateTime($b['check_in']);
                        $out = new DateTime($b['check_out']);
                        $diff = $in->diff($out)->days;
                        $total = $diff * ($b['price'] ?? 0);
                        $total_formatado = number_format($total, 2, ',', '.');
                        $booking_id = $b['id'];
                    ?>
                    <tr>
                        <td><strong><?= $b['title'] ?? 'Imóvel Removido' ?></strong> (<?= $b['city'] ?? '-' ?>)</td>
                        <td><?= date('d/m/Y', strtotime($b['check_in'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($b['check_out'])) ?></td>
                        <td class="status-<?= strtolower($b['status']) ?>"><?= ucfirst($b['status']) ?></td>
                        <td>R$ <?= $total_formatado ?></td>
                        <td>
                            <?php if ($b['status'] === 'pendente'): ?>
                                <button type="button" class="btn btn-success btn-sm me-1" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalPaymentSelect"
                                    data-booking-id="<?= $booking_id ?>"
                                    data-total="<?= $total_formatado ?>"
                                    data-title="<?= $b['title'] ?>">
                                    Pagar
                                </button>
                                
                                <form action="payment_action" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva?');" style="display:inline;">
                                    <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                                    <input type="hidden" name="status" value="cancelado">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        Cancelar
                                    </button>
                                </form>
                            <?php elseif ($b['status'] === 'pago'): ?>
                                <span class="badge bg-primary">Confirmado</span>
                            <?php elseif ($b['status'] === 'cancelado'): ?>
                                <span class="badge bg-secondary">Cancelado</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div class="modal fade" id="modalPaymentSelect" tabindex="-1" aria-labelledby="paymentSelectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentSelectLabel">Finalizar Pagamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <h6>Imóvel: <span id="paymentPropertyTitle" class="fw-bold"></span></h6>
                <h4 class="mb-4">Valor Total: R$ <span id="paymentTotalValue" class="text-success"></span></h4>

                <p>Selecione a forma de pagamento:</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-lg btn-outline-primary" onclick="showPixModal()">
                        <i class="fab fa-cc-paypal me-2"></i> Pagar com PIX
                    </button>
                    <button class="btn btn-lg btn-outline-primary" onclick="showCreditCardModal()">
                        <i class="fas fa-credit-card me-2"></i> Pagar com Cartão de Crédito
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPix" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagamento via PIX</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>Escaneie o QR Code abaixo para pagar R$ <span id="pixTotalValue" class="fw-bold text-success"></span>.</p>
                <img src="assets/qrcode.png" alt="QR Code PIX" class="img-fluid w-50 mx-auto border p-2">
                <p class="mt-3 small">Chave: 000.000.000-00 (Simulação)</p>
                
                <form action="payment_action" method="POST" class="mt-4">
                    <input type="hidden" name="booking_id" id="pixBookingId">
                    <button type="submit" class="btn btn-success w-100 btn-lg">Pagamento Realizado (Confirmar)</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreditCard" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dados do Cartão de Crédito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="payment_action" method="POST">
                    <input type="hidden" name="booking_id" id="cardBookingId">
                    
                    <div class="mb-3">
                        <label class="form-label">Número do Cartão</label>
                        <input type="text" class="form-control" placeholder="**** **** **** ****" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome do Titular</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label">Data de Vencimento (MM/AA)</label>
                            <input type="text" class="form-control" placeholder="MM/AA" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label">Dígitos de Segurança (CVV)</label>
                            <input type="text" class="form-control" placeholder="CVV" required>
                        </div>
                    </div>
                    
                    <h5 class="text-center mt-3">Total a Pagar: R$ <span id="cardTotalValue" class="text-success"></span></h5>
                    
                    <button type="submit" class="btn btn-success w-100 btn-lg mt-3">Confirmar Pagamento</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let currentBookingId = null;
    let currentTotal = null;

    document.addEventListener('DOMContentLoaded', function () {
        var paymentSelectModal = document.getElementById('modalPaymentSelect');
        paymentSelectModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            currentBookingId = button.getAttribute('data-booking-id');
            currentTotal = button.getAttribute('data-total');
            var title = button.getAttribute('data-title');

            document.getElementById('paymentPropertyTitle').textContent = title;
            document.getElementById('paymentTotalValue').textContent = currentTotal;

            var pixModal = bootstrap.Modal.getInstance(document.getElementById('modalPix'));
            if (pixModal) pixModal.hide();
            var cardModal = bootstrap.Modal.getInstance(document.getElementById('modalCreditCard'));
            if (cardModal) cardModal.hide();
        });
    });

    function showPixModal() {
        document.getElementById('pixBookingId').value = currentBookingId;
        document.getElementById('pixTotalValue').textContent = currentTotal;
        
        var selectModal = bootstrap.Modal.getInstance(document.getElementById('modalPaymentSelect'));
        selectModal.hide();
        var pixModal = new bootstrap.Modal(document.getElementById('modalPix'));
        pixModal.show();
    }

    function showCreditCardModal() {
        document.getElementById('cardBookingId').value = currentBookingId;
        document.getElementById('cardTotalValue').textContent = currentTotal;

        var selectModal = bootstrap.Modal.getInstance(document.getElementById('modalPaymentSelect'));
        selectModal.hide();
        var cardModal = new bootstrap.Modal(document.getElementById('modalCreditCard'));
        cardModal.show();
    }
</script>

<?php require 'views/layout/footer.php'; ?>