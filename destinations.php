<?php
// Fetch destinations from database
include 'admin/database.php';
$result = mysqli_query($conn, "SELECT * FROM destinations ORDER BY rating DESC");

$pageTitle = 'Bislig Destinations';
$pageDescription = 'Discover the top tourist destinations in Bislig City, including waterfalls, caves, islands, and eco-adventures.';
include 'header.php';
?>

    <main>
      <section
        class="page-hero"
        style="--hero-image: url('assets/tinuyan-falls-hero.jpg');"
      >
        <div class="container">
          <h1>Tourist Destinations</h1>
          <p>Explore cascading waterfalls, island escapes, and eco-tour experiences that define Bislig City.</p>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Signature Spots</h2>
            <p>Plan your itinerary around these crowd favorites and hidden treasures across Bislig.</p>
          </header>
          <div class="grid three">
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <article class="card">
                  <div class="destination-img-wrapper">
                    <?php if (!empty($row['image_url'])): ?>
                      <img class="destination-img" src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" />
                    <?php else: ?>
                      <div class="destination-img placeholder">
                        <span style="font-size:4rem;color:#bbb;">&#128247;</span>
                      </div>
                    <?php endif; ?>
                  </div>
                  <h3><?= htmlspecialchars($row['name']) ?></h3>
                  <p><?= htmlspecialchars($row['description']) ?></p>
                  <div class="meta">
                    <span>📍 <?= htmlspecialchars($row['location']) ?></span>
                    <span class="rating-stars" data-id="<?= $row['id'] ?>">
                      <?php
                        $fullStars = floor($row['rating']);
                        $halfStar = ($row['rating'] - $fullStars) >= 0.5 ? 1 : 0;
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
                      <span class="rating-value">(<?= number_format($row['rating'], 1) ?>)</span>
                    </span>
                  </div>
                </article>
              <?php endwhile; ?>
            <?php else: ?>
              <div class="card">
                <p>No destinations available at the moment. Please check back later.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="card highlight">
            <h3>Insider Tip</h3>
            <p>
              Schedule your visit to Tinuy-an Falls between 7:00 AM and 9:00 AM to witness vivid rainbows.
              Arrange boats to Hagonoy Island in advance, especially on weekends and holidays.
            </p>
          </div>
        </div>
      </section>
    </main>

    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold">Ready for an island-hopping adventure?</h2>
        <p>Combine the falls, caves, and beach tours with a weekend stay for the full Bislig experience.</p>
        <div class="button-row">
          <a class="btn btn-secondary" href="accommodations.php">Browse Accommodations</a>
          <a class="btn btn-outline" href="restaurants.php">Find Local Dining</a>
        </div>
      </div>
    </section>

    <?php include 'footer.php'; ?>
  <style>
    .destination-img-wrapper {
      width: 100%;
      aspect-ratio: 16/9;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #f3f3f3;
      border-radius: 12px 12px 0 0;
      overflow: hidden;
      margin-bottom: 12px;
      position: relative;
    }
    .destination-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      border-radius: 12px 12px 0 0;
      display: block;
    }
    .destination-img.placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: #e0e0e0;
      border-radius: 12px 12px 0 0;
    }
  </style>
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
        xhr.send('item_id=' + encodeURIComponent(itemId) + '&category=destination&rating=' + encodeURIComponent(rating));
      }
    });
  });
  </script>
  </body>
</html>
<?php mysqli_close($conn); ?>
