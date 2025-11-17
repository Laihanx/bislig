<?php
// manage_destinations.php - CRUD for destinations
session_start();
if (!isset($_SESSION['admin_user'])) {
    header('Location: admin.php');
    exit;
}

include 'database.php';

$message = '';
$error = '';

// Handle DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    // Get image filename before deleting
    $img_stmt = mysqli_prepare($conn, "SELECT image_url FROM destinations WHERE id = ?");
    mysqli_stmt_bind_param($img_stmt, "i", $id);
    mysqli_stmt_execute($img_stmt);
    $img_result = mysqli_stmt_get_result($img_stmt);
    $img_row = mysqli_fetch_assoc($img_result);
    $image_path = $img_row ? $img_row['image_url'] : '';
    mysqli_stmt_close($img_stmt);

    $sql = "DELETE FROM destinations WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        // Delete image file
        if ($image_path && file_exists('../' . $image_path)) {
            unlink('../' . $image_path);
        }
        $_SESSION['success_message'] = 'Destination deleted successfully!';
        header('Location: manage_destinations.php');
        exit;
    } else {
        $error = 'Error deleting destination.';
    }
    mysqli_stmt_close($stmt);
}

// Handle ADD/EDIT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $rating = $_POST['rating'] ?? 0;
    $image_path = '';

    // Ensure upload directory exists
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Handle image upload
    $old_image_path = $_POST['existing_image'] ?? '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . time() . '_' . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image_path = 'uploads/' . basename($targetFile);
                // Delete old image if updating
                if ($id && $old_image_path && file_exists('../' . $old_image_path)) {
                    unlink('../' . $old_image_path);
                }
            } else {
                $error = 'Error uploading image. Check folder permissions.';
            }
        } else {
            $error = 'Invalid image type. Allowed: jpg, jpeg, png, gif, webp.';
        }
    } else if (!empty($old_image_path)) {
        $image_path = $old_image_path;
    }

    if (!$error) {
        if ($id) {
            // UPDATE: allow keeping existing image
            $sql = "UPDATE destinations SET name=?, description=?, location=?, rating=?, image_url=? WHERE id=?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssdsi", $name, $description, $location, $rating, $image_path, $id);
            $success = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            if ($success) {
                $_SESSION['success_message'] = 'Destination updated successfully!';
                header('Location: manage_destinations.php');
                exit;
            } else {
                $error = 'Error updating destination.';
            }
        } else {
            // INSERT: require image
            if (empty($image_path)) {
                $error = 'Image upload required for new destination.';
            } else {
                $sql = "INSERT INTO destinations (name, description, location, rating, image_url) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssds", $name, $description, $location, $rating, $image_path);
                $success = mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                if ($success) {
                    $_SESSION['success_message'] = 'Destination added successfully with image!';
                    header('Location: manage_destinations.php');
                    exit;
                } else {
                    $error = 'Error adding destination.';
                }
            }
        }
    }
}

// Get success message from session
if (isset($_SESSION['success_message'])) {
    $message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

// Get all destinations
$result = mysqli_query($conn, "SELECT * FROM destinations ORDER BY id DESC");

// Get single destination for editing
$edit_destination = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $edit_stmt = mysqli_prepare($conn, "SELECT * FROM destinations WHERE id = ?");
    mysqli_stmt_bind_param($edit_stmt, "i", $edit_id);
    mysqli_stmt_execute($edit_stmt);
    $edit_result = mysqli_stmt_get_result($edit_stmt);
    $edit_destination = mysqli_fetch_assoc($edit_result);
    mysqli_stmt_close($edit_stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Destinations - Admin System</title>
    <link rel="icon" type="image/png" href="../assets/logo.jpg">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Font - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Professional Management System - Refined Color Palette */
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

        /* Global Styles */
        body {
            font-family: var(--font-family);
            background-color: #f8f9fa;
            color: var(--neutral-dark);
            margin: 0;
            line-height: 1.6;
        }

        .content-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Card Styling */
        .card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-sm);
            margin-bottom: 1.5rem;
            border: none;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--box-shadow);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: var(--white);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: black;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-header h2 i {
            margin-right: 12px;
            color: #1d4ed8;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Button Styles */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            white-space: nowrap;
            font-size: 0.9rem;
            font-family: var(--font-family);
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: var(--primary-blue);
            color: var(--white);
            border: 1px solid var(--primary-blue);
        }

        .btn-primary:hover {
            background-color: #0d47a1;
            box-shadow: 0 4px 8px rgba(21, 101, 192, 0.3);
        }

        .btn-secondary {
            background-color: var(--neutral-mid);
            color: var(--white);
            border: 1px solid var(--neutral-mid);
        }

        .btn-secondary:hover {
            background-color: #455a64;
            box-shadow: 0 4px 8px rgba(96, 125, 139, 0.3);
        }

        .btn-success {
            background-color: var(--primary-green);
            color: var(--white);
            border: 1px solid var(--primary-green);
        }

        .btn-success:hover {
            background-color: #1b5e20;
            box-shadow: 0 4px 8px rgba(46, 125, 50, 0.3);
        }

        .btn-danger {
            background-color: var(--primary-red);
            color: var(--white);
            border: 1px solid var(--primary-red);
        }

        .btn-danger:hover {
            background-color: #b71c1c;
            box-shadow: 0 4px 8px rgba(198, 40, 40, 0.3);
        }

        .btn-warning {
            background-color: #f57c00;
            color: var(--white);
            border: 1px solid #f57c00;
        }

        .btn-warning:hover {
            background-color: #ef6c00;
            box-shadow: 0 4px 8px rgba(245, 124, 0, 0.3);
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.85rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-family: var(--font-family);
            font-size: 0.9rem;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--neutral-dark);
        }

        .form-group label i {
            margin-right: 6px;
            color: var(--primary-blue);
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"],
        .form-group textarea {
            width: 100%;
            padding: 0.7rem 0.9rem;
            font-family: var(--font-family);
            font-size: 0.9rem;
            color: var(--neutral-dark);
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: var(--border-radius);
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--light-blue);
            box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.15);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 1.5rem;
        }

        /* Current Image Preview */
        .current-image {
            margin-top: 10px;
            padding: 10px;
            background-color: var(--neutral-light);
            border-radius: var(--border-radius);
            display: inline-block;
        }

        .current-image img {
            max-width: 150px;
            max-height: 150px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-sm);
        }

        .current-image p {
            margin: 8px 0 0 0;
            font-size: 0.85rem;
            color: var(--neutral-mid);
        }

        .current-image p i {
            margin-right: 5px;
        }

        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow-sm);
            border: 1px solid var(--table-border-color);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 0.92rem;
            white-space: nowrap;
            border: none;
        }

        .data-table thead th {
            background-color: var(--accent-blue);
            color: black;
            padding: 0.9rem 1rem;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
            border: 1px solid var(--table-border-color);
            border-bottom: 2px solid var(--table-header-border-color);
            text-align: left;
        }

        .data-table thead th:last-child {
            text-align: center;
        }

        .data-table tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid var(--table-border-color);
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background-color: var(--accent-blue);
        }

        .data-table td {
            padding: 0.9rem 1rem;
            border: 1px solid var(--table-border-color);
            vertical-align: middle;
        }

        .data-table td:first-child {
            text-align: right;
        }

        .data-table td:last-child {
            text-align: center;
        }

        .data-table .actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .data-table .actions .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            min-height: 32px;
            padding: 0 12px;
            font-size: 0.88rem;
            line-height: 1;
            box-sizing: border-box;
        }

        .destination-image-thumb {
            max-width: 80px;
            max-height: 60px;
            border-radius: 4px;
            box-shadow: var(--box-shadow-sm);
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            box-shadow: var(--box-shadow-sm);
            display: flex;
            align-items: center;
        }

        .alert i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .alert-success {
            background-color: var(--accent-green);
            border-left: 4px solid var(--light-green);
            color: var(--primary-green);
        }

        .alert-error {
            background-color: var(--accent-red);
            border-left: 4px solid var(--light-red);
            color: var(--primary-red);
        }

        .text-center {
            text-align: center;
            padding: 1.5rem;
            color: var(--neutral-mid);
            font-style: italic;
        }

        /* Confirmation Modal */
        .confirmation-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(8px);
            background: rgba(0, 0, 0, 0.3);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .confirmation-modal.active {
            display: flex;
        }

        .confirmation-modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            border: 3px solid #1d4ed8;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        /* Modal form container with fixed height and scroll */
        .modal-form-container {
            max-height: 650px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .modal-form-container::-webkit-scrollbar {
            width: 8px;
        }

        .modal-form-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal-form-container::-webkit-scrollbar-thumb {
            background: #1d4ed8;
            border-radius: 10px;
        }

        .modal-form-container::-webkit-scrollbar-thumb:hover {
            background: #0d47a1;
        }

        .confirmation-modal h3 {
            margin-bottom: 15px;
            color: #1d4ed8;
            font-weight: 600;
        }

        .confirmation-modal p {
            margin-bottom: 25px;
            color: black;
        }

        .confirmation-modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .confirmation-modal .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .confirmation-modal .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .content-section {
                padding: 0 10px;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }

            .data-table {
                font-size: 0.8rem;
            }

            .data-table .actions {
                flex-direction: column;
                gap: 5px;
            }

            .data-table .actions .btn {
                width: 100%;
            }

            .confirmation-modal-content {
                width: 95%;
                padding: 25px 20px;
            }

            .confirmation-modal-buttons {
                flex-direction: column;
            }

            .confirmation-modal .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>

    <main class="main-content">
        <section class="content-section">
            <!-- Success/Error Messages -->
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

            <!-- Add Destination Button moved to All Destinations card header -->

            <!-- Add/Edit Modal -->
            <div class="confirmation-modal" id="destinationModal">
                <div class="confirmation-modal-content" style="max-width:600px;text-align:left; min-height:650px; display:flex; flex-direction:column; justify-content:center;">
                    <div id="modalFormContainer" class="modal-form-container">
                        <h3 id="modalFormTitle"><i class="fas fa-plus-circle"></i> Add New Destination</h3>
                        <form id="destinationForm" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="modal_id" />
                            <div class="form-group">
                                <label for="modal_name"><i class="fas fa-map-marker-alt"></i> Destination Name</label>
                                <input type="text" id="modal_name" name="name" required placeholder="Enter destination name" />
                            </div>
                            <div class="form-group">
                                <label for="modal_description"><i class="fas fa-align-left"></i> Description</label>
                                <textarea id="modal_description" name="description" rows="4" required placeholder="Enter destination description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="modal_location"><i class="fas fa-location-dot"></i> Location</label>
                                <input type="text" id="modal_location" name="location" required placeholder="Enter location" />
                            </div>
                            <div class="form-group">
                                <label for="modal_rating"><i class="fas fa-star"></i> Rating (0-5)</label>
                                <input type="number" id="modal_rating" step="0.1" min="0" max="5" name="rating" value="0" placeholder="0.0" />
                            </div>
                            <div class="form-group">
                                <label for="modal_image"><i class="fas fa-image"></i> Image <span id="modal_image_required">(Required)</span></label>
                                <input type="file" id="modal_image" name="image" accept="image/*" required />
                                <div id="modal_current_image" style="display:none;"></div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="modalSubmitBtn">
                                    <i class="fas fa-save"></i> Add Destination
                                </button>
                                <button type="button" class="btn btn-secondary" id="closeModalBtn">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Destinations List -->
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <h2><i class="fas fa-list"></i> All Destinations</h2>
                    <button class="btn btn-success" id="openAddModalBtn" style="margin-left:auto;">
                        <i class="fas fa-plus-circle"></i> Add Destination
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <!-- <th>ID</th> -->
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Rating</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <!-- <td><?= $row['id'] ?></td> -->
                                        <td>
                                            <?php if (!empty($row['image_url'])): ?>
                                                <img src="../<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" class="destination-image-thumb" />
                                            <?php else: ?>
                                                <i class="fas fa-image" style="color: var(--neutral-mid);"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['location']) ?></td>
                                        <td>
                                            <i class="fas fa-star" style="color: #ffa726;"></i> <?= number_format($row['rating'], 1) ?>
                                        </td>
                                        <td class="actions">
                                            <button class="btn btn-warning btn-edit" 
                                                data-id="<?= $row['id'] ?>"
                                                data-name="<?= htmlspecialchars($row['name']) ?>"
                                                data-description="<?= htmlspecialchars($row['description']) ?>"
                                                data-location="<?= htmlspecialchars($row['location']) ?>"
                                                data-rating="<?= htmlspecialchars($row['rating']) ?>"
                                                data-image="<?= htmlspecialchars($row['image_url']) ?>"
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
                                            <i class="fas fa-inbox"></i> No destinations found. Add your first destination above!
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

    <!-- Confirmation Modal -->
    <div class="confirmation-modal" id="confirmationModal">
        <div class="confirmation-modal-content">
            <h3 id="modalTitle">Confirm Delete</h3>
            <p id="modalMessage">Are you sure you want to delete this destination?</p>
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
                const destId = btn.getAttribute('data-id');
                const destName = btn.getAttribute('data-name');
                modalTitle.textContent = 'Delete Destination';
                modalMessage.textContent = `Are you sure you want to delete "${destName}"? This action cannot be undone.`;
                modalConfirmBtn.href = `?delete=${destId}`;
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
                destinationModal.classList.remove('active');
            }
        });

        // Add/Edit Modal logic
        const destinationModal = document.getElementById('destinationModal');
        const openAddModalBtn = document.getElementById('openAddModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalFormTitle = document.getElementById('modalFormTitle');
        const destinationForm = document.getElementById('destinationForm');
        const modal_id = document.getElementById('modal_id');
        const modal_name = document.getElementById('modal_name');
        const modal_description = document.getElementById('modal_description');
        const modal_location = document.getElementById('modal_location');
        const modal_rating = document.getElementById('modal_rating');
        const modal_image = document.getElementById('modal_image');
        const modal_image_required = document.getElementById('modal_image_required');
        const modal_current_image = document.getElementById('modal_current_image');
        const modalSubmitBtn = document.getElementById('modalSubmitBtn');

        // Open Add Modal
        openAddModalBtn.addEventListener('click', function() {
            modalFormTitle.innerHTML = '<i class="fas fa-plus-circle"></i> Add New Destination';
            modalSubmitBtn.innerHTML = '<i class="fas fa-save"></i> Add Destination';
            modal_id.value = '';
            modal_name.value = '';
            modal_description.value = '';
            modal_location.value = '';
            modal_rating.value = '0';
            modal_image.value = '';
            modal_image.required = true;
            modal_image_required.style.display = '';
            modal_current_image.style.display = 'none';
            modal_current_image.innerHTML = '';
            // Remove scrollable class for Add modal
            document.getElementById('modalFormContainer').classList.remove('modal-form-container');
            destinationModal.classList.add('active');
        });

        // Open Edit Modal
        document.querySelectorAll('.btn-edit').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                modalFormTitle.innerHTML = '<i class="fas fa-edit"></i> Edit Destination';
                modalSubmitBtn.innerHTML = '<i class="fas fa-save"></i> Update Destination';
                modal_id.value = btn.getAttribute('data-id');
                modal_name.value = btn.getAttribute('data-name');
                modal_description.value = btn.getAttribute('data-description');
                modal_location.value = btn.getAttribute('data-location');
                modal_rating.value = btn.getAttribute('data-rating');
                modal_image.value = '';
                modal_image.required = false;
                modal_image_required.style.display = 'none';
                // Show current image if exists
                const imgUrl = btn.getAttribute('data-image');
                if (imgUrl) {
                    modal_current_image.style.display = 'block';
                    modal_current_image.innerHTML = `<div class='current-image'><img src='../${imgUrl}' alt='Current Image' /><p><i class='fas fa-info-circle'></i> Current image (leave empty to keep)</p><input type='hidden' name='existing_image' value='${imgUrl}' /></div>`;
                } else {
                    modal_current_image.style.display = 'none';
                    modal_current_image.innerHTML = '';
                }
                // Add scrollable class for Edit modal
                document.getElementById('modalFormContainer').classList.add('modal-form-container');
                destinationModal.classList.add('active');
            });
        });

        // Close Modal
        closeModalBtn.addEventListener('click', function() {
            destinationModal.classList.remove('active');
        });
        destinationModal.addEventListener('click', function(e) {
            if (e.target === destinationModal) {
                destinationModal.classList.remove('active');
            }
        });
    </script>
</body>
</html>