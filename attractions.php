<?php
// Fetch attractions from database
include 'admin/database.php';
$result = mysqli_query($conn, "SELECT * FROM attractions ORDER BY rating DESC");

$pageTitle = 'Bislig Attractions';
$pageDescription = 'Discover Bislig City\'s attractions including adventure parks, eco resorts, and beachfront escapes.';
include 'header.php';
?>

    <main>
      <section class="page-hero" style="--hero-image: url('assets/hinayagan-cave.jpg');">
        <div class="container">
          <h1>Tourist Attractions</h1>
          <p>Find resorts, eco-adventures, and unique experiences that showcase Bislig's charm.</p>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Resorts &amp; Experiences</h2>
            <p>Mix relaxation and thrill with these curated attractions across Bislig City and nearby towns.</p>
          </header>
          <div class="grid three">
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <article class="card">
                  <div class="flex-between">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <?php if (!empty($row['badge'])): ?>
                      <span class="badge"><?= htmlspecialchars($row['badge']) ?></span>
                    <?php endif; ?>
                  </div>
                  <p><?= htmlspecialchars($row['description']) ?></p>
                  <div class="meta">
                    <span>📍 <?= htmlspecialchars($row['location']) ?></span>
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
                <p>No attractions available at the moment. Please check back later.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="card highlight">
            <h3>Plan Ahead</h3>
            <p>
              Check operating schedules before visiting adventure sites. Most attractions accept walk-ins but recommend
              reservations for large groups and weekend trips.
            </p>
          </div>
        </div>
      </section>
    </main>

    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold">Ready to explore more?</h2>
        <p>Pair these attractions with our destination highlights and festival calendar for a full itinerary.</p>
        <div class="button-row">
          <a class="btn btn-secondary" href="destinations.php">Destinations Guide</a>
          <a class="btn btn-outline" href="festivals.php">Festival Calendar</a>
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
        xhr.send('item_id=' + encodeURIComponent(itemId) + '&category=attraction&rating=' + encodeURIComponent(rating));
      }
    });
  });
  </script>
  </body>
</html>
<?php mysqli_close($conn); ?>
