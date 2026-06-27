<?php
// جلب جميع التكوينات
function getAllFormations($pdo) {
    $stmt = $pdo->query("SELECT * FROM formations ORDER BY id_formation DESC");
    return $stmt->fetchAll();
}

// إضافة تكوين جديد
function addFormation($pdo, $titre, $duree, $prix) {
    $sql = "INSERT INTO formations (titre, duree, prix) VALUES (:titre, :duree, :prix)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':titre' => $titre,
        ':duree' => $duree,
        ':prix' => $prix
    ]);
}

// جلب تكوين واحد بواسطة ID
function getFormationById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM formations WHERE id_formation = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

// تعديل تكوين
function updateFormation($pdo, $id, $titre, $duree, $prix) {
    $sql = "UPDATE formations SET titre = :titre, duree = :duree, prix = :prix WHERE id_formation = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':id' => $id,
        ':titre' => $titre,
        ':duree' => $duree,
        ':prix' => $prix
    ]);
}

// حذف تكوين
function deleteFormation($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM formations WHERE id_formation = :id");
    return $stmt->execute([':id' => $id]);
}
?>