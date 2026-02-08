<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-box">
        <h2>🎓 School Management System</h2>
        <p style="text-align: center; margin-bottom: 30px; color: #666;">Welcome! Please login to continue</p>
        
        <?php
        session_start();
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
            unset($_SESSION['success']);
        }
        ?>
        
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
            
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        
        <p style="text-align: center; margin-top: 20px; color: #666; font-size: 14px;">
            <!-- Default credentials for development: admin / admin123 -->
        </p>
    </div>
    
    <footer>
        <p>&copy; 2026 School Management System. All rights reserved.</p>
    </footer>
</body>
</html>
