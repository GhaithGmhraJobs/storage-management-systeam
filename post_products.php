<?php

include 'db.php';

header('Content-Type: applcation/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo json_decode(['error' => 'Only POST method allowed']);
    exit;
}


$json = file_get_contents('php://input');
$data = json_decode($json, true);

try {
    $sql = "INSERT INTO tires (tires_size, tires_count, tires_price, tires_brand) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$data['tires_size'], $data['tires_count'], $data['tires_price'], $data['tires_brand']]);
    $newId = $pdo->lastInsertId();

     http_response_code(201); 
    echo json_encode([
        'success' => true,
        'id' => $newId,
        'message' => 'data updated successfully'
    ]);
} catch(PDOException $e){
    http_response_code(500);
    echo json_decode(['error' => 'Database error: ' . $e->getMessage()]);

}
?>