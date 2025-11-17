<?php
// admin.php - Admin login page with user table integration using MySQLi
include 'database.php';
$error = '';
$loggedOut = isset($_GET['loggedout']) && $_GET['loggedout'] == '1';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  $sql = "SELECT * FROM users WHERE username = ?";
  $stmt = mysqli_prepare($conn, $sql);
  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $userRow = mysqli_fetch_assoc($result);
    if ($userRow && password_verify($password, $userRow['password'])) {
      // Successful login
      session_start();
      $_SESSION['admin_user'] = $username;
      header('Location: dashboard.php'); // Redirect to admin dashboard
      exit;
    } else {
      $error = 'Invalid username or password.';
    }
    mysqli_stmt_close($stmt);
  } else {
    $error = 'Database error: ' . mysqli_error($conn);
  }
}

$pageTitle = 'Bislig Admin Login';
$pageDescription = 'Admin login for Bislig City Tourism website management.';
include 'header.php';
?>
    <main>
      <section class="page-hero" style="--hero-image: linear-gradient(135deg, rgba(29,78,216,0.85), rgba(15,159,110,0.85));">
        <div class="container">
          <h1>Admin Login</h1>
          <p>Restricted access for authorized Bislig City Tourism content managers.</p>
        </div>
      </section>
      <section class="section">
        <div class="container" style="max-width: 520px;">
          <article class="card">
            <h2 class="text-xl weight-semibold">Sign in to continue</h2>
            <?php if ($loggedOut): ?>
              <div class="success-message" style="color: #2e7d32; background: #e8f5e9; border-left: 4px solid #4caf50; padding: 12px 18px; border-radius: 6px; font-weight: 500; margin-bottom: 1em;">
                <i class="fas fa-check-circle" style="margin-right:8px;"></i> You have successfully logged out.
              </div>
            <?php endif; ?>
            <?php if ($error): ?>
              <div class="error-message" style="color: red; margin-bottom: 1em;">
                <?= htmlspecialchars($error) ?>
              </div>
            <?php endif; ?>
            <form action="" method="post">
              <div class="flex-col gap-sm">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" required />
              </div>
              <div class="flex-col gap-sm">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required />
              </div>
              <button class="btn btn-primary" type="submit">Login</button>
            </form>
            <p class="text-small text-muted" style="margin-top: 1.25rem;">
              For official access, contact the tourism office.
            </p>
          </article>
        </div>
      </section>
    </main>
    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold">Need public information?</h2>
        <p>Return to the main site to discover destinations, transportation, and emergency contacts.</p>
        <div class="button-row">
          <a class="btn btn-secondary" href="../index.php">Back to Home</a>
          <a class="btn btn-outline" href="../emergency.php">Emergency Contacts</a>
        </div>
      </div>
    </section>

    <?php include '../footer.php'; ?>
  </body>
</html>
