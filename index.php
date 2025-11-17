<?php include 'header.php'; ?>
    <main>
      <section
        class="hero"
        style="--hero-image: url('assets/tinuyan-falls-hero.jpg');"
        aria-label="Tinuy-an Falls hero backdrop"
      >
        <div class="hero-content">
          <h1>Welcome to Bislig City</h1>
          <p>Experience the natural beauty of the Philippines' hidden gem on the southeastern coast of Mindanao.</p>
          <div class="button-row">
            <a class="btn btn-primary" href="destinations.php">Explore Destinations</a>
            <a class="btn btn-outline" href="emergency.php">Emergency Contacts</a>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Plan Your Journey</h2>
            <p>Everything you need to make your Bislig adventure unforgettable.</p>
          </header>
          <div class="grid three">
            <a class="card" href="destinations.php">
              <div class="feature-icon" aria-hidden="true">🗺</div>
              <h3>Destinations</h3>
              <p>Discover breathtaking waterfalls, islands, caves, and natural wonders.</p>
            </a>
            <a class="card" href="restaurants.php">
              <div class="feature-icon" aria-hidden="true">🍽</div>
              <h3>Restaurants</h3>
              <p>Taste the authentic flavors of Bislig cuisine and seaside delights.</p>
            </a>
            <a class="card" href="accommodations.php">
              <div class="feature-icon" aria-hidden="true">🏨</div>
              <h3>Accommodations</h3>
              <p>Find comfortable stays that suit every traveler and budget.</p>
            </a>
            <a class="card" href="transportation.php">
              <div class="feature-icon" aria-hidden="true">🚐</div>
              <h3>Transportation</h3>
              <p>Navigate the city with ease using local transport tips and guides.</p>
            </a>
            <a class="card" href="attractions.php">
              <div class="feature-icon" aria-hidden="true">🧭</div>
              <h3>Attractions</h3>
              <p>Explore beaches, resorts, and adventure spots across Bislig.</p>
            </a>
            <a class="card" href="festivals.php">
              <div class="feature-icon" aria-hidden="true">🎉</div>
              <h3>Festivals</h3>
              <p>Experience vibrant culture through immersive celebrations and events.</p>
            </a>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Must-See Highlights</h2>
            <p>Don't miss these incredible natural wonders while you explore Bislig City.</p>
          </header>
          <div class="grid three">
            <?php
            include 'admin/database.php';
            $query = "SELECT d.id, d.name, d.description, d.location, d.image_url, d.rating AS admin_rating, IFNULL(AVG(r.rating), 0) AS avg_rating FROM destinations d LEFT JOIN ratings r ON d.id = r.item_id AND r.category = 'destination' GROUP BY d.id ORDER BY d.rating DESC LIMIT 3";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $img = !empty($row['image_url']) ? $row['image_url'] : 'assets/default.jpg';
                echo '<article class="card">';
                echo '<div class="destination-img-wrapper">';
                echo '<img class="destination-img" src="' . htmlspecialchars($img) . '" alt="' . htmlspecialchars($row['name']) . '" />';
                echo '</div>';
                echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '<div class="meta">';
                echo '<span>📍 ' . htmlspecialchars($row['location']) . '</span>';
                echo '<span class="rating-stars" data-id="' . $row['id'] . '">';
                $fullStars = floor($row['avg_rating']);
                $halfStar = ($row['avg_rating'] - $fullStars) >= 0.5 ? 1 : 0;
                for ($i = 1; $i <= 5; $i++) {
                  if ($i <= $fullStars) {
                    echo '<span class="star" data-value="'.$i.'">&#9733;</span>';
                  } elseif ($i == $fullStars + 1 && $halfStar) {
                    echo '<span class="star" data-value="'.$i.'">&#9733;</span>';
                  } else {
                    echo '<span class="star" data-value="'.$i.'">&#9734;</span>';
                  }
                }
                $displayRating = ($row['avg_rating'] > 0) ? $row['avg_rating'] : $row['admin_rating'];
                echo '<span class="rating-value">(' . number_format($displayRating, 1) . ')</span>';
                echo '</span>';
                echo '</div>';
                echo '</article>';
              }
            } else {
              echo '<p>No top-rated destinations available.</p>';
            }
            ?>
          </div>
          <div class="section-header" style="margin-top: 3rem;">
            <a class="btn btn-primary" href="destinations.php">View All Destinations</a>
          </div>
        </div>
      </section>
    </main>

    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold" style="font-size: clamp(2rem, 4vw, 2.6rem);">
          Ready to Explore Bislig City?
        </h2>
        <p>
          Start planning your adventure today. From pristine beaches to majestic waterfalls,
          unforgettable experiences await on the eastern Mindanao coast.
        </p>
        <div class="button-row">
          <a class="btn btn-secondary" href="accommodations.php">Book Accommodation</a>
          <a class="btn btn-outline" href="restaurants.php">Find Restaurants</a>
        </div>
      </div>
    </section>

   <?php include 'footer.php'; ?>
</html>
