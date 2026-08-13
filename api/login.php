<?php
session_start();
header('Content-Type: application/json');

// API Key validation
$api_key = 'BHARAT_2026_API_K3Y_1ND3P3ND3NC3_D4Y';

// Get Authorization header
$headers = getallheaders();
$auth_header = isset($headers['Authorization']) ? $headers['Authorization'] : '';

// Check if Authorization header is present and valid
if (!preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Unauthorized: API key is required in bearer',
        'hint' => 'Header Required'
    ]);
    exit;
}

$provided_key = trim($matches[1]);

if ($provided_key !== $api_key) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid API key'
    ]);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($input['email']) || !isset($input['password'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required parameters'
    ]);
    exit;
}

$email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
$password = $input['password'];

// Load users
$users_file = '../data/users.json';
if (!file_exists($users_file)) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid credentials',
        'hint' => 'Register first at /api/register.php'
    ]);
    exit;
}

$users = json_decode(file_get_contents($users_file), true);

// Find user
$user_found = null;
foreach ($users as $user) {
    if ($user['email'] === $email) {
        $user_found = $user;
        break;
    }
}

// Verify credentials
if (!$user_found || !password_verify($password, $user_found['password'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid credentials'
    ]);
    exit;
}

// Create session
$_SESSION['user_id'] = $user_found['id'];
$_SESSION['email'] = $user_found['email'];
$_SESSION['is_admin'] = $user_found['is_admin'];
$_SESSION['logged_in'] = true;

// Success response
http_response_code(200);
echo json_encode([
    'status' => 'success',
    'message' => 'Authentication successful',
    'user' => [
        'id' => $user_found['id'],
        'email' => $user_found['email'],
        'is_admin' => $user_found['is_admin']
    ],
    'redirect' => '/dashboard.php',
    'session_id' => session_id()
]);
?>