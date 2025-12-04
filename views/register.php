<?php require 'views/layout/header.php'; ?>

<div class="container py-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-body p-4">
            <h3 class="text-center mb-4">Criar Conta</h3>

            <?php if(isset($_GET['error']) && $_GET['error'] == 'exists'): ?>
                <div class="alert alert-warning">E-mail já cadastrado. Tente fazer o login.</div>
            <?php endif; ?>
            <?php if(isset($_GET['error']) && $_GET['error'] == 'pass_mismatch'): ?>
                <div class="alert alert-danger">As senhas digitadas não coincidem.</div>
            <?php endif; ?>

            <form action="auth_action" method="POST">
                <input type="hidden" name="action" value="register">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">CPF</label>
                        <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Endereço Completo</label>
                    <input type="text" name="address" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">E-mail</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" id="regPass" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirmar Senha</label>
                        <input type="password" name="password_confirm" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipo de Conta</label>
                    <select class="form-select" name="type" required>
                        <option value="locatario">Locatário (Quero alugar)</option>
                        <option value="proprietario">Proprietário (Quero anunciar)</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 btn-lg mt-2">Cadastrar</button>
            </form>
            <div class="mt-3 text-center">
                <a href="login">Já tenho conta</a>
            </div>
        </div>
    </div>
</div>

<?php require 'views/layout/footer.php'; ?>