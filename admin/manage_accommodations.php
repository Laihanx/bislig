<?php
// manage_accommodations.php - CRUD for accommodations
session_start();
if (!isset($_SESSION['admin_user'])) {
    header('Location: admin.php');
    exit;
}

include 'database.php';

$message = '';
$error = '';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM accommodations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success_message'] = 'Accommodation deleted successfully!';
        header('Location: manage_accommodations.php');
        exit;
    } else {
        $error = 'Error deleting accommodation.';
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $rating = $_POST['rating'] ?? 0;
    $badge = $_POST['badge'] ?? '';

    if ($id) {
        $sql = "UPDATE accommodations SET name=?, description=?, location=?, phone=?, rating=?, badge=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssdsi", $name, $description, $location, $phone, $rating, $badge, $id);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($success) {
            $_SESSION['success_message'] = 'Accommodation updated successfully!';
            header('Location: manage_accommodations.php');
            exit;
        } else {
            $error = 'Error updating accommodation.';
        }
    } else {
        $sql = "INSERT INTO accommodations (name, description, location, phone, rating, badge) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssds", $name, $description, $location, $phone, $rating, $badge);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($success) {
            $_SESSION['success_message'] = 'Accommodation added successfully!';
            header('Location: manage_accommodations.php');
            exit;
        } else {
            $error = 'Error adding accommodation.';
        }
    }
}

// Get success message from session
if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

$result = mysqli_query($conn, "SELECT * FROM accommodations ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accommodations - Admin System</title>
    <link rel="icon" type="image/png" href="../assets/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #2e7d32;
            --light-green: #4caf50;
            --accent-green: #e8f5e9;
            --primary-blue: #1565c0;
            --light-blue: #42a5f5;
            --accent-blue: #e3f2fd;
            --primary-red: #c62828;
            --light-red: #ef5350;
            --accent-red: #ffebee;
            --primary-maroon: #880e4f;
            --light-maroon: #ad1457;
            --accent-maroon: #fce4ec;
            --neutral-dark: #263238;
            --neutral-mid: #607d8b;
            --neutral-light: #eceff1;
            --white: #ffffff;
            --border-radius: 6px;
            --box-shadow-sm: 0 2px 5px rgba(0, 0, 0, 0.08);
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            --transition: all 0.2s ease-in-out;
            --font-family: 'Poppins', sans-serif;
            --table-border-color: #d0d9dd;
            --table-header-border-color: var(--primary-blue);
        }
        body { font-family: var(--font-family); background-color: #f8f9fa; color: var(--neutral-dark); margin: 0; line-height: 1.6; }
        .content-section { max-width: 1400px; margin: 0 auto; padding: 0 20px; }
        .card { background: var(--white); border-radius: var(--border-radius); box-shadow: var(--box-shadow-sm); margin-bottom: 1.5rem; border: none; overflow: hidden; }
        .card:hover { box-shadow: var(--box-shadow); }
        .card-header { display: flex; justify-content: space-between; align-items: center; padding: 1.25rem 1.5rem; background: var(--white); border-bottom: 1px solid rgba(0, 0, 0, 0.08); }
        .card-header h2 { font-size: 1.25rem; font-weight: 600; color: black; margin: 0; display: flex; align-items: center; }
        .card-header h2 i { margin-right: 12px; color: #1d4ed8; }
        .card-body { padding: 1.5rem; }
        .btn { padding: 0.5rem 1rem; border-radius: var(--border-radius); font-weight: 500; border: none; cursor: pointer; transition: var(--transition); display: inline-flex; align-items: center; justify-content: center; text-decoration: none; white-space: nowrap; font-size: 0.9rem; font-family: var(--font-family); }
        .btn i { margin-right: 8px; }
        .btn-primary { background-color: var(--primary-blue); color: var(--white); border: 1px solid var(--primary-blue); }
        .btn-primary:hover { background-color: #0d47a1; box-shadow: 0 4px 8px rgba(21, 101, 192, 0.3); }
        .btn-secondary { background-color: var(--neutral-mid); color: var(--white); border: 1px solid var(--neutral-mid); }
        .btn-secondary:hover { background-color: #455a64; box-shadow: 0 4px 8px rgba(96, 125, 139, 0.3); }
        .btn-success { background-color: var(--primary-green); color: var(--white); border: 1px solid var(--primary-green); }
        .btn-success:hover { background-color: #1b5e20; box-shadow: 0 4px 8px rgba(46, 125, 50, 0.3); }
        .btn-danger { background-color: var(--primary-red); color: var(--white); border: 1px solid var(--primary-red); }
        .btn-danger:hover { background-color: #b71c1c; box-shadow: 0 4px 8px rgba(198, 40, 40, 0.3); }
        .btn-warning { background-color: #f57c00; color: var(--white); border: 1px solid #f57c00; }
        .btn-warning:hover { background-color: #ef6c00; box-shadow: 0 4px 8px rgba(245, 124, 0, 0.3); }
        .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.85rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-group label { display: block; font-family: var(--font-family); font-size: 0.9rem; margin-bottom: 8px; font-weight: 500; color: var(--neutral-dark); }
        .form-group label i { margin-right: 6px; color: var(--primary-blue); }
        .form-group input[type="text"], .form-group input[type="email"], .form-group input[type="tel"], .form-group input[type="number"], .form-group textarea { width: 100%; padding: 0.7rem 0.9rem; font-family: var(--font-family); font-size: 0.9rem; color: var(--neutral-dark); border: 1px solid rgba(0, 0, 0, 0.15); border-radius: var(--border-radius); background-color: white; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.06); transition: all 0.3s ease; box-sizing: border-box; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: var(--light-blue); box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.15); }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .form-actions { display: flex; gap: 10px; margin-top: 1.5rem; }
        .table-responsive { overflow-x: auto; border-radius: var(--border-radius); box-shadow: var(--box-shadow-sm); border: 1px solid var(--table-border-color); }
        .data-table { width: 100%; border-collapse: collapse; border-spacing: 0; font-size: 0.92rem; white-space: nowrap; border: none; }
        .data-table thead th { background-color: var(--accent-blue); color: black; padding: 0.9rem 1rem; font-weight: 600; position: sticky; top: 0; z-index: 10; border: 1px solid var(--table-border-color); border-bottom: 2px solid var(--table-header-border-color); text-align: left; }
        .data-table thead th:last-child { text-align: center; }
        .data-table tbody tr { transition: var(--transition); border-bottom: 1px solid var(--table-border-color); }
        .data-table tbody tr:last-child { border-bottom: none; }
        .data-table tbody tr:hover { background-color: var(--accent-blue); }
        .data-table td { padding: 0.9rem 1rem; border: 1px solid var(--table-border-color); vertical-align: middle; }
        .data-table td:first-child { text-align: right; }
        .data-table td:last-child { text-align: center; }
        .data-table .actions { display: flex; gap: 8px; justify-content: center; align-items: center; }
        .data-table .actions .btn { display: inline-flex; align-items: center; justify-content: center; height: 32px; min-height: 32px; padding: 0 12px; font-size: 0.88rem; line-height: 1; box-sizing: border-box; }
        .badge-display { display: inline-block; padding: 4px 10px; background-color: var(--accent-maroon); color: var(--primary-maroon); border-radius: 4px; font-size: 0.85rem; font-weight: 500; }
        .alert { padding: 1rem 1.25rem; border-radius: var(--border-radius); margin-bottom: 1.5rem; box-shadow: var(--box-shadow-sm); display: flex; align-items: center; }
        .alert i { margin-right: 10px; font-size: 1.1rem; }
        .alert-success { background-color: var(--accent-green); border-left: 4px solid var(--light-green); color: var(--primary-green); }
        .alert-error { background-color: var(--accent-red); border-left: 4px solid var(--light-red); color: var(--primary-red); }
        .text-center { text-align: center; padding: 1.5rem; color: var(--neutral-mid); font-style: italic; }
        .confirmation-modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; backdrop-filter: blur(8px); background: rgba(0, 0, 0, 0.3); display: none; justify-content: center; align-items: center; z-index: 9999; }
        .confirmation-modal.active { display: flex; }
        .confirmation-modal-content { background: white; padding: 20px 25px; border-radius: 12px; border: 3px solid #1d4ed8; text-align: center; max-width: 500px; width: 95%; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); }
        .confirmation-modal h3 { margin: 0 0 12px 0; color: #1d4ed8; font-weight: 600; font-size: 1.15rem; }
        .confirmation-modal p { margin: 0 0 20px 0; color: black; }
        .confirmation-modal .form-group { margin-bottom: 0.85rem; }
        .confirmation-modal .form-group label { margin-bottom: 5px; font-size: 0.85rem; }
        .confirmation-modal .form-group input, .confirmation-modal .form-group textarea { padding: 0.55rem 0.75rem; font-size: 0.875rem; }
        .confirmation-modal .form-group textarea { min-height: 70px; resize: vertical; }
        .confirmation-modal .form-actions { margin-top: 1rem; gap: 8px; }
        .confirmation-modal-buttons { display: flex; gap: 15px; justify-content: center; }
        .confirmation-modal .btn { padding: 12px 24px; border: none; border-radius: 12px; cursor: pointer; font-weight: 500; font-size: 14px; transition: all 0.3s ease; }
        .confirmation-modal .btn:hover { opacity: 0.9; transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); }
        @media screen and (max-width: 768px) { 
            .content-section { padding: 0 10px; } 
            .card-header { flex-direction: column; align-items: flex-start; gap: 15px; padding: 1rem; } 
            .form-actions { flex-direction: column; } 
            .form-actions .btn { width: 100%; } 
            .data-table { font-size: 0.8rem; } 
            .data-table .actions { flex-direction: column; gap: 5px; } 
            .data-table .actions .btn { width: 100%; } 
            .confirmation-modal-content { width: 95%; padding: 20px 15px; } 
            .confirmation-modal-buttons { flex-direction: column; } 
            .confirmation-modal .btn { width: 100%; } 
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <main class="main-content">
        <section class="content-section">
            <?php if ($message): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Add/Edit Modal -->
            <div class="confirmation-modal" id="accommodationModal">
                <div class="confirmation-modal-content" style="max-width:600px;min-height:unset;text-align:left;display:flex;flex-direction:column;justify-content:center;">
                    <h3 id="modalFormTitle"><i class="fas fa-plus-circle"></i> Add New Accommodation</h3>
                    <form id="accommodationForm" method="post">
                        <input type="hidden" name="id" id="modal_id" />
                        <div class="form-group">
                            <label for="modal_name"><i class="fas fa-hotel"></i> Accommodation Name</label>
                            <input type="text" id="modal_name" name="name" required placeholder="Enter accommodation name" />
                        </div>
                        <div class="form-group">
                            <label for="modal_description"><i class="fas fa-align-left"></i> Description</label>
                            <textarea id="modal_description" name="description" rows="4" required placeholder="Enter accommodation description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="modal_location"><i class="fas fa-location-dot"></i> Location</label>
                            <input type="text" id="modal_location" name="location" required placeholder="Enter location" />
                        </div>
                        <div class="form-group">
                            <label for="modal_phone"><i class="fas fa-phone"></i> Phone</label>
                            <input type="tel" id="modal_phone" name="phone" placeholder="Enter phone number" />
                        </div>
                        <div class="form-group">
                            <label for="modal_rating"><i class="fas fa-star"></i> Rating (0-5)</label>
                            <input type="number" step="0.1" min="0" max="5" id="modal_rating" name="rating" placeholder="Enter rating" />
                        </div>
                        <div class="form-group">
                            <label for="modal_badge"><i class="fas fa-award"></i> Badge</label>
                            <input type="text" id="modal_badge" name="badge" placeholder="e.g., Featured, Popular, New" />
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary" id="modalSubmitBtn">
                                <i class="fas fa-save"></i> Add Accommodation
                            </button>
                            <button type="button" class="btn btn-secondary" id="closeModalBtn">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2><i class="fas fa-list"></i> All Accommodations</h2>
                    <button class="btn btn-success" id="openAddModalBtn" style="margin-left:auto;">
                        <i class="fas fa-plus-circle"></i> Add Accommodation
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Phone</th>
                                    <th>Rating</th>
                                    <th>Badge</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['location']) ?></td>
                                        <td><?= htmlspecialchars($row['phone']) ?></td>
                                        <td><?= $row['rating'] ?></td>
                                        <td>
                                            <?php if (!empty($row['badge'])): ?>
                                                <span class="badge-display">
                                                    <i class="fas fa-award"></i> <?= htmlspecialchars($row['badge']) ?>
                                                </span>
                                            <?php else: ?>
                                                <span style="color: var(--neutral-mid); font-style: italic;">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="actions">
                                            <button class="btn btn-warning btn-edit"
                                                data-id="<?= $row['id'] ?>"
                                                data-name="<?= htmlspecialchars($row['name']) ?>"
                                                data-description="<?= htmlspecialchars($row['description']) ?>"
                                                data-location="<?= htmlspecialchars($row['location']) ?>"
                                                data-phone="<?= htmlspecialchars($row['phone']) ?>"
                                                data-rating="<?= htmlspecialchars($row['rating']) ?>"
                                                data-badge="<?= htmlspecialchars($row['badge']) ?>"
                                            >
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm btn-delete" data-id="<?= $row['id'] ?>" data-name="<?= htmlspecialchars($row['name']) ?>">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <i class="fas fa-inbox"></i> No accommodations found. Add your first accommodation above!
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="confirmation-modal" id="confirmationModal">
        <div class="confirmation-modal-content">
            <h3 id="modalTitle">Confirm Delete</h3>
            <p id="modalMessage">Are you sure you want to delete this accommodation?</p>
            <div class="confirmation-modal-buttons">
                <a href="#" class="btn btn-danger" id="modalConfirmBtn">
                    <i class="fas fa-trash"></i> Yes, Delete
                </a>
                <button class="btn btn-secondary" id="modalCancelBtn">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </div>
    <script>
        // Confirmation modal logic (Delete)
        const modal = document.getElementById('confirmationModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalConfirmBtn = document.getElementById('modalConfirmBtn');
        const modalCancelBtn = document.getElementById('modalCancelBtn');
        const deleteBtns = document.querySelectorAll('.btn-delete');
        deleteBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const accId = btn.getAttribute('data-id');
                const accName = btn.getAttribute('data-name');
                modalTitle.textContent = 'Delete Accommodation';
                modalMessage.textContent = `Are you sure you want to delete "${accName}"? This action cannot be undone.`;
                modalConfirmBtn.href = `?delete=${accId}`;
                modal.classList.add('active');
            });
        });
        modalCancelBtn.addEventListener('click', function() {
            modal.classList.remove('active');
        });
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('active');
            }
        });
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                modal.classList.remove('active');
                accommodationModal.classList.remove('active');
            }
        });

        // Add/Edit Modal logic
        const accommodationModal = document.getElementById('accommodationModal');
        const openAddModalBtn = document.getElementById('openAddModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalFormTitle = document.getElementById('modalFormTitle');
        const accommodationForm = document.getElementById('accommodationForm');
        const modal_id = document.getElementById('modal_id');
        const modal_name = document.getElementById('modal_name');
        const modal_description = document.getElementById('modal_description');
        const modal_location = document.getElementById('modal_location');
        const modal_phone = document.getElementById('modal_phone');
        const modal_rating = document.getElementById('modal_rating');
        const modal_badge = document.getElementById('modal_badge');
        const modalSubmitBtn = document.getElementById('modalSubmitBtn');

        // Open Add Modal
        openAddModalBtn.addEventListener('click', function() {
            modalFormTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Add New Accommodation';
            modalSubmitBtn.innerHTML = '<i class="fas fa-save"></i> Add Accommodation';
            modal_id.value = '';
            modal_name.value = '';
            modal_description.value = '';
            modal_location.value = '';
            modal_phone.value = '';
            modal_rating.value = '';
            modal_badge.value = '';
            accommodationModal.classList.add('active');
        });

        // Open Edit Modal
        document.querySelectorAll('.btn-edit').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                modalFormTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Accommodation';
                modalSubmitBtn.innerHTML = '<i class="fas fa-save"></i> Update Accommodation';
                modal_id.value = btn.getAttribute('data-id');
                modal_name.value = btn.getAttribute('data-name');
                modal_description.value = btn.getAttribute('data-description');
                modal_location.value = btn.getAttribute('data-location');
                modal_phone.value = btn.getAttribute('data-phone');
                modal_rating.value = btn.getAttribute('data-rating');
                modal_badge.value = btn.getAttribute('data-badge');
                accommodationModal.classList.add('active');
            });
        });

        // Close Modal
        closeModalBtn.addEventListener('click', function() {
            accommodationModal.classList.remove('active');
        });
        accommodationModal.addEventListener('click', function(e) {
            if (e.target === accommodationModal) {
                accommodationModal.classList.remove('active');
            }
        });
    </script>
</body>
</html>