<?php include 'header.php'; ?>
<?php
$id = intval($_GET['id'] ?? 0);
$pet = $conn->query("SELECT * FROM pets WHERE id=$id")->fetch_assoc();
if(!$pet) { echo "<div class='container py-5 text-center'><h3>Pet not found</h3></div>"; include 'footer.php'; exit; }

$msg = '';
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $pid = $id;
    $message = $conn->real_escape_string($_POST['message'] ?? '');
    $existing = $conn->query("SELECT id FROM adoption_requests WHERE user_id=$uid AND pet_id=$pid")->num_rows;
    if($existing > 0) {
        $msg = '<div class="alert alert-warning"><i class="fas fa-exclamation-circle me-2"></i>Aapne pehle se request kar di hai is pet ke liye!</div>';
    } else {
        $conn->query("INSERT INTO adoption_requests (user_id, pet_id, message) VALUES ($uid, $pid, '$message')");
        $conn->query("UPDATE pets SET status='Pending' WHERE id=$pid");
        $msg = '<div class="alert alert-success"><i class="fas fa-check-circle me-2"></i>Adoption request successfully bheji gayi! Admin se approval ka wait karo.</div>';
    }
}
$has_img = file_exists('/var/www/html/pet-adoption/uploads/'.$pet['image']);
if($has_img) {
  $img_src = '/pet-adoption/uploads/'.$pet['image'];
} elseif($pet['species']=='Cat') {
  $img_src = 'https://cataas.com/cat?width=600&height=400';
} elseif($pet['species']=='Bird') {
  $img_src = 'https://picsum.photos/seed/bird'.$pet['id'].'/600/400';
} elseif($pet['species']=='Rabbit') {
  $img_src = 'https://picsum.photos/seed/rabbit'.$pet['id'].'/600/400';
} else {
  $img_src = 'https://placedog.net/600/400?id='.$pet['id'];
}
?>

<div class="container py-5">
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/pet-adoption/" class="text-decoration-none" style="color:var(--primary)">Home</a></li>
      <li class="breadcrumb-item"><a href="/pet-adoption/pets.php" class="text-decoration-none" style="color:var(--primary)">Pets</a></li>
      <li class="breadcrumb-item active"><?= htmlspecialchars($pet['name']) ?></li>
    </ol>
  </nav>

  <div class="row g-4">
    <div class="col-lg-5">
      <img src="<?= $img_src ?>" class="img-fluid rounded-4 shadow w-100" style="max-height:420px;object-fit:cover" alt="<?= $pet['name'] ?>">
    </div>
    <div class="col-lg-7">
      <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
        <h2 class="fw-bold mb-0"><?= htmlspecialchars($pet['name']) ?></h2>
        <span class="badge-species"><?= $pet['species'] ?></span>
        <span class="badge-<?= strtolower($pet['status']) ?>"><?= $pet['status'] ?></span>
      </div>
      <p class="text-muted fs-5 mb-4"><?= htmlspecialchars($pet['breed']) ?></p>

      <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
          <div class="sidebar-card text-center">
            <div style="font-size:1.5rem">🎂</div>
            <small class="text-muted d-block">Age</small>
            <strong><?= $pet['age'] ?> yrs</strong>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sidebar-card text-center">
            <div style="font-size:1.5rem"><?= $pet['gender']=='Male'?'♂️':'♀️' ?></div>
            <small class="text-muted d-block">Gender</small>
            <strong><?= $pet['gender'] ?></strong>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sidebar-card text-center">
            <div style="font-size:1.5rem">📏</div>
            <small class="text-muted d-block">Size</small>
            <strong><?= $pet['size'] ?></strong>
          </div>
        </div>
        <div class="col-6 col-md-3">
          <div class="sidebar-card text-center">
            <div style="font-size:1.5rem">🎨</div>
            <small class="text-muted d-block">Color</small>
            <strong><?= $pet['color'] ?></strong>
          </div>
        </div>
      </div>

      <h5 class="fw-bold">About <?= htmlspecialchars($pet['name']) ?></h5>
      <p class="text-muted"><?= htmlspecialchars($pet['description']) ?></p>

      <?= $msg ?>

      <?php if($pet['status'] == 'Available'): ?>
        <?php if(isset($_SESSION['user_id'])): ?>
        <button class="btn btn-primary btn-lg px-5" data-bs-toggle="modal" data-bs-target="#adoptModal">
          <i class="fas fa-heart me-2"></i>Adopt <?= htmlspecialchars($pet['name']) ?>
        </button>
        <?php else: ?>
        <div class="alert alert-info">
          <i class="fas fa-info-circle me-2"></i>Adopt karne ke liye pehle
          <a href="/pet-adoption/login.php" class="fw-bold">Login karo</a> ya
          <a href="/pet-adoption/register.php" class="fw-bold">Register karo</a>
        </div>
        <?php endif; ?>
      <?php else: ?>
      <div class="alert alert-warning"><i class="fas fa-clock me-2"></i>Yeh pet abhi <?= $pet['status'] ?> hai.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="modal fade" id="adoptModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold"><i class="fas fa-paw me-2" style="color:var(--primary)"></i>Adopt <?= htmlspecialchars($pet['name']) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST">
        <div class="modal-body">
          <div class="text-center mb-3">
            <img src="<?= $img_src ?>" class="rounded-3" style="width:100%;height:180px;object-fit:cover" alt="">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Apna message likho <span class="text-danger">*</span></label>
            <textarea name="message" class="form-control" rows="4" required placeholder="Aap kyun adopt karna chahte ho? Ghar ka environment kaisa hai? Previous pet experience hai?"></textarea>
          </div>
          <div class="alert alert-light small">
            <i class="fas fa-info-circle text-primary me-1"></i>
            Request bhejne ke baad admin review karega aur aapko approve/reject karega.
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary px-4"><i class="fas fa-paper-plane me-2"></i>Request Bhejo</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
