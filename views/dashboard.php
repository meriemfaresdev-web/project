<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

require_once '../config/database.php';
require_once '../models/stagiaire.php';
require_once '../models/formation.php';
require_once '../models/inscription.php'; // زدنـا الموديل هنا

$stagiaires = getAllStagiaires($pdo);
$formations = getAllFormations($pdo);
$inscriptions = getAllInscriptions($pdo); // جلب التسجيلات

// معالجة فورمولار التسجيل (Inscription) ف نفس الصفحة لتفادي كثرة الملفات
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'inscrire') {
    $id_s = intval($_POST['id_stagiaire']);
    $id_f = intval($_POST['id_formation']);
    if (!empty($id_s) && !empty($id_f)) {
        inscrireStagiaire($pdo, $id_s, $id_f);
    }
    header('Location: dashboard.php?tab=inscriptions');
    exit();
}

$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'stagiaires';

$edit_stagiaire = null;
if (isset($_GET['edit_s'])) { $edit_stagiaire = getStagiaireById($pdo, intval($_GET['edit_s'])); }

$edit_formation = null;
if (isset($_GET['edit_f'])) { $edit_formation = getFormationById($pdo, intval($_GET['edit_f'])); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - École de Formation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🎓 École Admin</a>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-white me-3">Bienvenue, <strong><?= $_SESSION['user_name']; ?></strong></span>
                <a href="dashboard.php?logout=true" class="btn btn-danger btn-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <ul class="nav nav-pills mb-4 justify-content-center">
            <li class="nav-item">
                <a class="nav-link <?= $active_tab === 'stagiaires' ? 'active' : ''; ?>" href="dashboard.php?tab=stagiaires">Gestion des Stagiaires</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active_tab === 'formations' ? 'active' : ''; ?>" href="dashboard.php?tab=formations">Gestion des Formations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= $active_tab === 'inscriptions' ? 'active' : ''; ?>" href="dashboard.php?tab=inscriptions">Gestion des Inscriptions</a>
            </li>
        </ul>

        <div class="row">
            
            <?php if ($active_tab === 'stagiaires'): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-4">
                        <h4 class="text-primary mb-3"><?= $edit_stagiaire ? "Modifier" : "Ajouter"; ?> Stagiaire</h4>
                        <form action="../controllers/stagiaireController.php" method="POST">
                            <input type="hidden" name="action" value="<?= $edit_stagiaire ? 'update' : 'add'; ?>">
                            <?php if ($edit_stagiaire): ?><input type="hidden" name="id_stagiaire" value="<?= $edit_stagiaire['id_stagiaire']; ?>"><?php endif; ?>
                            <div class="mb-3"><label class="form-label">Nom</label><input type="text" name="nom" class="form-control" value="<?= $edit_stagiaire['nom'] ?? ''; ?>" required></div>
                            <div class="mb-3"><label class="form-label">Prénom</label><input type="text" name="prenom" class="form-control" value="<?= $edit_stagiaire['prenom'] ?? ''; ?>" required></div>
                            <div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="<?= $edit_stagiaire['email'] ?? ''; ?>" required></div>
                            <div class="mb-3"><label class="form-label">Téléphone</label><input type="text" name="telephone" class="form-control" value="<?= $edit_stagiaire['telephone'] ?? ''; ?>" required></div>
                            <button type="submit" class="btn <?= $edit_stagiaire ? 'btn-warning' : 'btn-success'; ?> w-100"><?= $edit_stagiaire ? "Modifier" : "Ajouter"; ?></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm p-4">
                        <h4 class="mb-3 text-secondary">Liste des Stagiaires</h4>
                        <table class="table table-striped">
                            <thead class="table-dark"><tr><th>ID</th><th>Nom Complet</th><th>Email</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach ($stagiaires as $s): ?>
                                <tr>
                                    <td><?= $s['id_stagiaire']; ?></td>
                                    <td><?= htmlspecialchars($s['nom'] . ' ' . $s['prenom']); ?></td>
                                    <td><?= htmlspecialchars($s['email']); ?></td>
                                    <td>
                                        <a href="dashboard.php?tab=stagiaires&edit_s=<?= $s['id_stagiaire']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                                        <a href="../controllers/stagiaireController.php?action=delete&id=<?= $s['id_stagiaire']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($active_tab === 'formations'): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-4">
                        <h4 class="text-primary mb-3"><?= $edit_formation ? "Modifier" : "Ajouter"; ?> Formation</h4>
                        <form action="../controllers/formationController.php" method="POST">
                            <input type="hidden" name="action" value="<?= $edit_formation ? 'update' : 'add'; ?>">
                            <?php if ($edit_formation): ?><input type="hidden" name="id_formation" value="<?= $edit_formation['id_formation']; ?>"><?php endif; ?>
                            <div class="mb-3"><label class="form-label">Titre</label><input type="text" name="titre" class="form-control" value="<?= $edit_formation['titre'] ?? ''; ?>" required></div>
                            <div class="mb-3"><label class="form-label">Durée</label><input type="text" name="duree" class="form-control" value="<?= $edit_formation['duree'] ?? ''; ?>" required></div>
                            <div class="mb-3"><label class="form-label">Prix (DH)</label><input type="number" step="0.01" name="prix" class="form-control" value="<?= $edit_formation['prix'] ?? ''; ?>" required></div>
                            <button type="submit" class="btn <?= $edit_formation ? 'btn-warning' : 'btn-success'; ?> w-100"><?= $edit_formation ? "Modifier" : "Ajouter"; ?></button>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card shadow-sm p-4">
                        <h4 class="mb-3 text-secondary">Liste des Formations</h4>
                        <table class="table table-striped">
                            <thead class="table-dark"><tr><th>ID</th><th>Titre</th><th>Durée</th><th>Prix</th><th>Actions</th></tr></thead>
                            <tbody>
                                <?php foreach ($formations as $f): ?>
                                <tr>
                                    <td><?= $f['id_formation']; ?></td>
                                    <td><?= htmlspecialchars($f['titre']); ?></td>
                                    <td><?= htmlspecialchars($f['duree']); ?></td>
                                    <td><?= htmlspecialchars($f['prix']); ?> DH</td>
                                    <td>
                                        <a href="dashboard.php?tab=formations&edit_f=<?= $f['id_formation']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                                        <a href="../controllers/formationController.php?action=delete&id=<?= $f['id_formation']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($active_tab === 'inscriptions'): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm p-4">
                        <h4 class="text-primary mb-3">Inscrire un Stagiaire</h4>
                        <form action="dashboard.php" method="POST">
                            <input type="hidden" name="action" value="inscrire">
                            
                            <div class="mb-3">
                                <label class="form-label">Sélectionner un Stagiaire</label>
                                <select name="id_stagiaire" class="form-select" required>
                                    <option value="">-- Choisir --</option>
                                    <?php foreach($stagiaires as $s): ?>
                                        <option value="<?= $s['id_stagiaire']; ?>"><?= htmlspecialchars($s['nom'].' '.$s['prenom']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sélectionner une Formation</label>
                                <select name="id_formation" class="form-select" required>
                                    <option value="">-- Choisir --</option>
                                    <?php foreach($formations as $f): ?>
                                        <option value="<?= $f['id_formation']; ?>"><?= htmlspecialchars($f['titre']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Inscrire le stagiaire</button>
                        </form>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card shadow-sm p-4">
                        <h4 class="mb-3 text-secondary">Historique des Inscriptions</h4>
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Stagiaire</th>
                                    <th>Formation</th>
                                    <th>Date d'inscription</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($inscriptions) === 0): ?>
                                    <tr><td colspan="3" class="text-center text-muted">Aucune inscription enregistrée.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($inscriptions as $i): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($i['nom'] . ' ' . $i['prenom']); ?></td>
                                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($i['titre']); ?></span></td>
                                        <td><?= $i['date_inscription']; ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>