<?php
// تسجيل متدرب في دورة
function inscrireStagiaire($pdo, $id_stagiaire, $id_formation) {
    $sql = "INSERT INTO inscriptions (id_stagiaire, id_formation) VALUES (:id_stagiaire, :id_formation)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':id_stagiaire' => $id_stagiaire,
        ':id_formation' => $id_formation
    ]);
}

// جلب لائحة التسجيلات كاملة
function getAllInscriptions($pdo) {
    $sql = "SELECT i.id_inscription, s.nom, s.prenom, f.titre, i.date_inscription 
            FROM inscriptions i
            JOIN stagiaires s ON i.id_stagiaire = s.id_stagiaire
            JOIN formations f ON i.id_formation = f.id_formation
            ORDER BY i.date_inscription DESC";
    return $pdo->query($sql)->fetchAll();
}
?>