<?php
session_start();
require_once '../includes/db.php';


$role = $_GET['role'] ?? '';
$valid_roles = ['student', 'admin', 'lecturer'];

if (!in_array($role, $valid_roles)) {
    die('Invalid user role.');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // ✅ Fixed: match by Username, not user_id
    $stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND Role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        // ✅ Secure password check
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['user_role'] = $user['Role'];

            // ✅ Redirect
            $redirect_paths = [
                'student' => '../student/dashboard.php',
                'admin' => '../admin/dashboard.php',
                'lecturer' => '../lecturer/dashboard.php'
            ];
            header("Location: " . $redirect_paths[$role]);
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Login - <?= ucfirst(htmlspecialchars($role)) ?> Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background: #121212;
            color: #eee;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: #1e1e1e;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 0 30px #00ffd2;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            color: #00ffd2;
            text-align: center;
            font-weight: 700;
            margin-bottom: 30px;
        }
        .form-label {
            color: #ccc;
        }
        .form-control {
            background: #222;
            border: none;
            color: #eee;
            border-radius: 10px;
            padding: 10px 15px;
            box-shadow: inset 0 0 5px #00ffd2aa;
            transition: background-color 0.3s ease;
        }
        .form-control:focus {
            background-color: #333;
            box-shadow: 0 0 8px #00ffd2;
        }
        button.btn-primary {
            background-color: #00ffd2;
            border: none;
            font-weight: 700;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            font-size: 18px;
            color: #121212;
            box-shadow: 0 0 15px #00ffd2;
        }
        button.btn-primary:hover {
            background-color: #00e6c9;
        }
        .error-msg {
            background-color: #dc2626;
            color: white;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 600;
        }
        .back-link {
            margin-top: 25px;
            text-align: center;
        }
        .back-link a {
            color: #00ffd2;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link a:hover {
            color: #00bba1;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>
        <i class="role-icon 
        <?= $role === 'student' ? 'fas fa-user-graduate text-info' :
           ($role === 'admin' ? 'fas fa-user-shield text-success' :
            'fas fa-chalkboard-teacher text-warning') ?>"></i> 
        <?= ucfirst(htmlspecialchars($role)) ?> Login
    </h2>

    <?php if (!empty($error)): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php?role=<?= htmlspecialchars($role) ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input required type="text" class="form-control" id="username" name="username" placeholder="Enter your username" />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input required type="password" class="form-control" id="password" name="password" placeholder="Enter your password" />
        </div>

        <button type="submit" name="login" class="btn btn-primary">Login</button>
    </form>

    <div class="back-link">
        <a href="/stm_system/index.php"><i class="fas fa-arrow-left"></i> Back to Role Selection</a>
    </div>
</div>

</body>
</html>
