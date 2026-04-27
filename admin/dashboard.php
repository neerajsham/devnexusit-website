<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../db.php";
require_once "auth.php";

// ================= HANDLE STATUS UPDATE (FIXED) =================
if(isset($_POST['update_id']) && isset($_POST['status'])) {
    $update_id = intval($_POST['update_id']);
    $status = $_POST['status'];
    $note = isset($_POST['note']) ? trim($_POST['note']) : '';
    
    $allowed_status = ['pending', 'confirmed', 'remaining', 'reminder'];
    if(in_array($status, $allowed_status)) {
        if($status == 'reminder' && empty($note)) {
            $_SESSION['error_message'] = "Reminder note is required for reminder status";
        } else {
            $update_query = "UPDATE enquiries SET status = ?, admin_notes = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ssi", $status, $note, $update_id);
            if($stmt->execute()) {
                if($stmt->affected_rows >= 0) {
                    $_SESSION['success_message'] = "Status updated to " . ucfirst($status) . " successfully!";
                } else {
                    $_SESSION['error_message'] = "No record found with ID: " . $update_id;
                }
            } else {
                $_SESSION['error_message'] = "Failed to update status: " . $conn->error;
            }
            $stmt->close();
        }
    } else {
        $_SESSION['error_message'] = "Invalid status value";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// ================= HANDLE DELETE ENQUIRY =================
if(isset($_POST['delete_id']) && isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
    $delete_id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM enquiries WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if($stmt->execute()) {
        $_SESSION['success_message'] = "Enquiry deleted successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to delete enquiry.";
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// ================= DASHBOARD COUNTS =================
$totalCount      = $conn->query("SELECT COUNT(*) as total FROM enquiries")->fetch_assoc()['total'];
$pendingCount    = $conn->query("SELECT COUNT(*) as pending FROM enquiries WHERE status = 'pending'")->fetch_assoc()['pending'];
$confirmedCount  = $conn->query("SELECT COUNT(*) as confirmed FROM enquiries WHERE status = 'confirmed'")->fetch_assoc()['confirmed'];
$remainingCount  = $conn->query("SELECT COUNT(*) as remaining FROM enquiries WHERE status = 'remaining'")->fetch_assoc()['remaining'];
$reminderCount   = $conn->query("SELECT COUNT(*) as reminder FROM enquiries WHERE status = 'reminder'")->fetch_assoc()['reminder'];

// ================= FORM TYPE COUNTS =================
$contactCount = $conn->query("SELECT COUNT(*) as count FROM enquiries WHERE form_type = 'contact_form' OR form_type IS NULL")->fetch_assoc()['count'];
$consultationCount = $conn->query("SELECT COUNT(*) as count FROM enquiries WHERE form_type IN ('consult_form', 'consultation_form')")->fetch_assoc()['count'];
$modalCount = $conn->query("SELECT COUNT(*) as count FROM enquiries WHERE form_type = 'modal_form'")->fetch_assoc()['count'];

// ================= MAIN DATA QUERIES =================
$recentEnquiries    = $conn->query("SELECT * FROM enquiries ORDER BY id DESC LIMIT 6");
$allEnquiries       = $conn->query("SELECT * FROM enquiries ORDER BY id DESC");
$contactForms       = $conn->query("SELECT * FROM enquiries WHERE form_type = 'contact_form' OR form_type IS NULL ORDER BY id DESC");
$consultationForms  = $conn->query("SELECT * FROM enquiries WHERE form_type IN ('consult_form', 'consultation_form') ORDER BY id DESC");
$modalForms         = $conn->query("SELECT * FROM enquiries WHERE form_type = 'modal_form' ORDER BY id DESC");

// ================= CHARTS DATA: Last 7 days enquiries =================
$chartData = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $count = $conn->query("SELECT COUNT(*) as cnt FROM enquiries WHERE DATE(created_at) = '$date'")->fetch_assoc()['cnt'];
    $chartData['labels'][] = date('d M', strtotime($date));
    $chartData['counts'][] = $count;
}
$chartLabelsJson = json_encode($chartData['labels']);
$chartCountsJson = json_encode($chartData['counts']);

// ================= HELPER FUNCTION =================
function getFormTypeBadge($formType) {
    if($formType == 'contact_form' || $formType == null) {
        return ['contact', 'Contact Form'];
    } elseif($formType == 'consultation_form' || $formType == 'consult_form') {
        return ['consultation', 'Consultation Form'];
    } elseif($formType == 'modal_form') {
        return ['modal', 'Modal Form'];
    } else {
        return ['contact', ucfirst(str_replace('_', ' ', $formType))];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevNexus IT Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * { font-family: 'Montserrat', sans-serif; }
        body { background: #fdfdfd; margin: 0; padding: 0; }

        /* Sidebar */
        .sidebar {
            position: fixed; left: 0; top: 0; height: 100%; width: 280px;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white; transition: all 0.3s; z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1); overflow-y: auto;
        }
        .sidebar-header { padding: 25px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px; }
        .sidebar-header h4 { margin: 0; font-weight: 700; font-size: 1.5rem; letter-spacing: 1px; }
        .sidebar-header p  { margin: 5px 0 0; font-size: 0.75rem; opacity: 0.7; }
        .sidebar-header img { width: 50%; }
        .nav-tab {
            padding: 12px 25px; margin: 5px 15px; border-radius: 12px; cursor: pointer;
            transition: all 0.3s; display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.8); position: relative;
        }
        .nav-tab i { width: 24px; font-size: 1.2rem; }
        .nav-tab:hover { background: rgba(255,255,255,0.1); color: white; transform: translateX(5px); }
        .nav-tab.active { background: linear-gradient(135deg, #0f3460 0%, #1a4a7a 100%); color: white; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .nav-tab .badge-count { position: absolute; right: 25px; background: rgba(255,255,255,0.2); border-radius: 20px; padding: 2px 8px; font-size: 0.7rem; }

        /* Main Content */
        .main-content { margin-left: 280px; padding: 25px 30px; min-height: 100vh; }
        .top-bar {
            background: white; border-radius: 15px; padding: 15px 25px; margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center;
        }
        .page-title { font-size: 1.5rem; font-weight: 700; margin: 0; color: #1a1a2e; }

        /* Stat Cards - Clickable */
        .stat-card {
            background: white; border-radius: 20px; padding: 20px; margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; border-left: 5px solid;
            cursor: pointer;
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.12); }
        .stat-card .stat-icon i { color: #ddd; font-size: 25px; }
        .stat-card .stat-number { font-size: 2rem; font-weight: 800; margin: 10px 0 5px; }
        .stat-card .stat-label  { color: #6c757d; font-weight: 500; margin: 0; }

        /* Chart Card */
        .chart-card {
            background: white; border-radius: 20px; padding: 20px; margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .chart-card h5 { font-weight: 700; margin-bottom: 20px; color: #1a1a2e; }

        .table tr:nth-of-type(odd) { --bs-table-bg-type: #eff4fa; }
        tbody, td, tfoot, th, thead, tr { font-size: 14px !important; padding: 22px 19px !important; }
        
        /* Table */
        .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .table { margin-bottom: 0; }
        .table thead th { background: #f8f9fa; border-bottom: 2px solid #e9ecef; font-weight: 600; color: #495057; font-size: 0.85rem; }
        .row-pending   { background-color: transparent; }
        .row-confirmed { background-color: #d4edda !important; }
        .row-remaining { background-color: #ffe5d0 !important; }
        .row-reminder  { background-color: #d1ecf1 !important; }
        .badge { padding: 6px 12px; border-radius: 20px; font-weight: 500; }
        .badge-pending      { background: #ffc107; color: #856404; }
        .badge-confirmed    { background: #28a745; color: white; }
        .badge-remaining    { background: #fd7e14; color: white; }
        .badge-reminder     { background: #17a2b8; color: white; }
        .badge-contact      { background: #6f42c1; color: white; }
        .badge-consultation { background: #fd7e14; color: white; }
        .badge-modal        { background: #20c997; color: white; }

        .search-box { position: relative; margin-bottom: 20px; }
        .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #6c757d; }
        .search-box input { padding-left: 45px; border-radius: 12px; border: 1px solid #e9ecef; height: 48px; }
        .btn-sm { border-radius: 10px; padding: 5px 12px; margin: 0 2px; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-delete:hover { background: #c82333; color: white; }

        /* Tabs */
        .tab-pane { display: none; animation: fadeIn 0.4s; }
        .tab-pane.active-tab { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .site-url-btn {
            background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 12px;
            padding: 8px 20px; text-decoration: none; color: #1a1a2e; font-weight: 500; transition: all 0.3s;
        }
        .site-url-btn:hover { background: #1a1a2e; color: white; border-color: #1a1a2e; }
        .message-preview { max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .action-buttons { display: flex; gap: 5px; }

        /* Alerts */
        .alert-custom {
            position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;
            animation: slideIn 0.5s;
        }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* View All Button */
        .view-all-btn {
            background: linear-gradient(135deg, #0f3460, #1a4a7a);
            color: white; border: none; border-radius: 12px;
            padding: 8px 20px; font-weight: 600; font-size: 0.85rem;
            cursor: pointer; transition: all 0.3s; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .view-all-btn:hover { opacity: 0.9; transform: translateY(-1px); color: white; }

        /* Pagination */
        .pagination-wrapper { display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 20px; flex-wrap: wrap; }
        .page-btn {
            width: 36px; height: 36px; border-radius: 10px; border: 1px solid #e9ecef;
            background: white; cursor: pointer; font-weight: 600; font-size: 0.85rem;
            transition: all 0.2s; display: flex; align-items: center; justify-content: center;
            color: #495057;
        }
        .page-btn:hover { background: #0f3460; color: white; border-color: #0f3460; }
        .page-btn.active { background: linear-gradient(135deg, #0f3460, #1a4a7a); color: white; border-color: #0f3460; }
        .page-btn.disabled { opacity: 0.4; cursor: not-allowed; }
        .page-info { font-size: 0.82rem; color: #6c757d; font-weight: 500; }

        /* Status Filter Bar */
        .status-filter-bar {
            display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;
        }
        .filter-chip {
            padding: 6px 18px; border-radius: 30px; background: #f1f3f5; cursor: pointer;
            font-size: 0.85rem; font-weight: 600; transition: all 0.2s;
        }
        .filter-chip:hover, .filter-chip.active {
            background: #0f3460; color: white;
        }
        .filter-chip i { margin-right: 6px; }

        @media (max-width: 992px) {
            .stat-card .stat-number { font-size: 1.2rem; margin: 0px 0 3px; }
            .main-content { padding: 19px 18px; }
            .stat-card { padding: 14px 10px; margin-bottom: 15px; height: -webkit-fill-available; }
            .sidebar a span { display: none; }
            .table-container h5 { font-size: 17px; }
            .page-title { font-size: 1rem; }
            .sidebar-header img { width: 100%; }
            .sidebar { width: 80px; }
            .sidebar-header h4, .sidebar-header p, .nav-tab span { display: none; }
            .nav-tab { justify-content: center; padding: 12px; margin: 5px 10px; }
            .nav-tab i { margin: 0; font-size: 1.4rem; }
            .main-content { margin-left: 80px; }
        }
    </style>
</head>
<body>

<!-- Alert Messages -->
<?php if(isset($_SESSION['success_message'])): ?>
<div class="alert alert-success alert-custom" id="alertMessage">
    <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($_SESSION['success_message']); unset($_SESSION['success_message']); ?>
</div>
<?php endif; ?>
<?php if(isset($_SESSION['error_message'])): ?>
<div class="alert alert-danger alert-custom" id="alertMessage">
    <i class="fas fa-exclamation-circle me-2"></i> <?= htmlspecialchars($_SESSION['error_message']); unset($_SESSION['error_message']); ?>
</div>
<?php endif; ?>

<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="https://devnexusit.com/images/favdev.webp" alt="Logo">
        <h4>DevNexus IT</h4>
        <p>Dashboard Manager</p>
    </div>
    <div class="nav-tab active" data-tab="dashboard">
        <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
    </div>
    <div class="nav-tab" data-tab="enquiries">
        <i class="fas fa-database"></i><span>All Enquiries</span>
        <span class="badge-count"><?= $totalCount ?></span>
    </div>
    <div class="nav-tab" data-tab="contact">
        <i class="fas fa-envelope"></i><span>Contact Form</span>
        <span class="badge-count"><?= $contactCount ?></span>
    </div>
    <div class="nav-tab" data-tab="consultation">
        <i class="fas fa-calendar-check"></i><span>Consultation Form</span>
        <span class="badge-count"><?= $consultationCount ?></span>
    </div>
    <div class="nav-tab" data-tab="modal">
        <i class="fas fa-window-maximize"></i><span>Modal Form</span>
        <span class="badge-count"><?= $modalCount ?></span>
    </div>
    <div style="position: absolute; bottom: 30px; left: 0; right: 0; padding: 0 20px;">
        <hr style="border-color: rgba(255,255,255,0.1);">
        <a href="logout.php" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 12px; padding: 10px;">
            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="top-bar">
        <h3 class="page-title" id="mainPageTitle">Dashboard</h3>
        <a href="/" target="_blank" class="site-url-btn">
            <i class="fas fa-external-link-alt me-2"></i>Visit Site
        </a>
    </div>

    <!-- ==================== DASHBOARD TAB ==================== -->
    <div id="dashboard" class="tab-pane active-tab">
        <div class="row">
            <div class="col-md-3 col-6">
                <div class="stat-card" style="border-left-color: #4361ee;" data-filter="all">
                    <div class="d-flex justify-content-between align-items-start">
                        <div><div class="stat-number"><?= $totalCount ?></div><p class="stat-label">Total Enquiries</p></div>
                        <div class="stat-icon"><i class="fas fa-database"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card" style="border-left-color: #ffc107;" data-filter="pending">
                    <div class="d-flex justify-content-between align-items-start">
                        <div><div class="stat-number"><?= $pendingCount ?></div><p class="stat-label">Pending</p></div>
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card" style="border-left-color: #28a745;" data-filter="confirmed">
                    <div class="d-flex justify-content-between align-items-start">
                        <div><div class="stat-number"><?= $confirmedCount ?></div><p class="stat-label">Confirmed</p></div>
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card" style="border-left-color: #17a2b8;" data-filter="reminder">
                    <div class="d-flex justify-content-between align-items-start">
                        <div><div class="stat-number"><?= $reminderCount ?></div><p class="stat-label">Reminders</p></div>
                        <div class="stat-icon"><i class="fas fa-bell"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Real Time Chart -->
        <div class="chart-card">
            <h5><i class="fas fa-chart-line me-2"></i>Enquiries Trend (Last 7 Days)</h5>
            <canvas id="enquiryChart" height="100" style="max-height: 300px;"></canvas>
        </div>

        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Recent Enquiries <span class="text-muted fs-6 fw-normal">(Latest 6)</span></h5>
                <button class="view-all-btn" onclick="switchTab('enquiries')">
                    <i class="fas fa-th-list"></i> View All Enquiries
                </button>
            </div>
            
            <!-- Status Filter Chips for Dashboard -->
            <div class="status-filter-bar">
                <div class="filter-chip active" data-dash-filter="all">All</div>
                <div class="filter-chip" data-dash-filter="pending">Pending</div>
                <div class="filter-chip" data-dash-filter="confirmed">Confirmed</div>
                <div class="filter-chip" data-dash-filter="remaining">Remaining</div>
                <div class="filter-chip" data-dash-filter="reminder">Reminder</div>
            </div>

            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="search" class="form-control" placeholder="Search recent enquiries...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th><th>Name</th><th>Phone</th><th>Service</th>
                            <th>Form Type</th><th>Status</th><th>Created</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableData">
                        <?php 
                        $recentEnquiries->data_seek(0);
                        while($row = $recentEnquiries->fetch_assoc()):
                            $rowClass = '';
                            if($row['status'] == 'confirmed')     $rowClass = 'row-confirmed';
                            elseif($row['status'] == 'remaining') $rowClass = 'row-remaining';
                            elseif($row['status'] == 'reminder')  $rowClass = 'row-reminder';
                            [$badgeClass, $displayText] = getFormTypeBadge($row['form_type'] ?? null);
                        ?>
                        <tr class="<?= $rowClass ?>" data-status="<?= $row['status'] ?? 'pending' ?>">
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['service'] ?? 'N/A') ?></td>
                            <td><span class="badge badge-<?= $badgeClass ?>"><?= $displayText ?></span></td>
                            <td><span class="badge badge-<?= $row['status'] ?? 'pending' ?>"><?= ucfirst($row['status'] ?? 'pending') ?></span></td>
                            <td><?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $row['id'] ?>"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Update Modal -->
                        <div class="modal fade" id="updateModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Enquiry #<?= $row['id'] ?> &mdash; <?= htmlspecialchars($row['name']) ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="update_id" value="<?= $row['id'] ?>">
                                            <div class="row">
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Name</label><p><?= htmlspecialchars($row['name'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Email</label><p><?= htmlspecialchars($row['email'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Phone</label><p><?= htmlspecialchars($row['phone'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Service</label><p><?= htmlspecialchars($row['service'] ?? '') ?></p></div>
                                                <div class="col-12 mb-3"><label class="form-label fw-bold">Message</label><p><?= nl2br(htmlspecialchars($row['message'] ?? '')) ?></p></div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select status-select" data-id="<?= $row['id'] ?>">
                                                        <option value="pending"   <?= ($row['status'] ?? 'pending') == 'pending'   ? 'selected' : '' ?>>Pending</option>
                                                        <option value="confirmed" <?= ($row['status'] ?? '') == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                        <option value="remaining" <?= ($row['status'] ?? '') == 'remaining' ? 'selected' : '' ?>>Remaining</option>
                                                        <option value="reminder"  <?= ($row['status'] ?? '') == 'reminder'  ? 'selected' : '' ?>>Reminder</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3 reminder-note-field" id="reminderField<?= $row['id'] ?>" style="display: <?= ($row['status'] ?? '') == 'reminder' ? 'block' : 'none' ?>;">
                                                    <label class="form-label">Reminder / Admin Note</label>
                                                    <textarea name="note" class="form-control" rows="3" placeholder="Enter note..."><?= htmlspecialchars($row['admin_notes'] ?? '') ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="confirm_delete" value="yes">
                                            <p>Are you sure you want to delete this enquiry?</p>
                                            <p class="text-muted"><strong>Name:</strong> <?= htmlspecialchars($row['name'] ?? '') ?></p>
                                            <p class="text-muted"><strong>Email:</strong> <?= htmlspecialchars($row['email'] ?? '') ?></p>
                                            <p class="text-danger">This action cannot be undone!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php if($totalCount > 6): ?>
            <div class="mt-3 text-center">
                <small class="text-muted">Showing 6 of <?= $totalCount ?> enquiries &mdash;
                    <a href="#" class="text-primary fw-semibold" onclick="switchTab('enquiries'); return false;">View all <?= $totalCount ?> enquiries &rarr;</a>
                </small>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ==================== ALL ENQUIRIES TAB ==================== -->
    <div id="enquiries" class="tab-pane">
        <div class="table-container">
            <h5 class="mb-3"><i class="fas fa-database me-2"></i>All Enquiries &mdash; Complete List</h5>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchEnquiries" class="form-control" placeholder="Search enquiries...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Service</th><th>Form Type</th><th>Status</th><th>Created</th><th>Actions</th></tr>
                    </thead>
                    <tbody id="enquiriesTableData">
                        <?php
                        $allEnquiries->data_seek(0);
                        while($row = $allEnquiries->fetch_assoc()):
                            $rowClass = '';
                            if($row['status'] == 'confirmed')     $rowClass = 'row-confirmed';
                            elseif($row['status'] == 'remaining') $rowClass = 'row-remaining';
                            elseif($row['status'] == 'reminder')  $rowClass = 'row-reminder';
                            [$badgeClass, $displayText] = getFormTypeBadge($row['form_type'] ?? null);
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['service'] ?? 'N/A') ?></td>
                            <td><span class="badge badge-<?= $badgeClass ?>"><?= $displayText ?></span></td>
                            <td><span class="badge badge-<?= $row['status'] ?? 'pending' ?>"><?= ucfirst($row['status'] ?? 'pending') ?></span></td>
                            <td><?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#enquiryModal<?= $row['id'] ?>"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteEnquiryModal<?= $row['id'] ?>"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Enquiry Update Modal -->
                        <div class="modal fade" id="enquiryModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Enquiry #<?= $row['id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="update_id" value="<?= $row['id'] ?>">
                                            <div class="row">
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Name</label><p><?= htmlspecialchars($row['name'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Email</label><p><?= htmlspecialchars($row['email'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Phone</label><p><?= htmlspecialchars($row['phone'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Service</label><p><?= htmlspecialchars($row['service'] ?? '') ?></p></div>
                                                <div class="col-12 mb-3"><label class="form-label fw-bold">Message</label><p><?= nl2br(htmlspecialchars($row['message'] ?? '')) ?></p></div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select status-select" data-id="<?= $row['id'] ?>">
                                                        <option value="pending"   <?= ($row['status'] ?? 'pending') == 'pending'   ? 'selected' : '' ?>>Pending</option>
                                                        <option value="confirmed" <?= ($row['status'] ?? '') == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                        <option value="remaining" <?= ($row['status'] ?? '') == 'remaining' ? 'selected' : '' ?>>Remaining</option>
                                                        <option value="reminder"  <?= ($row['status'] ?? '') == 'reminder'  ? 'selected' : '' ?>>Reminder</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Admin Notes</label>
                                                    <textarea name="note" class="form-control" rows="3" placeholder="Enter note..."><?= htmlspecialchars($row['admin_notes'] ?? '') ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteEnquiryModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="confirm_delete" value="yes">
                                            <p>Are you sure you want to delete this enquiry?</p>
                                            <p class="text-muted"><strong>Name:</strong> <?= htmlspecialchars($row['name'] ?? '') ?></p>
                                            <p class="text-danger">This action cannot be undone!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div id="enquiriesPagination" class="pagination-wrapper"></div>
        </div>
    </div>

    <!-- ==================== CONTACT FORM TAB ==================== -->
    <div id="contact" class="tab-pane">
        <div class="table-container">
            <h5 class="mb-3"><i class="fas fa-envelope me-2"></i>Contact Form Submissions</h5>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchContact" class="form-control" placeholder="Search contact submissions...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Status</th><th>Date</th><th>Actions</th></tr>
                    </thead>
                    <tbody id="contactTableData">
                        <?php
                        $contactForms->data_seek(0);
                        while($row = $contactForms->fetch_assoc()):
                            $rowClass = '';
                            if($row['status'] == 'confirmed')     $rowClass = 'row-confirmed';
                            elseif($row['status'] == 'remaining') $rowClass = 'row-remaining';
                            elseif($row['status'] == 'reminder')  $rowClass = 'row-reminder';
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['phone'] ?? '') ?></td>
                            <td class="message-preview"><?= htmlspecialchars(substr($row['message'] ?? '', 0, 50)) ?>...</td>
                            <td><span class="badge badge-<?= $row['status'] ?? 'pending' ?>"><?= ucfirst($row['status'] ?? 'pending') ?></span></td>
                            <td><?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#contactModal<?= $row['id'] ?>"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteContactModal<?= $row['id'] ?>"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Contact Modal -->
                        <div class="modal fade" id="contactModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Contact Form #<?= $row['id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="update_id" value="<?= $row['id'] ?>">
                                            <div class="row">
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Name</label><p><?= htmlspecialchars($row['name'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Email</label><p><?= htmlspecialchars($row['email'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Phone</label><p><?= htmlspecialchars($row['phone'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Service</label><p><?= htmlspecialchars($row['service'] ?? '') ?></p></div>
                                                <div class="col-12 mb-3"><label class="form-label fw-bold">Message</label><div class="border p-3 rounded bg-light"><?= nl2br(htmlspecialchars($row['message'] ?? '')) ?></div></div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="pending"   <?= ($row['status'] ?? 'pending') == 'pending'   ? 'selected' : '' ?>>Pending</option>
                                                        <option value="confirmed" <?= ($row['status'] ?? '') == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                        <option value="remaining" <?= ($row['status'] ?? '') == 'remaining' ? 'selected' : '' ?>>Remaining</option>
                                                        <option value="reminder"  <?= ($row['status'] ?? '') == 'reminder'  ? 'selected' : '' ?>>Reminder</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3"><label class="form-label">Admin Notes</label><textarea name="note" class="form-control" rows="3" placeholder="Enter note..."><?= htmlspecialchars($row['admin_notes'] ?? '') ?></textarea></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteContactModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="confirm_delete" value="yes">
                                            <p>Are you sure you want to delete this contact enquiry?</p>
                                            <p class="text-muted"><strong>Name:</strong> <?= htmlspecialchars($row['name'] ?? '') ?></p>
                                            <p class="text-danger">This action cannot be undone!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div id="contactPagination" class="pagination-wrapper"></div>
        </div>
    </div>

    <!-- ==================== CONSULTATION FORM TAB ==================== -->
    <div id="consultation" class="tab-pane">
        <div class="table-container">
            <h5 class="mb-3"><i class="fas fa-calendar-check me-2"></i>Consultation Form Submissions</h5>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchConsultation" class="form-control" placeholder="Search consultation requests...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Service</th><th>Status</th><th>Date</th><th>Actions</th></tr>
                    </thead>
                    <tbody id="consultationTableData">
                        <?php if($consultationForms && mysqli_num_rows($consultationForms) > 0):
                            $consultationForms->data_seek(0);
                            while($row = $consultationForms->fetch_assoc()):
                                $rowClass = '';
                                if($row['status'] == 'confirmed')     $rowClass = 'row-confirmed';
                                elseif($row['status'] == 'remaining') $rowClass = 'row-remaining';
                                elseif($row['status'] == 'reminder')  $rowClass = 'row-reminder';
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['service'] ?? 'N/A') ?></td>
                            <td><span class="badge badge-<?= $row['status'] ?? 'pending' ?>"><?= ucfirst($row['status'] ?? 'pending') ?></span></td>
                            <td><?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#consultationModal<?= (int)$row['id'] ?>"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteConsultationModal<?= (int)$row['id'] ?>"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Consultation Modal -->
                        <div class="modal fade" id="consultationModal<?= (int)$row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Consultation #<?= $row['id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="update_id" value="<?= $row['id'] ?>">
                                            <div class="row">
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Name</label><p><?= htmlspecialchars($row['name'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Email</label><p><?= htmlspecialchars($row['email'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Phone</label><p><?= htmlspecialchars($row['phone'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Service</label><p><?= htmlspecialchars($row['service'] ?? '') ?></p></div>
                                                <div class="col-12 mb-3"><label class="form-label fw-bold">Message</label><div class="border p-3 rounded bg-light"><?= nl2br(htmlspecialchars($row['message'] ?? '')) ?></div></div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="pending"   <?= ($row['status'] ?? '') == 'pending'   ? 'selected' : '' ?>>Pending</option>
                                                        <option value="confirmed" <?= ($row['status'] ?? '') == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                        <option value="remaining" <?= ($row['status'] ?? '') == 'remaining' ? 'selected' : '' ?>>Remaining</option>
                                                        <option value="reminder"  <?= ($row['status'] ?? '') == 'reminder'  ? 'selected' : '' ?>>Reminder</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3"><label class="form-label">Admin Notes / Reminder Note</label><textarea name="note" class="form-control" rows="3" placeholder="Enter reminder note if status is Reminder..."><?= htmlspecialchars($row['admin_notes'] ?? '') ?></textarea></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteConsultationModal<?= (int)$row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="confirm_delete" value="yes">
                                            <p>Are you sure you want to delete this consultation enquiry?</p>
                                            <p class="text-muted"><strong>Name:</strong> <?= htmlspecialchars($row['name'] ?? '') ?></p>
                                            <p class="text-danger">This action cannot be undone!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile;
                        else: ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">No consultation enquiries found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div id="consultationPagination" class="pagination-wrapper"></div>
        </div>
    </div>

    <!-- ==================== MODAL FORM TAB ==================== -->
    <div id="modal" class="tab-pane">
        <div class="table-container">
            <h5 class="mb-3"><i class="fas fa-window-maximize me-2"></i>Modal Form Submissions</h5>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchModal" class="form-control" placeholder="Search modal submissions...">
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Service</th><th>Status</th><th>Date</th><th>Actions</th></tr>
                    </thead>
                    <tbody id="modalTableData">
                        <?php
                        $modalForms->data_seek(0);
                        while($row = $modalForms->fetch_assoc()):
                            $rowClass = '';
                            if($row['status'] == 'confirmed')     $rowClass = 'row-confirmed';
                            elseif($row['status'] == 'remaining') $rowClass = 'row-remaining';
                            elseif($row['status'] == 'reminder')  $rowClass = 'row-reminder';
                        ?>
                        <tr class="<?= $rowClass ?>">
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['email'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['phone'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['service'] ?? 'N/A') ?></td>
                            <td><span class="badge badge-<?= $row['status'] ?? 'pending' ?>"><?= ucfirst($row['status'] ?? 'pending') ?></span></td>
                            <td><?= !empty($row['created_at']) ? date('d M Y', strtotime($row['created_at'])) : '-' ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalFormModal<?= $row['id'] ?>"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-delete btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModalFormModal<?= $row['id'] ?>"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal Form Modal -->
                        <div class="modal fade" id="modalFormModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Modal Form #<?= $row['id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="update_id" value="<?= $row['id'] ?>">
                                            <div class="row">
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Name</label><p><?= htmlspecialchars($row['name'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Email</label><p><?= htmlspecialchars($row['email'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Phone</label><p><?= htmlspecialchars($row['phone'] ?? '') ?></p></div>
                                                <div class="col-md-6 mb-3"><label class="form-label fw-bold">Service</label><p><?= htmlspecialchars($row['service'] ?? '') ?></p></div>
                                                <div class="col-12 mb-3"><label class="form-label fw-bold">Message</label><div class="border p-3 rounded bg-light"><?= nl2br(htmlspecialchars($row['message'] ?? '')) ?></div></div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="pending"   <?= ($row['status'] ?? 'pending') == 'pending'   ? 'selected' : '' ?>>Pending</option>
                                                        <option value="confirmed" <?= ($row['status'] ?? '') == 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                                                        <option value="remaining" <?= ($row['status'] ?? '') == 'remaining' ? 'selected' : '' ?>>Remaining</option>
                                                        <option value="reminder"  <?= ($row['status'] ?? '') == 'reminder'  ? 'selected' : '' ?>>Reminder</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3"><label class="form-label">Admin Notes</label><textarea name="note" class="form-control" rows="3" placeholder="Enter note..."><?= htmlspecialchars($row['admin_notes'] ?? '') ?></textarea></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModalFormModal<?= $row['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="confirm_delete" value="yes">
                                            <p>Are you sure you want to delete this modal form submission?</p>
                                            <p class="text-muted"><strong>Name:</strong> <?= htmlspecialchars($row['name'] ?? '') ?></p>
                                            <p class="text-danger">This action cannot be undone!</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <div id="modalPagination" class="pagination-wrapper"></div>
        </div>
    </div>

</div><!-- /main-content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ===================== CHART INITIALIZATION =====================
    const ctx = document.getElementById('enquiryChart').getContext('2d');
    const chartLabels = <?= $chartLabelsJson ?>;
    const chartCounts = <?= $chartCountsJson ?>;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Enquiries',
                data: chartCounts,
                borderColor: '#0f3460',
                backgroundColor: 'rgba(15, 52, 96, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#1a4a7a',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top', labels: { font: { family: 'Montserrat', size: 12 } } },
                tooltip: { backgroundColor: '#1a1a2e', titleFont: { family: 'Montserrat' }, bodyFont: { family: 'Montserrat' } }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: '#e9ecef' }, title: { display: true, text: 'Number of Enquiries', font: { family: 'Montserrat' } } },
                x: { grid: { display: false }, title: { display: true, text: 'Date', font: { family: 'Montserrat' } } }
            }
        }
    });

    // ===================== ALERT AUTO-HIDE =====================
    setTimeout(function() {
        let alert = document.getElementById('alertMessage');
        if(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.style.display = 'none', 500);
        }
    }, 3000);

    // ===================== TAB SWITCHING =====================
    function switchTab(tabId) {
        document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active-tab'));
        document.getElementById(tabId).classList.add('active-tab');
        const navTab = document.querySelector('[data-tab="' + tabId + '"]');
        if(navTab) {
            navTab.classList.add('active');
            const spanEl = navTab.querySelector('span');
            if(spanEl) document.getElementById('mainPageTitle').innerText = spanEl.innerText;
        }
    }

    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            switchTab(tabId);
        });
    });

    // ===================== CLICKABLE DASHBOARD CARDS =====================
    document.querySelectorAll('.stat-card[data-filter]').forEach(card => {
        card.addEventListener('click', function() {
            const filterValue = this.getAttribute('data-filter');
            // First switch to dashboard tab if not active
            const dashboardPane = document.getElementById('dashboard');
            if(!dashboardPane.classList.contains('active-tab')) {
                switchTab('dashboard');
            }
            // Update filter chips
            document.querySelectorAll('.filter-chip').forEach(chip => chip.classList.remove('active'));
            if(filterValue === 'all') {
                document.querySelector('.filter-chip[data-dash-filter="all"]').classList.add('active');
            } else {
                const targetChip = document.querySelector(`.filter-chip[data-dash-filter="${filterValue}"]`);
                if(targetChip) targetChip.classList.add('active');
            }
            // Apply filter to dashboard table rows
            applyDashboardFilter(filterValue === 'all' ? '' : filterValue);
        });
    });

    // Dashboard filter function
    function applyDashboardFilter(status) {
        const rows = document.querySelectorAll('#tableData tr');
        rows.forEach(row => {
            if(!status) {
                row.style.display = '';
            } else {
                const rowStatus = row.getAttribute('data-status') || 'pending';
                row.style.display = rowStatus === status ? '' : 'none';
            }
        });
        // Also update the search placeholder text
        const searchInput = document.getElementById('search');
        if(status) {
            searchInput.placeholder = `Search in ${status.charAt(0).toUpperCase() + status.slice(1)} enquiries...`;
        } else {
            searchInput.placeholder = 'Search recent enquiries...';
        }
    }

    // ===================== DASHBOARD FILTER CHIPS =====================
    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.addEventListener('click', function() {
            // Remove active from all chips
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            const filterValue = this.getAttribute('data-dash-filter');
            applyDashboardFilter(filterValue === 'all' ? '' : filterValue);
        });
    });

    // ===================== REMINDER FIELD TOGGLE =====================
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.getAttribute('data-id');
            const reminderField = document.getElementById('reminderField' + id);
            if(reminderField) {
                reminderField.style.display = this.value === 'reminder' ? 'block' : 'none';
            }
        });
    });

    // ===================== PAGINATION ENGINE =====================
    const ROWS_PER_PAGE = 10;

    function setupPagination(tableBodyId, paginationId, searchInputId) {
        const tbody = document.getElementById(tableBodyId);
        const paginationEl = document.getElementById(paginationId);
        const searchInput = document.getElementById(searchInputId);
        if(!tbody || !paginationEl) return;

        let currentPage = 1;
        let filteredRows = [];

        function getAllRows() {
            return Array.from(tbody.querySelectorAll('tr'));
        }

        function applyFilter(query) {
            const q = query.toLowerCase();
            filteredRows = getAllRows().filter(row => {
                const match = row.innerText.toLowerCase().includes(q);
                return match;
            });
            currentPage = 1;
            render();
        }

        function render() {
            const allRows = getAllRows();
            // Hide all first
            allRows.forEach(r => r.style.display = 'none');

            if(filteredRows.length === 0) {
                filteredRows = allRows;
            }

            const totalPages = Math.ceil(filteredRows.length / ROWS_PER_PAGE);
            const start = (currentPage - 1) * ROWS_PER_PAGE;
            const end = start + ROWS_PER_PAGE;

            filteredRows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });

            renderPagination(totalPages);
        }

        function renderPagination(totalPages) {
            if(totalPages <= 1) { paginationEl.innerHTML = ''; return; }

            let html = '';
            const pageInfo = `<span class="page-info">Page ${currentPage} of ${totalPages} &nbsp;|&nbsp; ${filteredRows.length} records</span>`;

            // Prev button
            html += `<button class="page-btn ${currentPage === 1 ? 'disabled' : ''}" onclick="goToPage('${tableBodyId}', '${paginationId}', '${searchInputId}', ${currentPage - 1})">
                        <i class="fas fa-chevron-left" style="font-size:0.75rem"></i>
                     </button>`;

            // Page numbers
            let startPage = Math.max(1, currentPage - 2);
            let endPage   = Math.min(totalPages, currentPage + 2);
            if(startPage > 1) html += `<button class="page-btn" onclick="goToPage('${tableBodyId}','${paginationId}','${searchInputId}',1)">1</button>`;
            if(startPage > 2) html += `<span class="page-info">…</span>`;
            for(let i = startPage; i <= endPage; i++) {
                html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="goToPage('${tableBodyId}','${paginationId}','${searchInputId}',${i})">${i}</button>`;
            }
            if(endPage < totalPages - 1) html += `<span class="page-info">…</span>`;
            if(endPage < totalPages) html += `<button class="page-btn" onclick="goToPage('${tableBodyId}','${paginationId}','${searchInputId}',${totalPages})">${totalPages}</button>`;

            // Next button
            html += `<button class="page-btn ${currentPage === totalPages ? 'disabled' : ''}" onclick="goToPage('${tableBodyId}', '${paginationId}', '${searchInputId}', ${currentPage + 1})">
                        <i class="fas fa-chevron-right" style="font-size:0.75rem"></i>
                     </button>`;

            html += pageInfo;
            paginationEl.innerHTML = html;
        }

        // Store state on element
        window['_pag_' + tableBodyId] = {
            goTo: function(page) {
                filteredRows = filteredRows.length ? filteredRows : getAllRows();
                const totalPages = Math.ceil(filteredRows.length / ROWS_PER_PAGE);
                if(page < 1 || page > totalPages) return;
                currentPage = page;
                render();
            },
            applyFilter
        };

        // Search listener
        if(searchInput) {
            searchInput.addEventListener('keyup', function() {
                filteredRows = getAllRows().filter(row =>
                    row.innerText.toLowerCase().includes(this.value.toLowerCase())
                );
                currentPage = 1;
                render();
            });
        }

        // Initial render
        filteredRows = getAllRows();
        render();
    }

    function goToPage(tableBodyId, paginationId, searchInputId, page) {
        const pag = window['_pag_' + tableBodyId];
        if(pag) pag.goTo(page);
    }

    // ===================== INIT PAGINATIONS =====================
    document.addEventListener('DOMContentLoaded', function() {
        setupPagination('enquiriesTableData',    'enquiriesPagination',    'searchEnquiries');
        setupPagination('contactTableData',      'contactPagination',      'searchContact');
        setupPagination('consultationTableData', 'consultationPagination', 'searchConsultation');
        setupPagination('modalTableData',        'modalPagination',        'searchModal');
    });

    // Dashboard search (respects current status filter)
    document.getElementById('search').addEventListener('keyup', function() {
        const val = this.value.toLowerCase();
        const activeFilterChip = document.querySelector('.filter-chip.active');
        let currentStatusFilter = '';
        if(activeFilterChip && activeFilterChip.getAttribute('data-dash-filter') !== 'all') {
            currentStatusFilter = activeFilterChip.getAttribute('data-dash-filter');
        }
        document.querySelectorAll('#tableData tr').forEach(row => {
            const matchesSearch = row.innerText.toLowerCase().includes(val);
            let matchesFilter = true;
            if(currentStatusFilter) {
                const rowStatus = row.getAttribute('data-status') || 'pending';
                matchesFilter = rowStatus === currentStatusFilter;
            }
            row.style.display = (matchesSearch && matchesFilter) ? '' : 'none';
        });
    });
</script>
</body>
</html>