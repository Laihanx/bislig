<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Bislig Admin'; ?></title>
    <meta
      name="description"
      content="<?php echo isset($pageDescription) ? $pageDescription : 'Admin panel for Bislig City Tourism website management.'; ?>"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../styles.css" />
  </head>
  <body>
    <header class="navbar">
      <div class="container nav-container">
        <a class="logo" href="../index.php" aria-label="Explore Bislig logo">
          <img src="../assets/logo.jpg" alt="Explore Bislig logo" class="logo-img" style="height: 2rem; vertical-align: middle;" />
          <span class="visually-hidden">Bislig City</span>
        </a>
        <input type="checkbox" id="nav-toggle" class="nav-toggle" />
        <label for="nav-toggle" class="nav-toggle-label" aria-label="Toggle navigation menu">
          ☰
        </label>
        <nav class="nav-links" aria-label="Primary">
          <a class="nav-link" href="../index.php">Home</a>
          <a class="nav-link" href="../destinations.php">Destinations</a>
          <a class="nav-link" href="../restaurants.php">Restaurants</a>
          <a class="nav-link" href="../accommodations.php">Accommodations</a>
          <a class="nav-link" href="../transportation.php">Transportation</a>
          <a class="nav-link" href="../attractions.php">Attractions</a>
          <a class="nav-link" href="../festivals.php">Festivals</a>
          <a class="nav-link" href="../emergency.php">Emergency</a>
          <a class="btn btn-secondary" href="admin.php">Admin</a>
        </nav>
      </div>
    </header>
