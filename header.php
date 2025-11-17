<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Explore Bislig City'; ?></title>
    <meta
      name="description"
      content="<?php echo isset($pageDescription) ? $pageDescription : 'Discover Bislig City\'s waterfalls, islands, dining, accommodations, and transportation guides in a fully static experience.'; ?>"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="styles.css" />
    <link rel="icon" type="image/png" href="assets/logo.jpg" />
  </head>
  <body>
    <header class="navbar">
      <div class="container nav-container">
        <a class="logo" href="index.php" aria-label="Explore Bislig City logo">
          <img src="assets/logo.jpg" alt="Explore Bislig" class="logo-img" />
          <span>Bislig City</span>
        </a>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <label for="nav-toggle" class="nav-toggle-label" aria-label="Toggle navigation menu">
          ☰
        </label>
        <nav class="nav-links" aria-label="Primary">
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'destinations.php') ? 'active' : ''; ?>" href="destinations.php">Destinations</a>
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'restaurants.php') ? 'active' : ''; ?>" href="restaurants.php">Restaurants</a>
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'accommodations.php') ? 'active' : ''; ?>" href="accommodations.php">Accommodations</a>
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'transportation.php') ? 'active' : ''; ?>" href="transportation.php">Transportation</a>
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'attractions.php') ? 'active' : ''; ?>" href="attractions.php">Attractions</a>
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'festivals.php') ? 'active' : ''; ?>" href="festivals.php">Festivals</a>
          <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'emergency.php') ? 'active' : ''; ?>" href="emergency.php">Emergency</a>
          <a class="btn btn-secondary" href="admin/admin.php">Admin</a>
        </nav>
      </div>
    </header>