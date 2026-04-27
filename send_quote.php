<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "db.php";
header('Content-Type: application/json');

// Allow only POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

// 🔑 Google reCAPTCHA Secret Key
$recaptcha_secret = "6LdU-6osAAAAAEN5ZOWvPUOaJk8TWIKQ73uKp7K8";
$captcha = $_POST['g-recaptcha-response'] ?? '';

if (!$captcha) {
    echo json_encode(["success" => false, "message" => "Please verify reCAPTCHA"]);
    exit;
}

// ✅ reCAPTCHA verification using cURL (more stable)
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

// 🧹 Sanitize Inputs
$name      = trim(htmlspecialchars($_POST['name'] ?? ''));
$email     = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
$phone     = preg_replace('/[^0-9]/', '', $_POST['phone'] ?? '');
$subject   = trim(htmlspecialchars($_POST['subject'] ?? ''));
$message   = trim(htmlspecialchars($_POST['message'] ?? ''));
$form_type = $_POST['form_type'] ?? 'unknown';
$agree     = isset($_POST['agree']);

// ✅ Validation
$errors = [];

if (empty($name)) $errors[] = "Name is required";
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
if (empty($phone) || strlen($phone) != 10) $errors[] = "Valid 10-digit phone number is required";
if (empty($subject)) $errors[] = "Service selection is required";
if (empty($message)) $errors[] = "Message is required";
if (!$agree) $errors[] = "You must agree to Terms & Conditions";

if (!empty($errors)) {
    echo json_encode([
        "success" => false,
        "message" => implode(", ", $errors)
    ]);
    exit;
}

# ======================================================
# 🗄️ SAVE TO DATABASE
# ======================================================

try {

    $stmt = $conn->prepare("
        INSERT INTO enquiries 
        (name, email, phone, service, message, form_type)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        throw new Exception($conn->error);
    }

    $stmt->bind_param(
        "ssssss",
        $name,
        $email,
        $phone,
        $subject,   // ✅ FIXED HERE
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

# ======================================================
# 📧 EMAIL CONFIG
# ======================================================

$to = "info@devnexusit.com";

$email_subject = "New Quote Request: $subject";

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";

$email_body = "
<html>
<body>
<h2>New Quote Request</h2>

<p><b>Name:</b> $name</p>
<p><b>Email:</b> $email</p>
<p><b>Phone:</b> $phone</p>
<p><b>Service:</b> $subject</p>
<p><b>Message:</b><br>" . nl2br($message) . "</p>

</body>
</html>
";

if (mail($to, $email_subject, $email_body, $headers)) {
    echo json_encode([
        "success" => true,
        "message" => "Quote request sent successfully!"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Email sending failed"
    ]);
}
?>