<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>SLIATE Login Portal</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
<style>
  body {
    background: #121212;
    color: #eee;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    flex-direction: column;
  }
  .container {
    text-align: center;
  }
  h1 {
    margin-bottom: 40px;
    color: #00ffd2;
    font-weight: 700;
  }
  .btn-role {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    margin: 10px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 30px;
    color: #121212;
    text-decoration: none;
    box-shadow: 0 0 15px #00ffd2;
    transition: background-color 0.3s ease;
  }
  .btn-student {
    background-color: #1e90ff; /* blue */
  }
  .btn-student:hover {
    background-color: #1c86ee;
  }
  .btn-admin {
    background-color: #28a745; /* green */
  }
  .btn-admin:hover {
    background-color: #218838;
  }
  .btn-lecturer {
    background-color: #ffc107; /* amber */
    color: #121212;
  }
  .btn-lecturer:hover {
    background-color: #e0a800;
  }
  /* Badge style for icon */
  .btn-role i {
    background: rgba(0,0,0,0.3);
    padding: 10px;
    border-radius: 50%;
    font-size: 24px;
    color: #fff;
    box-shadow: 0 0 10px #00ffd2;
  }
  .footer {
    margin-top: 60px;
    font-weight: 600;
    color: #00ffd2;
  }
</style>
</head>
<body>

<div class="container">
  <h1>SLIATE | LOGIN PORTAL</h1>
  <a href="auth/login.php?role=student" class="btn-role btn-student">
    <i class="fas fa-user-graduate"></i> Student Login
  </a>
  <a href="auth/login.php?role=admin" class="btn-role btn-admin">
    <i class="fas fa-user-shield"></i> Admin Login
  </a>
  <a href="auth/login.php?role=lecturer" class="btn-role btn-lecturer">
    <i class="fas fa-chalkboard-teacher"></i> Lecturer Login
  </a>
  <div class="footer">&copy; <?= date('Y') ?> SLIATE Nawalapitiya </div>
</div>
</body>
</html>
