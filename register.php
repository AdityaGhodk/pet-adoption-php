<?php include 'header.php'; ?>
<?php
$error = $success = '';
if($_SERVER['REQUEST_METHOD']=='POST') {
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    if(strlen($name) < 2) $error = 'Name kam se kam 2 characters hona chahiye.';
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) $error = 'Valid email address daliye.';
    elseif(strlen($pass) < 6) $error = 'Password kam se kam 6 characters hona chahiye.';
    elseif($pass !== $confirm) $error = 'Password match nahi kar raha!';
    else {
        $exists = $conn->query("SELECT id FROM users WHERE email='$email'")->num_rows;
        if($exists) $error = 'Yeh email already registered hai!';
        else {
            $hashed = password_hash($pass, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed')");
            $success = 'Registration successful! Ab login karo.';
        }
    }
}
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card p-4">
        <div class="text-center mb-4">
          <div style="font-size:3rem">🐾</div>
          <h3 class="fw-bold">Join PetAdopt</h3>
          <p class="text-muted">Account banao aur pets adopt karo</p>
        </div>
        <?php if($error): ?><div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= $error ?></div><?php endif; ?>
        <?php if($success): ?><div class="alert alert-success"><i class="fas fa-check-circle me-2"></i><?= $success ?> <a href="login.php">Login karo</a></div><?php endif; ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Full Name</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
              <input type="text" name="name" class="form-control border-start-0" placeholder="Aapka naam" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email Address</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
              <input type="email" name="email" class="form-control border-start-0" placeholder="aap@example.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
              <input type="password" name="password" class="form-control border-start-0" placeholder="Min 6 characters" required>
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold">Confirm Password</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
              <input type="password" name="confirm_password" class="form-control border-start-0" placeholder="Password dobara daliye" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="fas fa-user-plus me-2"></i>Register Karo</button>
        </form>
        <p class="text-center mt-3 text-muted">Already account hai? <a href="login.php" class="fw-bold" style="color:var(--primary)">Login karo</a></p>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
