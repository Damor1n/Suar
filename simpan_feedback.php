<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$json_input = file_get_contents('php://input');
$feedback_data = json_decode($json_input, true);

if (!$feedback_data || empty($feedback_data['feedback'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Data feedback tidak lengkap']);
    exit;
}


$feedback_file = 'feedback_database.json';

$feedback_list = [];
if (file_exists($feedback_file)) {
    $existing_feedback = file_get_contents($feedback_file);
    $feedback_list = json_decode($existing_feedback, true) ?? [];
}

$feedback_list[] = $feedback_data;

if (file_put_contents($feedback_file, json_encode($feedback_list, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode([
        'success' => true,
        'message' => 'Feedback berhasil disimpan',
        'timestamp' => $feedback_data['waktu_feedback']
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan feedback ke file']);
}
?>
