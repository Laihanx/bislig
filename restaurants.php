<?php
// Fetch restaurants from database
include 'admin/database.php';
$result = mysqli_query($conn, "SELECT * FROM restaurants ORDER BY id DESC");

$pageTitle = 'Bislig Restaurants';
$pageDescription = 'Explore dining options in Bislig City, from seaside grills to cozy cafés serving local favorites.';
include 'header.php';
?>

    <main>
      <section class="page-hero" style="--hero-image: url('assets/hagonoy-island.jpg');">
        <div class="container">
          <h1>Restaurants &amp; Dining</h1>
          <p>Savor coastal flavors, fresh seafood, and hearty comfort meals across Bislig City.</p>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Featured Dining</h2>
            <p>From beachside grills to casual cafés, these spots capture the essence of Bislig cuisine.</p>
          </header>
          <div class="grid three">
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <article class="card">
                  <div class="flex-between">
                    <h3><?= htmlspecialchars($row['name']) ?></h3>
                    <?php if (!empty($row['badge'])): ?>
                      <span class="badge<?= ($row['badge'] === 'Barista Picks') ? ' blue' : '' ?>"><?= htmlspecialchars($row['badge']) ?></span>
                    <?php endif; ?>
                  </div>
                  <p><?= htmlspecialchars($row['description']) ?></p>
                  <div class="meta">
                    <span>📍 <?= htmlspecialchars($row['location']) ?></span>
                    <?php if (!empty($row['phone'])): ?>
                      <span>📞 <?= htmlspecialchars($row['phone']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($row['email'])): ?>
                      <span>✉️ <?= htmlspecialchars($row['email']) ?></span>
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
                <p>No restaurants available at the moment. Please check back later.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="card highlight">
            <h3>Dining Notes</h3>
            <p>
              Reserve tables for weekend dinners along the baywalk. Ask about seasonal seafood and locally sourced
              ingredients to support Bislig's fisherfolk and farmers.
            </p>
          </div>
        </div>
      </section>
    </main>

    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold">Pair your meals with a scenic stay.</h2>
        <p>Explore nearby accommodations and destinations to complete your Bislig food crawl.</p>
        <div class="button-row">
          <a class="btn btn-secondary" href="accommodations.php">View Accommodations</a>
          <a class="btn btn-outline" href="destinations.php">Plan Destinations</a>
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
        xhr.send('item_id=' + encodeURIComponent(itemId) + '&category=restaurant&rating=' + encodeURIComponent(rating));
      }
    });
  });
  </script>
  </body>
</html>
<?php mysqli_close($conn); ?>
