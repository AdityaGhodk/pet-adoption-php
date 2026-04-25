<?php include 'header.php'; ?>
<?php
if(!isset($_SESSION['user_id'])) { header('Location: /pet-adoption/login.php'); exit; }
$uid = $_SESSION['user_id'];
$requests = $conn->query("SELECT ar.*, p.name as pet_name, p.breed, p.species, p.image, p.status as pet_status
    FROM adoption_requests ar JOIN pets p ON ar.pet_id=p.id WHERE ar.user_id=$uid ORDER BY ar.created_at DESC");
$total_req = $conn->query("SELECT COUNT(*) as c FROM adoption_requests WHERE user_id=$uid")->fetch_assoc()['c'];
$approved = $conn->query("SELECT COUNT(*) as c FROM adoption_requests WHERE user_id=$uid AND status='Approved'")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) as c FROM adoption_requests WHERE user_id=$uid AND status='Pending'")->fetch_assoc()['c'];
$rejected = $conn->query("SELECT COUNT(*) as c FROM adoption_requests WHERE user_id=$uid AND status='Rejected'")->fetch_assoc()['c'];
?>
<div class="container py-5">
  <div class="row mb-4">
    <div class="col">
      <h3 class="fw-bold"><i class="fas fa-tachometer-alt me-2" style="color:var(--primary)"></i>My Dashboard</h3>
      <p class="text-muted">Welcome back, <strong><?= htmlspecialchars($_SESSION['name']) ?></strong>! 👋</p>
    </div>
    <div class="col-auto">
      <a href="/pet-adoption/pets.php" class="btn btn-primary"><i class="fas fa-search me-2"></i>New Pet Dhundo</a>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stats-card"><div class="stats-icon">📋</div><h3 class="fw-bold" style="color:var(--primary)"><?= $total_req ?></h3><p class="text-muted mb-0">Total Requests</p></div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stats-card"><div class="stats-icon">✅</div><h3 class="fw-bold" style="color:var(--accent)"><?= $approved ?></h3><p class="text-muted mb-0">Approved</p></div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stats-card"><div class="stats-icon">⏳</div><h3 class="fw-bold text-warning"><?= $pending ?></h3><p class="text-muted mb-0">Pending</p></div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stats-card"><div class="stats-icon">❌</div><h3 class="fw-bold text-danger"><?= $rejected ?></h3><p class="text-muted mb-0">Rejected</p></div>
    </div>
  </div>

  <div class="card">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2" style="color:var(--primary)"></i>My Adoption Requests</h5>
    </div>
    <div class="card-body p-0">
      <?php if($total_req == 0): ?>
      <div class="text-center py-5">
        <div style="font-size:4rem">🐾</div>
        <h5 class="text-muted">Abhi koi request nahi hai</h5>
        <p class="text-muted">Koi pet adopt karo aur request bhejo!</p>
        <a href="/pet-adoption/pets.php" class="btn btn-primary mt-2"><i class="fas fa-search me-2"></i>Pets Browse Karo</a>
      </div>
      <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th>Pet</th>
              <th>Breed</th>
              <th>Species</th>
              <th>Request Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php while($req = $requests->fetch_assoc()): ?>
          <tr>
            <td>
              <div class="d-flex align-items-center gap-2">
                <?php
                $has = file_exists('/var/www/html/pet-adoption/uploads/'.$req['image']);
                if($has) $src = '/pet-adoption/uploads/'.$req['image'];
                elseif($req['species']=='Cat') $src = 'https://cataas.com/cat?width=50&height=50';
                else $src = 'https://placedog.net/50/50?id='.$req['pet_id'];
                ?>
                <img src="<?= $src ?>" class="rounded-circle" width="45" height="45" style="object-fit:cover">
                <strong><?= htmlspecialchars($req['pet_name']) ?></strong>
              </div>
            </td>
            <td><?= htmlspecialchars($req['breed']) ?></td>
            <td><span class="badge-species"><?= $req['species'] ?></span></td>
            <td><?= date('d M Y', strtotime($req['created_at'])) ?></td>
            <td>
              <?php
              $badges = ['Pending'=>'warning','Approved'=>'success','Rejected'=>'danger'];
              $icons = ['Pending'=>'clock','Approved'=>'check-circle','Rejected'=>'times-circle'];
              $s = $req['status'];
              ?>
              <span class="badge bg-<?= $badges[$s] ?>"><i class="fas fa-<?= $icons[$s] ?> me-1"></i><?= $s ?></span>
            </td>
            <td>
              <a href="/pet-adoption/pet_detail.php?id=<?= $req['pet_id'] ?>" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-eye me-1"></i>View
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
