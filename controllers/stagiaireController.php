<?php
session_start();
// حماية الصفحة: إلى مكانش الأدمين مكونكطي يرجع لـ Login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

require_once '../config/database.php';
require_once '../models/stagiaire.php';

// 1. عملية الإضافة (Ajouter)
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($telephone)) {
        addStagiaire($pdo, $nom, $prenom, $email, $telephone);
    }
    header('Location: ../views/dashboard.php?tab=stagiaires');
    exit();
}

// 2. عملية الحذف (Supprimer)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    deleteStagiaire($pdo, $id);
    header('Location: ../views/dashboard.php?tab=stagiaires');
    exit();
}

// 3. عملية التعديل (Modifier)
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id_stagiaire']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);

    if (!empty($id) && !empty($nom) && !empty($prenom) && !empty($email) && !empty($telephone)) {
        updateStagiaire($pdo, $id, $nom, $prenom, $email, $telephone);
    }
    header('Location: ../views/dashboard.php?tab=stagiaires');
    exit();
}
?>