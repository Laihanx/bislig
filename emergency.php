<?php
// Fetch emergency contacts from database
include 'admin/database.php';
$result = mysqli_query($conn, "SELECT * FROM emergency_contacts ORDER BY id ASC");

$pageTitle = 'Bislig Emergency Contacts';
$pageDescription = 'Keep critical emergency contacts handy for Bislig City\'s tourism office, hospitals, and first responders.';
include 'header.php';
?>

    <main>
      <section
        class="page-hero"
        style="--hero-image: linear-gradient(135deg, rgba(29,78,216,0.82), rgba(15,159,110,0.82));"
      >
        <div class="container">
          <h1>Emergency Contacts</h1>
          <p>Important numbers for assistance, safety, and tourism support within Bislig City.</p>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <header class="section-header">
            <h2>Key Hotlines</h2>
            <p>Dial these numbers immediately for emergencies, medical assistance, and city coordination.</p>
          </header>
          <div class="grid two">
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <article class="card">
                  <div class="contact-card">
                    <strong><?= htmlspecialchars($row['name']) ?></strong>
                    <p class="text-large weight-medium"><?= htmlspecialchars($row['phone']) ?></p>
                    <?php if (!empty($row['description'])): ?>
                      <div class="text-small text-muted"><?= htmlspecialchars($row['description']) ?></div>
                    <?php endif; ?>
                  </div>
                </article>
              <?php endwhile; ?>
            <?php else: ?>
              <div class="card">
                <p>No emergency contacts available at the moment. Please check back later.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="card notice">
            <h3>Safety Reminders</h3>
            <ul>
              <li>Share your itinerary with companions or your lodging host before tours.</li>
              <li>Store contacts offline in case of network disruptions.</li>
              <li>Follow local guidelines during weather advisories and coastal trips.</li>
            </ul>
          </div>
        </div>
      </section>
    </main>

    <section class="cta-section">
      <div class="container">
        <h2 class="weight-semibold">Stay informed while you explore.</h2>
        <p>Review transportation routes and accommodation picks to keep your Bislig adventure stress-free.</p>
        <div class="button-row">
          <a class="btn btn-secondary" href="transportation.php">Transportation Guide</a>
          <a class="btn btn-outline" href="accommodations.php">Accommodations</a>
        </div>
      </div>
    </section>

    <?php include 'footer.php'; ?>
  </body>
</html>
<?php mysqli_close($conn); ?>
