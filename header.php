<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= SITE_NAME ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { font-family: 'Poppins', sans-serif; }
:root {
  --primary: #FF6B35;
  --secondary: #2C3E50;
  --accent: #27AE60;
  --light-bg: #FFF8F5;
}
body { background: var(--light-bg); }
.navbar { background: linear-gradient(135deg, var(--secondary), #34495E) !important; box-shadow: 0 2px 20px rgba(0,0,0,0.15); }
.navbar-brand { font-weight: 700; font-size: 1.5rem; color: white !important; }
.navbar-brand span { color: var(--primary); }
.nav-link { color: rgba(255,255,255,0.85) !important; font-weight: 500; transition: all 0.3s; }
.nav-link:hover { color: var(--primary) !important; }
.btn-primary { background: var(--primary); border-color: var(--primary); font-weight: 600; border-radius: 25px; padding: 8px 25px; }
.btn-primary:hover { background: #e55a2b; border-color: #e55a2b; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255,107,53,0.4); }
.btn-success { border-radius: 25px; font-weight: 600; }
.btn-outline-primary { border-color: var(--primary); color: var(--primary); border-radius: 25px; font-weight: 600; }
.btn-outline-primary:hover { background: var(--primary); color: white; }
.card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s; overflow: hidden; }
.card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(0,0,0,0.15); }
.pet-card img { height: 220px; object-fit: cover; width: 100%; }
.badge-species { background: var(--primary); color: white; border-radius: 20px; padding: 4px 12px; font-size: 0.75rem; }
.badge-available { background: #27AE60; color: white; border-radius: 20px; padding: 4px 12px; font-size: 0.75rem; }
.badge-pending { background: #F39C12; color: white; border-radius: 20px; padding: 4px 12px; font-size: 0.75rem; }
.badge-adopted { background: #95A5A6; color: white; border-radius: 20px; padding: 4px 12px; font-size: 0.75rem; }
.hero-section { background: linear-gradient(135deg, var(--secondary) 0%, #1a252f 100%); color: white; padding: 100px 0; position: relative; overflow: hidden; }
.section-title { font-weight: 700; color: var(--secondary); position: relative; padding-bottom: 15px; }
.section-title::after { content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 60px; height: 4px; background: var(--primary); border-radius: 2px; }
.stats-card { background: white; border-radius: 15px; padding: 30px; text-align: center; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
.stats-icon { font-size: 2.5rem; margin-bottom: 10px; }
.footer { background: var(--secondary); color: white; padding: 50px 0 20px; }
.alert { border-radius: 12px; border: none; }
.form-control, .form-select { border-radius: 10px; border: 2px solid #eee; padding: 12px 15px; transition: all 0.3s; }
.form-control:focus, .form-select:focus { border-color: var(--primary); box-shadow: 0 0 0 0.2rem rgba(255,107,53,0.25); }
.table { border-radius: 12px; overflow: hidden; }
.table thead { background: var(--secondary); color: white; }
.sidebar-card { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); margin-bottom: 20px; }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="/pet-adoption/"><i class="fas fa-paw me-2"></i>Pet<span>Adopt</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon" style="filter:invert(1)"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/pet-adoption/"><i class="fas fa-home me-1"></i>Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/pet-adoption/pets.php"><i class="fas fa-dog me-1"></i>Pets</a></li>
        <?php if(isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><a class="nav-link" href="/pet-adoption/dashboard.php"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a></li>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="fas fa-cog me-1"></i>Admin</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/pet-adoption/admin/add_pet.php"><i class="fas fa-plus me-2"></i>Add Pet</a></li>
            <li><a class="dropdown-item" href="/pet-adoption/admin/manage_pets.php"><i class="fas fa-list me-2"></i>Manage Pets</a></li>
            <li><a class="dropdown-item" href="/pet-adoption/admin/manage_requests.php"><i class="fas fa-clipboard-list me-2"></i>Requests</a></li>
            <li><a class="dropdown-item" href="/pet-adoption/admin/manage_users.php"><i class="fas fa-users me-2"></i>Users</a></li>
          </ul>
        </li>
        <?php endif; ?>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav">
        <?php if(isset($_SESSION['user_id'])): ?>
        <li class="nav-item"><span class="nav-link text-warning"><i class="fas fa-user-circle me-1"></i><?= htmlspecialchars($_SESSION['name']) ?></span></li>
        <li class="nav-item"><a class="btn btn-primary ms-2" href="/pet-adoption/logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout</a></li>
        <?php else: ?>
        <li class="nav-item"><a class="nav-link" href="/pet-adoption/login.php"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
        <li class="nav-item"><a class="btn btn-primary ms-2" href="/pet-adoption/register.php"><i class="fas fa-user-plus me-1"></i>Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
