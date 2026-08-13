<?php
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
        'message' => 'Invalid API key',
        'hint' => 'Check out archived urls'
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
        'message' => 'Missing required parameters',
        'required' => ['email', 'password'],
    ]);
    exit;
}

$email = filter_var($input['email'], FILTER_SANITIZE_EMAIL);
$password = $input['password'];

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid email format'
    ]);
    exit;
}

// Check if users file exists, create if not
$users_file = '../data/users.json';
if (!file_exists('../data')) {
    mkdir('../data', 0755, true);
}

$users = [];
if (file_exists($users_file)) {
    $users = json_decode(file_get_contents($users_file), true);
}

// Check if user already exists
foreach ($users as $user) {
    if ($user['email'] === $email) {
        http_response_code(409);
        echo json_encode([
            'status' => 'error',
            'message' => 'Operative already registered with this email'
        ]);
        exit;
    }
}

// Check for mass assignment vulnerability - is_admin parameter
$is_admin = false;
if (isset($input['is_admin']) && $input['is_admin'] === true) {
    $is_admin = true;
}

// Create new user
$new_user = [
    'id' => count($users) + 1,
    'email' => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT),
    'is_admin' => $is_admin,
    'created_at' => date('Y-m-d H:i:s')
];

$users[] = $new_user;

// Save users
file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));

// Return response (showing is_admin in response - this is the hint!)
http_response_code(201);
echo json_encode([
    'status' => 'success',
    'message' => 'Operative registered successfully',
    'user' => [
        'id' => $new_user['id'],
        'email' => $new_user['email'],
        'is_admin' => $new_user['is_admin'], // HINT: This field exists!
        'created_at' => $new_user['created_at']
    ],
]);
?>