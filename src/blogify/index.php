<?php
require_once 'config.php';

// Si ya está logueado, redirigir a main
if ($sesion->active()) {
    header('Location: main.php');
    exit;
}

// Máquina de estados para procesar el login
$estado = 'mostrar_form';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $estado = 'procesar_login';
}

switch ($estado) {
    case 'procesar_login':
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (!empty($email) && !empty($password)) {
            // Buscar usuario por email
            $sql = "SELECT * FROM usuario WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':email', $email);
            $stmt->execute();
            $usuario = $stmt->fetch();
            
            // Verificar contraseña
            if ($usuario && password_verify($password, $usuario['clave'])) {
                // Login exitoso
                $sesion->set('usuario_id', $usuario['idUsu']);
                $sesion->set('usuario_nombre', $usuario['nombre']);
                $sesion->set('usuario_apellido', $usuario['apellido']);
                $sesion->set('usuario_email', $usuario['email']);
                $sesion->regenerate();
                
                header('Location: main.php');
                exit;
            } else {
                $error = 'Email y/o contraseña incorrectos';
            }
        } else {
            $error = 'Por favor, completa todos los campos';
        }
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BlogiFy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Flex:wght@100;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Flex', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 450px;
            width: 100%;
        }
        .login-title {
            text-align: center;
            margin-bottom: 30px;
            color: #667eea;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">BlogiFy ⋅.˳˳.⋅ॱ˙˙ॱ⋅.˳˳.⋅ॱ˙˙ॱᐧ.˳˳.⋅</h1>
        
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> ENTRAR EN BLOGIFY
                </button>
            </div>
        </form>
        
        <div class="mt-3 text-center text-muted">
            <small>Usuario de prueba: carmen@test.com / password</small>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
