<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "db.php"; // ✅ DB connection
header('Content-Type: application/json');

// Allow only POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

// 🔑 Google reCAPTCHA Secret Key
$recaptcha_secret = "6LdU-6osAAAAAEN5ZOWvPUOaJk8TWIKQ73uKp7K8";

// Verify reCAPTCHA
$captcha = $_POST['g-recaptcha-response'] ?? '';
if (!$captcha) {
    echo json_encode(["success" => false, "message" => "Please verify reCAPTCHA"]);
    exit;
}

// ✅ Verify using cURL (better than file_get_contents)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'secret' => $recaptcha_secret,
    'response' => $captcha
]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$responseKeys = json_decode($response, true);

if (empty($responseKeys["success"])) {
    echo json_encode(["success" => false, "message" => "reCAPTCHA verification failed"]);
    exit;
}

// ================= SANITIZE INPUT =================
$name    = trim(htmlspecialchars($_POST['name'] ?? ''));
$phone   = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
$email   = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
$subject = trim(htmlspecialchars($_POST['subject'] ?? ''));
$message = trim(htmlspecialchars($_POST['message'] ?? ''));
$form_type = $_POST['form_type'] ?? 'contact_form';

// Services (checkbox array)
$services = $_POST['services'] ?? [];
$services_list = '';
if (!empty($services)) {
    $services_list = implode(', ', array_map('htmlspecialchars', $services));
}

// ================= VALIDATION =================
$errors = [];

if (empty($name)) $errors[] = "Name is required";
if (empty($phone) || strlen($phone) != 10) $errors[] = "Valid 10-digit phone number required";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required";
if (empty($services)) $errors[] = "Please select at least one service";

if (!empty($errors)) {
    echo json_encode([
        "success" => false,
        "message" => implode(", ", $errors)
    ]);
    exit;
}

// ================= SAVE TO DATABASE =================
try {

    $stmt = $conn->prepare("
        INSERT INTO enquiries 
        (name, email, phone, service, message, form_type, status) 
        VALUES (?, ?, ?, ?, ?, ?, 'pending')
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param(
        "ssssss",
        $name,
        $email,
        $phone,
        $services_list, // ✅ services saved here
        $message,
        $form_type
    );

    if (!$stmt->execute()) {
        throw new Exception($stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {

    error_log("DB Insert Error: " . $e->getMessage());

    echo json_encode([
        "success" => false,
        "message" => "Database error"
    ]);
    exit;
}

// ================= EMAIL =================
$to = "info@devnexusit.com";
$email_subject = "New Contact Message: " . ($subject ?: "General Inquiry");

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";

$email_body = "
<h2>New Contact Message</h2>
<p><b>Name:</b> $name</p>
<p><b>Email:</b> $email</p>
<p><b>Phone:</b> $phone</p>
<p><b>Services:</b> $services_list</p>
<p><b>Message:</b><br>" . nl2br($message) . "</p>
";

// Send email
if (mail($to, $email_subject, $email_body, $headers)) {
    echo json_encode([
        "success" => true,
        "message" => "Message sent successfully!"
    ]);
} else {
    echo json_encode([
        "success" => true,
        "message" => "Saved successfully, but email failed"
    ]);
}
?>