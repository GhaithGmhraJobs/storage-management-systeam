<?php 

include 'db.php';

header('Content-type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== "POST"){
    http_response_code(405);
    echo json_encode(['error' => 'Only POST method allowedf']);
    exit;
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['product_id']) || !isset($data['action']) || !isset($data['amount'])) {
    http_response_code(400);
    echo json_encode(['error' => 'product_id, action, and amount are required']);
    exit;
}

try {

    $productId = $data['product_id'];  
    $action = $data['action'];         
    $amount = (int)$data['amount'];

    if ($action !== 'add' && $action !== 'subtract') {
        http_response_code(400);
        echo json_encode(['error' => 'action must be "add" or "subtract"']);
        exit;
    }

    if ($amount <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'amount must be positive number']);
        exit;
    }

    if ($action === 'add'){
        $sql = "UPDATE tires SET tires_count = tires_count + ? WHERE idtires = ?";
    } else {
        $sql = "UPDATE tires SET tires_count = tires_count - ? WHERE idtires = ?";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$amount, $productId]);
     echo json_encode([
        'success' => true,
        'message' => "Product {$action} successful"
    ]);

} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>