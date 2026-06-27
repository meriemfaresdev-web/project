<?php
session_start();
require_once '../config/database.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // البحث عن المستخدم بالإيميل
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        // التحقق من الموت باس المشفرة (password_verify)
        if ($user && $password === $user['mot_de_passe']) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_name'] = $user['nom_complet'];
            
            // الدخول للـ Dashboard
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Email ou mot de passe incorrect !";
        }
    } else {
        $error = "Veuillez remplir tous les champs !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow p-4">
                    <h3 class="text-center text-primary mb-4">Connexion Admin</h3>
                    
                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger"><?= $error; ?></div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Adresse Email</label>
                            <input type="email" name="email" class="form-relative form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="index.php" class="text-muted small">Retour à l'accueil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>