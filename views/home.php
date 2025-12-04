<?php require 'views/layout/header.php'; ?>

<div class="hero-section text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Encontre sua próxima estadia</h1>
        <p class="lead">Busque ofertas em hotéis, casas e muito mais...</p>
        <a class="btn btn-warning btn-lg fw-bold" href="imoveis" role="button">Ver Todos os Imóveis</a>
    </div>
</div>

<div class="container position-relative" style="margin-top: -50px; z-index: 10;">
    
    <div class="card shadow border-0 mb-5">
        <div class="card-body p-4">
            <form action="imoveis" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold">Destino</label>
                    <select class="form-select" name="city">
                        <option value="">Todos os destinos</option>
                        <option value="Rio de Janeiro">Rio de Janeiro</option>
                        <option value="São Paulo">São Paulo</option>
                        <option value="Recife">Recife</option>
                        <option value="Salvador">Salvador</option>
                        <option value="Gramado">Gramado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Check-in / Check-out</label>
                    <div class="input-group">
                        <input type="date" class="form-control" name="check_in">
                        <input type="date" class="form-control" name="check_out">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Hóspedes</label>
                    <input type="number" class="form-control" name="guests" placeholder="2" min="1" value="2">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>


    <div class="container mb-5 p-0">
        <h4 class="mb-3 fw-bold">Categorias</h4>
        <div class="row text-center g-3">
            <div class="col-6 col-md-3">
                <a href="imoveis?category=Hotel" class="card p-3 property-card text-decoration-none text-dark h-100">
                    <div class="card-body"><i class="fas fa-hotel fa-2x text-primary"></i><h5 class="mt-2">Hotéis</h5></div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="imoveis?category=Apartamento" class="card p-3 property-card text-decoration-none text-dark h-100">
                    <div class="card-body"><i class="fas fa-building fa-2x text-primary"></i><h5 class="mt-2">Apartamentos</h5></div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="imoveis?category=Resort" class="card p-3 property-card text-decoration-none text-dark h-100">
                    <div class="card-body"><i class="fas fa-umbrella-beach fa-2x text-primary"></i><h5 class="mt-2">Resorts</h5></div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="imoveis?category=Casa" class="card p-3 property-card text-decoration-none text-dark h-100">
                    <div class="card-body"><i class="fas fa-home fa-2x text-primary"></i><h5 class="mt-2">Casas</h5></div>
                </a>
            </div>
        </div>
    </div>

    <h3 class="mb-3 fw-bold">Destinos Populares</h3>
    <div class="row g-4 mb-5">
        <div class="col-md-3 col-6">
            <a href="imoveis?city=Rio de Janeiro" class="destination-card" 
                 style="background-image: url('assets/pop-rio.png');">
                <span class="destination-text">Rio de Janeiro</span>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="imoveis?city=São Paulo" class="destination-card" 
                 style="background-image: url('assets/pop-sp.png');">
                <span class="destination-text">São Paulo</span>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="imoveis?city=Salvador" class="destination-card" 
                 style="background-image: url('assets/pop-salv.png');">
                <span class="destination-text">Salvador</span>
            </a>
        </div>
        <div class="col-md-3 col-6">
            <a href="imoveis?city=Recife" class="destination-card" 
                 style="background-image: url('assets/pop-rec.png');">
                <span class="destination-text">Recife</span>
            </a>
        </div>
    </div>

    <h2 class="mb-4 fw-bold">Destaques</h2>
    <div class="row">
        <?php foreach(array_slice($featured, 0, 3) as $prop): ?>
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm h-100 property-card">
                    <img src="<?= $prop['img'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title"><?= $prop['title'] ?></h5>
                            <span class="badge bg-primary align-self-start">R$ <?= $prop['price'] ?></span>
                        </div>
                        <p class="card-text text-muted"><?= $prop['city'] ?> | <?= $prop['type'] ?></p>
                        <button type="button" class="btn btn-outline-primary w-100 btn-view-detail" data-id="<?= $prop['id'] ?>">Ver Detalhes</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="modalPropertyDetail" tabindex="-1" aria-labelledby="modalPropertyDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-container">
        </div>
    </div>
</div>

<?php require 'views/layout/footer.php'; ?>