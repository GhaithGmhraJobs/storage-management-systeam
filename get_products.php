<?php

include 'db.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM tires";

$stmt = $pdo->query($sql);

$tires = $stmt->fetchALL(PDO::FETCH_ASSOC);
echo json_encode($tires);
?>