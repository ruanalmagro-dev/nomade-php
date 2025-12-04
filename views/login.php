<?php require 'views/layout/header.php'; ?>

<div class="container py-5" style="max-width: 400px;">
    <div class="card shadow">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Login</h3>
            
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger">Dados inválidos.</div>
            <?php endif; ?>

            <form action="auth_action" method="POST">
                <input type="hidden" name="action" value="login">
                <div class="mb-3">
                    <label>E-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Senha</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
            <div class="mt-3 text-center">
                <a href="register">Criar conta</a>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layout/footer.php'; ?>