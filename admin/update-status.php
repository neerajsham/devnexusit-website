<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../db.php";
require_once "auth.php";

// Check if user is logged in
if(!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: login.php");
    exit();
}

// Handle status update
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form data - support both 'update_id' and 'id' parameter names
    $id = isset($_POST['update_id']) ? intval($_POST['update_id']) : (isset($_POST['id']) ? intval($_POST['id']) : 0);
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $note = isset($_POST['note']) ? trim($_POST['note']) : '';
    
    // Debug logging
    error_log("=== UPDATE STATUS DEBUG ===");
    error_log("ID: $id");
    error_log("Status: $status");
    error_log("Note: $note");
    error_log("POST data: " . print_r($_POST, true));
    
    // Validate ID
    if($id <= 0) {
        $_SESSION['error_message'] = "Invalid enquiry ID";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php'));
        exit();
    }
    
    // Validate status
    $allowed_status = ['pending', 'confirmed', 'remaining', 'reminder'];
    if(!in_array($status, $allowed_status)) {
        $_SESSION['error_message'] = "Invalid status value: " . $status;
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php'));
        exit();
    }
    
    // Check if enquiry exists
    $check_query = "SELECT * FROM enquiries WHERE id = $id";
    $check_result = mysqli_query($conn, $check_query);
    
    if(!$check_result || mysqli_num_rows($check_result) == 0) {
        $_SESSION['error_message'] = "Enquiry not found with ID: $id";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php'));
        exit();
    }
    
    // For reminder status, note is required
    if($status == 'reminder' && empty($note)) {
        $_SESSION['error_message'] = "Reminder note is required when status is set to Reminder";
        header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'dashboard.php'));
        exit();
    }
    
    // Build and execute update query
    if($status == 'reminder') {
        $note_escaped = mysqli_real_escape_string($conn, $note);
        $query = "UPDATE enquiries SET status = '$status', reminder_note = '$note_escaped', updated_at = NOW() WHERE id = $id";
    } else {
        $query = "UPDATE enquiries SET status = '$status', updated_at = NOW() WHERE id = $id";
    }
    
    // Execute query
    if(mysqli_query($conn, $query)) {
        $_SESSION['success_message'] = "Status updated successfully to " . ucfirst($status);
        
        // If this was a reminder, also log the note
        if($status == 'reminder') {
            $_SESSION['success_message'] .= " with reminder note saved.";
        }
        
        // Verify the update worked
        $verify_query = "SELECT status FROM enquiries WHERE id = $id";
        $verify_result = mysqli_query($conn, $verify_query);
        if($verify_result) {
            $row = mysqli_fetch_assoc($verify_result);
            error_log("Verified new status: " . $row['status']);
        }
    } else {
        $_SESSION['error_message'] = "Database error: " . mysqli_error($conn);
        error_log("SQL Error: " . mysqli_error($conn));
        error_log("Query: " . $query);
    }
    
    // Redirect back to the referring page
    $redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "dashboard.php";
    header("Location: " . $redirect_url);
    exit();
} else {
    // If someone tries to access this file directly via GET
    header("Location: dashboard.php");
    exit();
}
?>