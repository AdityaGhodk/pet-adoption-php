<?php include 'header.php'; ?>
<?php
$stats_pets = $conn->query("SELECT COUNT(*) as c FROM pets WHERE status='Available'")->fetch_assoc()['c'];
$stats_adopted = $conn->query("SELECT COUNT(*) as c FROM pets WHERE status='Adopted'")->fetch_assoc()['c'];
$stats_users = $conn->query("SELECT COUNT(*) as c FROM users WHERE role='user'")->fetch_assoc()['c'];
$featured = $conn->query("SELECT * FROM pets WHERE status='Available' ORDER BY RAND() LIMIT 6");
?>

<section class="hero-section text-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h1 class="display-4 fw-bold mb-3">🐾 Apna Perfect Pet Dhundo</h1>
        <p class="lead mb-4 text-white-50">Hazaron pyaare pets aapka intezaar kar rahe hain. Unhe ek loving home do aur unki zindagi badal do.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
          <a href="/pet-adoption/pets.php" class="btn btn-primary btn-lg px-5"><i class="fas fa-search me-2"></i>Pets Browse Karo</a>
          <a href="/pet-adoption/register.php" class="btn btn-outline-light btn-lg px-5"><i class="fas fa-heart me-2"></i>Join Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 bg-white">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="stats-card">
          <div class="stats-icon">🐕</div>
          <h2 class="fw-bold" style="color:var(--primary)"><?= $stats_pets ?>+</h2>
          <p class="text-muted mb-0">Pets Available</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stats-card">
          <div class="stats-icon">🏠</div>
          <h2 class="fw-bold" style="color:var(--accent)"><?= $stats_adopted ?>+</h2>
          <p class="text-muted mb-0">Successfully Adopted</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stats-card">
          <div class="stats-icon">👥</div>
          <h2 class="fw-bold" style="color:var(--secondary)"><?= $stats_users ?>+</h2>
          <p class="text-muted mb-0">Happy Adopters</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center mb-5">Featured Pets 🐾</h2>
    <div class="row g-4">
      <?php while($pet = $featured->fetch_assoc()): ?>
      <div class="col-lg-4 col-md-6">
        <div class="card pet-card h-100">
          <div class="position-relative">
            <?php
            $has_img = file_exists('/var/www/html/pet-adoption/uploads/'.$pet['image']);
            $img_src = $has_img ? '/pet-adoption/uploads/'.$pet['image'] : 'https://placedog.net/400/300?id='.$pet['id'];
            if($pet['species']=='Cat') $img_src = $has_img ? '/pet-adoption/uploads/'.$pet['image'] : 'https://cataas.com/cat?width=400&height=300';
            if($pet['species']=='Bird') $img_src = 'https://picsum.photos/seed/bird'.$pet['id'].'/400/300';
            if($pet['species']=='Rabbit') $img_src = 'https://picsum.photos/seed/rabbit'.$pet['id'].'/400/300';
            if($pet['species']=='Other') $img_src = 'https://picsum.photos/seed/pet'.$pet['id'].'/400/300';
            ?>
            <img src="<?= $img_src ?>" class="card-img-top" alt="<?= $pet['name'] ?>" style="height:220px;object-fit:cover">
            <span class="position-absolute top-0 end-0 m-2 badge-species"><?= $pet['species'] ?></span>
            <span class="position-absolute top-0 start-0 m-2 badge-available"><?= $pet['status'] ?></span>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <h5 class="card-title fw-bold mb-0"><?= htmlspecialchars($pet['name']) ?></h5>
              <small class="text-muted"><i class="fas fa-birthday-cake me-1"></i><?= $pet['age'] ?> yr</small>
            </div>
            <p class="text-muted small mb-1"><i class="fas fa-dog me-1" style="color:var(--primary)"></i><?= htmlspecialchars($pet['breed']) ?></p>
            <p class="text-muted small mb-2"><i class="fas fa-venus-mars me-1" style="color:var(--primary)"></i><?= $pet['gender'] ?> &bull; <?= $pet['size'] ?></p>
            <p class="card-text small text-muted"><?= substr(htmlspecialchars($pet['description']),0,80) ?>...</p>
          </div>
          <div class="card-footer bg-white border-0 pb-3">
            <a href="/pet-adoption/pet_detail.php?id=<?= $pet['id'] ?>" class="btn btn-primary w-100">
              <i class="fas fa-heart me-2"></i>Adopt <?= htmlspecialchars($pet['name']) ?>
            </a>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
    <div class="text-center mt-4">
      <a href="/pet-adoption/pets.php" class="btn btn-outline-primary btn-lg px-5">
        <i class="fas fa-paw me-2"></i>Saare Pets Dekho
      </a>
    </div>
  </div>
</section>

<section class="py-5 bg-white">
  <div class="container">
    <h2 class="section-title text-center mb-5">Adoption Process 📋</h2>
    <div class="row g-4 text-center">
      <div class="col-md-3">
        <div class="p-4">
          <div style="width:70px;height:70px;background:linear-gradient(135deg,var(--primary),#ff8c5a);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:1.8rem;color:white;font-weight:bold;">1</div>
          <h5 class="fw-bold">Register Karo</h5>
          <p class="text-muted small">Pehle account banao aur apni details fill karo</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4">
          <div style="width:70px;height:70px;background:linear-gradient(135deg,#3498DB,#5DADE2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:1.8rem;color:white;font-weight:bold;">2</div>
          <h5 class="fw-bold">Pet Dhundo</h5>
          <p class="text-muted small">Browse karo aur apna perfect pet choose karo</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4">
          <div style="width:70px;height:70px;background:linear-gradient(135deg,#27AE60,#2ECC71);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:1.8rem;color:white;font-weight:bold;">3</div>
          <h5 class="fw-bold">Request Bhejo</h5>
          <p class="text-muted small">Adoption request bhejo aur message likho</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4">
          <div style="width:70px;height:70px;background:linear-gradient(135deg,#9B59B6,#BB8FCE);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:1.8rem;color:white;font-weight:bold;">4</div>
          <h5 class="fw-bold">Ghar Le Jao! 🏠</h5>
          <p class="text-muted small">Approval ke baad apne naye family member ko ghar le jao</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
