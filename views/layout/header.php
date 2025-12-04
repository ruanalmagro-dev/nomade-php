<?php

$base_path = '';

$local_css_path = 'assets/css/bootstrap.min.css';
$bootstrap_css = file_exists($local_css_path) ? $local_css_path : 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css';
$fontawesome_css = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomade Travels</title>
    <link href="<?= $bootstrap_css ?>" rel="stylesheet">
    <link href="<?= $fontawesome_css ?>" rel="stylesheet">
    <style>

        :root { 
            --primary-color: #003580; 
            --secondary-color: #febb02; 
            --bg-light: #f5f5f5; 
        }

        body { 
            font-family: 'Segoe UI', sans-serif; 
            background-color: var(--bg-light); 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
        }

        .navbar { 
            background-color: var(--primary-color); 
        }

        .navbar-brand, .nav-link { 
            color: white !important; 
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
            margin-right: 8px;
            vertical-align: middle;
        }

        .hero-section { 
            background: linear-gradient(rgba(0,53,128,0.7), rgba(0,53,128,0.7)), url('assets/pop-rio.png'); 
            background-size: cover; 
            padding: 80px 0; 
            color: white; 
        }
        
        .search-box { 
            background: #febb02; 
            padding: 4px; 
            border-radius: 8px; 
            max-width: 1000px; 
            margin: -30px auto 40px; 
            position: relative; 
            z-index: 10; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.2); 
        }

        .property-card {
            transition: transform 0.2s; 
            border: none; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
            cursor: pointer; 
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .destination-card {
            height: 250px;
            background-size: cover;
            background-position: center;
            text-align: center;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .destination-card::before {
            content: ''; position: absolute; top:0; left:0; right:0; bottom:0;
            background: rgba(0,0,0,0.3); 
            transition: background 0.3s;
        }
        .destination-card:hover { 
            transform: scale(1.02); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.3); 
        }

        .destination-card:hover::before { 
            background: rgba(0,0,0,0.1); 
        } 

        .destination-text { 
            position: relative; z-index: 2; 
            font-size: 1.8rem; 
            font-weight: bold; 
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="home">
            <img src="assets/logo.png" alt="Logo Nômade">Nomade</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="home">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="imoveis">Imóveis</a></li>
            </ul>
            <div class="d-flex">
                <?php if(isset($_SESSION['user'])): ?>
                    <span class="navbar-text text-white me-3">Olá, <a href="perfil"><?= $_SESSION['user']['name'] ?></a></span>
                    <a href="perfil" class="btn btn-outline-light rounded-circle me-2"><i class="fa-solid fa-user fa-lg"></i></a>
                    <a href="logout" class="btn btn-danger fw-bold">Sair</a>
                <?php else: ?>
                    <a href="login" class="btn btn-light text-primary fw-bold me-2">Entrar</a>
                    <a href="register" class="btn btn-outline-light fw-bold">Cadastrar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<main class="flex-grow-1">