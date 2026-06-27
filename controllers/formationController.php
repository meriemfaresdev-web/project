<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../views/login.php');
    exit();
}

require_once '../config/database.php';
require_once '../models/formation.php';

// 1. عملية الإضافة (Ajouter)
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $titre = trim($_POST['titre']);
    $duree = trim($_POST['duree']);
    $prix = floatval($_POST['prix']);

    if (!empty($titre) && !empty($duree) && !empty($prix)) {
        addFormation($pdo, $titre, $duree, $prix);
    }
    header('Location: ../views/dashboard.php?tab=formations');
    exit();
}

// 2. عملية الحذف (Supprimer)
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    deleteFormation($pdo, $id);
    header('Location: ../views/dashboard.php?tab=formations');
    exit();
}

// 3. عملية التعديل (Modifier)
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id_formation']);
    $titre = trim($_POST['titre']);
    $duree = trim($_POST['duree']);
    $prix = floatval($_POST['prix']);

    if (!empty($id) && !empty($titre) && !empty($duree) && !empty($prix)) {
        updateFormation($pdo, $id, $titre, $duree, $prix);
    }
    header('Location: ../views/dashboard.php?tab=formations');
    exit();
}
?>