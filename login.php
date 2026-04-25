<?php include 'header.php'; ?>
<?php
$error = '';
if($_SERVER['REQUEST_METHOD']=='POST') {
    $email = $conn->real_escape_string(trim($_POST['email']));
    $pass = $_POST['password'];
    $user = $conn->query("SELECT * FROM users WHERE email='$email'")->fetch_assoc();
    if($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        if($user['role']=='admin') {
            header('Location: /pet-adoption/admin/dashboard.php');
        } else {
            header('Location: /pet-adoption/dashboard.php');
        }
        exit;
    } else {
        $error = 'Email ya password galat hai!';
    }
}
?>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
      <div class="card p-4">
        <div class="text-center mb-4">
          <div style="font-size:3rem">🔐</div>
          <h3 class="fw-bold">Welcome Back!</h3>
          <p class="text-muted">Login karo aur pets adopt karo</p>
        </div>
        <?php if($error): ?><div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i><?= $error ?></div><?php endif; ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
              <input type="email" name="email" class="form-control border-start-0" placeholder="aap@example.com" required>
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold">Password</label>
            <div class="input-group">
              <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
              <input type="password" name="password" class="form-control border-start-0" placeholder="Password" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="fas fa-sign-in-alt me-2"></i>Login</button>
        </form>
        <div class="mt-3 p-3 rounded-3" style="background:#FFF8F5;border:1px dashed var(--primary)">
          <small><strong>🔑 Admin Login:</strong><br>
          Email: admin@petadopt.com<br>
          Password: password</small>
        </div>
        <p class="text-center mt-3 text-muted">Account nahi hai? <a href="register.php" class="fw-bold" style="color:var(--primary)">Register karo</a></p>
      </div>
    </div>
  </div>
</div>
<?php include 'footer.php'; ?>
