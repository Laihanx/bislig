<?php
// Fetch accommodations from database
include 'admin/database.php';
$result = mysqli_query($conn, "SELECT * FROM accommodations ORDER BY rating DESC");

$pageTitle = 'Bislig Accommodations';
$pageDescription = 'Browse Bislig City\'s hotels, resorts, and homestays for every traveler.';
include 'header.php';
?>

    <main>
      <section class="page-hero" style="--hero-image: url('assets/tinuyan-falls-hero.jpg');">
        <div class="container">
          <h1>Accommodations</h1>
          <p>Find the perfect stay, from eco-resorts to family-friendly inns throughout Bislig City.</p>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Featured Stays</h2>
            <p>Select from curated lodgings with easy access to waterfalls, islands, and city conveniences.</p>
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
                    <?php if (!empty($row['phone'])): ?>
                      <span>📞 <?= htmlspecialchars($row['phone']) ?></span>
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
                <p>No accommodations available at the moment. Please check back later.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="card highlight">
            <h3>Booking Tips</h3>
            <p>
              Reserve accommodations at least two weeks ahead during festival season. Coordinate transport with your
              host for early Tinuy-an Falls trips and island transfers.
            </p>
          </div>
        </div>
      </section>
    </main>

    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold">Need help planning your route?</h2>
        <p>Check local transportation guides and emergency contacts for a smooth stay in Bislig.</p>
        <div class="button-row">
          <a class="btn btn-secondary" href="transportation.php">Transportation Guide</a>
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
        xhr.send('item_id=' + encodeURIComponent(itemId) + '&category=accommodation&rating=' + encodeURIComponent(rating));
      }
    });
  });
  </script>
  </body>
</html>
<?php mysqli_close($conn); ?>
