<?php

require_once 'helpers.php';
require_once 'db.php';

sessionStart();

if (!empty($_SESSION['usuario_id'])) {
    redirect('dashboard.php');
}

$erro = '';
$sucesso = flashGet('sucesso');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['_csrf'] ?? '')) {
        $erro = 'Requisição inválida. Atualize a página e tente novamente.';
    } else {
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if ($email === '' || $senha === '') {
            $erro = 'Preencha todos os campos.';
        } else {
            $pdo  = getConexao();
            $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE LOWER(email) = LOWER(:email)');
            $stmt->execute([':email' => $email]);
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_is_admin'] = (int) ($usuario['is_admin'] ?? 0);

                $destino = 'dashboard.php';
                if (!empty($_SESSION['redirect_pos_login'])) {
                    $destino = $_SESSION['redirect_pos_login'];
                    unset($_SESSION['redirect_pos_login']);
                }

                redirect($destino);
            } else {
                $erro = 'E-mail ou senha inválidos.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow" style="width: 100%; max-width: 420px;">
        <div class="card-body p-4">
            <h4 class="card-title text-center mb-4">Entrar na conta</h4>

            <?php if ($erro): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <?php if ($sucesso): ?>
                <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
            <?php endif; ?>

            <form method="post" action="login.php" novalidate>
                <input type="hidden" name="_csrf" value="<?= csrfToken() ?>">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        value="<?= old('email') ?>"
                        required
                        autofocus
                    >
                </div>
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        class="form-control"
                        required
                    >
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>

            <hr>
            <p class="text-center mb-0">
                Não tem conta? <a href="cadastro.php">Cadastre-se</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
