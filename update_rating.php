<?php
// update_rating.php - Unified AJAX endpoint to record every rating and update average
include 'admin/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = isset($_POST['item_id']) ? intval($_POST['item_id']) : 0;
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $rating = isset($_POST['rating']) ? floatval($_POST['rating']) : 0;
    $allowed_categories = ['destination','restaurant','accommodation','transportation','attraction'];
    if ($item_id > 0 && in_array($category, $allowed_categories) && $rating >= 0 && $rating <= 5) {
        // Insert new rating event
        $stmt = mysqli_prepare($conn, "INSERT INTO ratings (item_id, category, rating) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isd", $item_id, $category, $rating);
        $success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        if ($success) {
            // Update average rating in the main table
            $avg_result = mysqli_query($conn, "SELECT AVG(rating) AS avg_rating FROM ratings WHERE item_id = $item_id AND category = '" . mysqli_real_escape_string($conn, $category) . "'");
            $avg_row = mysqli_fetch_assoc($avg_result);
            $avg_rating = $avg_row ? floatval($avg_row['avg_rating']) : 0;
            $table_map = [
                'destination' => 'destinations',
                'restaurant' => 'restaurants',
                'accommodation' => 'accommodations',
                'transportation' => 'transportation',
                'attraction' => 'attractions'
            ];
            $table = $table_map[$category];
            $update_stmt = mysqli_prepare($conn, "UPDATE $table SET rating = ? WHERE id = ?");
            mysqli_stmt_bind_param($update_stmt, "di", $avg_rating, $item_id);
            mysqli_stmt_execute($update_stmt);
            mysqli_stmt_close($update_stmt);
            echo 'success';
        } else {
            http_response_code(500);
            echo 'Database error';
        }
    } else {
        http_response_code(400);
        echo 'Invalid input';
    }
} else {
    http_response_code(405);
    echo 'Method not allowed';
}
?>
