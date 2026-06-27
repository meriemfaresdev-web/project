<?php
// جلب جميع المتدربين
function getAllStagiaires($pdo) {
    $stmt = $pdo->query("SELECT * FROM stagiaires ORDER BY id_stagiaire DESC");
    return $stmt->fetchAll();
}

// إضافة متدرب جديد
function addStagiaire($pdo, $nom, $prenom, $email, $telephone) {
    $sql = "INSERT INTO stagiaires (nom, prenom, email, telephone) VALUES (:nom, :prenom, :email, :telephone)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':telephone' => $telephone
    ]);
}

// جلب متدرب واحد بواسطة ID (حتاجوها في التعديل)
function getStagiaireById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM stagiaires WHERE id_stagiaire = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch();
}

// تعديل معلومات متدرب
function updateStagiaire($pdo, $id, $nom, $prenom, $email, $telephone) {
    $sql = "UPDATE stagiaires SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone WHERE id_stagiaire = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':id' => $id,
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':telephone' => $telephone
    ]);
}

// حذف متدرب
function deleteStagiaire($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM stagiaires WHERE id_stagiaire = :id");
    return $stmt->execute([':id' => $id]);
}
?>