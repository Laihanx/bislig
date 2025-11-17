<?php
// Fetch festivals from database
include 'admin/database.php';
$result = mysqli_query($conn, "SELECT * FROM festivals ORDER BY id DESC");

$pageTitle = 'Bislig Festivals';
$pageDescription = 'Celebrate Bislig City\'s vibrant culture with festival highlights and barangay fiesta schedules.';
include 'header.php';
?>

    <main>
      <section class="page-hero" style="--hero-image: url('assets/tinuyan-falls-hero.jpg');">
        <div class="container">
          <h1>Festivals &amp; Celebrations</h1>
          <p>Experience Bislig City's vibrant culture through dance, music, and faith-filled traditions.</p>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Festival Calendar</h2>
            <p>Mark your calendar for the biggest cultural events and signature celebrations in Bislig.</p>
          </header>
          <div class="grid three">
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <article class="card">
                  <h3><?= htmlspecialchars($row['name']) ?></h3>
                  <div class="meta">
                    <span>📍 <?= htmlspecialchars($row['location']) ?></span>
                    <?php if (!empty($row['date'])): ?>
                      <span>🗓 <?= htmlspecialchars($row['date']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($row['patron_saint'])): ?>
                      <span>🙏 Patron Saint: <?= htmlspecialchars($row['patron_saint']) ?></span>
                    <?php endif; ?>
                  </div>
                  <p><?= htmlspecialchars($row['description']) ?></p>
                </article>
              <?php endwhile; ?>
            <?php else: ?>
              <div class="card">
                <p>No festivals available at the moment. Please check back later.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="card notice">
            <h3>Festival Reminders</h3>
            <ul>
              <li>Confirm exact schedules with the local tourism office as dates may adjust yearly.</li>
              <li>Book accommodations early during peak festival weeks.</li>
              <li>Respect local customs and join community clean-up efforts after events.</li>
            </ul>
          </div>
        </div>
      </section>
    </main>

    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold">Make the most of every celebration.</h2>
        <p>Pair festival visits with nearby attractions and dining recommendations for a memorable trip.</p>
        <div class="button-row">
          <a class="btn btn-secondary" href="accommodations.php">Book Your Stay</a>
          <a class="btn btn-outline" href="restaurants.php">Where to Eat</a>
        </div>
      </div>
    </section>

    <?php include 'footer.php'; ?>
  </body>
</html>
<?php mysqli_close($conn); ?>
