<?php
// Fetch transportation from database
include 'admin/database.php';
$result = mysqli_query($conn, "SELECT * FROM transportation ORDER BY rating DESC");

$pageTitle = 'Bislig Transportation';
$pageDescription = 'Navigate Bislig City with travel guides, airport connections, and local transport tips.';
include 'header.php';
?>

    <main>
      <section class="page-hero" style="--hero-image: url('assets/hagonoy-island.jpg');">
        <div class="container">
          <h1>Transportation Guide</h1>
          <p>Plan your journey to and around Bislig City with these travel connections and local options.</p>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>How to Reach Bislig</h2>
            <p>Fly via nearby hubs, then connect by land for a scenic trip to the City of the Ocean View.</p>
          </header>
          <div class="grid two">
            <article class="card highlight">
              <h3>Via Davao City</h3>
              <ul>
                <li>Daily flights to Davao International Airport from Manila and Cebu.</li>
                <li>Proceed to Ecoland Bus Terminal for air-conditioned buses to Mangagoy (approx. 6 hours).</li>
                <li>Private vans and ride-hailing services are also available at the terminal.</li>
              </ul>
            </article>
            <article class="card highlight">
              <h3>Via Butuan City</h3>
              <ul>
                <li>Flights to Butuan Bancasi Airport from Manila and Cebu multiple times daily.</li>
                <li>Catch a bus or van from the Integrated Bus Terminal to Mangagoy (approx. 5 hours).</li>
                <li>Reserve transport ahead to secure seats during peak travel months.</li>
              </ul>
            </article>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Local Transportation</h2>
            <p>Choose the best way to explore attractions, dine around the city, and travel between barangays.</p>
          </header>
          <div class="grid three">
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <article class="card">
                  <h3><?= htmlspecialchars($row['name']) ?></h3>
                  <p><?= htmlspecialchars($row['description']) ?></p>
                  <div class="meta">
                    <?php if (!empty($row['operating_hours'])): ?>
                      <span>⏱ <?= htmlspecialchars($row['operating_hours']) ?></span>
                    <?php endif; ?>
                    <span class="rating-stars" data-id="<?= $row['id'] ?>">
                      <?php
                        $fullStars = isset($row['rating']) ? floor($row['rating']) : 0;
                        $halfStar = (isset($row['rating']) && ($row['rating'] - $fullStars) >= 0.5) ? 1 : 0;
                        for ($i = 1; $i <= 5; $i++) {
                          if ($i <= $fullStars) {
                            echo '<span class="star" data-value="'.$i.'">&#9733;</span>';
                          } elseif ($i == $fullStars + 1 && $halfStar) {
                            echo '<span class="star" data-value="'.$i.'">&#9733;</span>';
                          } else {
                            echo '<span class="star" data-value="'.$i.'">&#9734;</span>';
                          }
                        }
                      ?>
                      <span class="rating-value">(<?= isset($row['rating']) ? number_format($row['rating'], 1) : '0.0' ?>)</span>
                    </span>
                  </div>
                </article>
              <?php endwhile; ?>
            <?php else: ?>
              <div class="card">
                <p>No transportation information available at the moment. Please check back later.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="card notice">
            <h3>Travel Reminders</h3>
            <ul>
              <li>Confirm weather updates before island trips and waterfall excursions.</li>
              <li>Keep small bills for tricycle and multicab fares.</li>
              <li>Coordinate return trips if visiting remote destinations in the late afternoon.</li>
            </ul>
          </div>
        </div>
      </section>
    </main>

    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold">Set your itinerary in motion.</h2>
        <p>Pair this transport guide with destination highlights and emergency contacts for peace of mind.</p>
        <div class="button-row">
          <a class="btn btn-secondary" href="destinations.php">See Destinations</a>
          <a class="btn btn-outline" href="emergency.php">Emergency Contacts</a>
        </div>
      </div>
    </section>

    <?php include 'footer.php'; ?>
  <script>
  document.querySelectorAll('.rating-stars').forEach(function(starContainer) {
    starContainer.addEventListener('click', function(e) {
      if (e.target.classList.contains('star')) {
        var itemId = starContainer.getAttribute('data-id');
        var rating = e.target.getAttribute('data-value');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_rating.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (xhr.status === 200) {
            location.reload();
          } else {
            alert('Failed to update rating');
          }
        };
        xhr.send('item_id=' + encodeURIComponent(itemId) + '&category=transportation&rating=' + encodeURIComponent(rating));
      }
    });
  });
  </script>
  </body>
</html>
<?php mysqli_close($conn); ?>
