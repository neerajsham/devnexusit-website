<?php
// 🔐 Database Credentials (Hostinger)
$host = "localhost";
$user = "u979076758_Devnexusit_db";   // ⚠️ apna DB user daalo
$pass = "Devnexusit_db@123";         // ⚠️ apna password daalo
$db   = "u979076758_Devnexusit_db";

// 🚀 Create Connection
$conn = new mysqli($host, $user, $pass, $db);

// ❗ Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// 🔧 Optional: Set Charset (important for UTF-8)
$conn->set_charset("utf8mb4");
?>