<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Create user account first
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, email, user_type) VALUES (?, ?, ?, ?, 'teacher')");
    $stmt->bind_param("ssss", $username, $password, $full_name, $email);
    
    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
        
        // Insert teacher details
        $employee_id = $_POST['employee_id'];
        $subject = $_POST['subject'];
        $qualification = $_POST['qualification'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $joining_date = $_POST['joining_date'];
        $salary = $_POST['salary'];
        
        $stmt2 = $conn->prepare("INSERT INTO teachers (user_id, employee_id, subject, qualification, date_of_birth, gender, address, phone, joining_date, salary) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("issssssssd", $user_id, $employee_id, $subject, $qualification, $date_of_birth, $gender, $address, $phone, $joining_date, $salary);
        
        if ($stmt2->execute()) {
            $_SESSION['success'] = 'Teacher added successfully';
            header('Location: teachers.php');
            exit();
        }
        $stmt2->close();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher - School Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🎓 School Management System</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="teachers.php">Teachers</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <div class="dashboard">
            <h2>Add New Teacher</h2>
            
            <form method="POST" action="">
                <h3>Account Information</h3>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <h3>Teacher Information</h3>
                <div class="form-group">
                    <label for="employee_id">Employee ID</label>
                    <input type="text" id="employee_id" name="employee_id" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="qualification">Qualification</label>
                    <input type="text" id="qualification" name="qualification">
                </div>
                
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth">
                </div>
                
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="joining_date">Joining Date</label>
                    <input type="date" id="joining_date" name="joining_date" required>
                </div>
                
                <div class="form-group">
                    <label for="salary">Salary</label>
                    <input type="number" id="salary" name="salary" step="0.01">
                </div>
                
                <div class="action-buttons">
                    <button type="submit" class="btn btn-success">Add Teacher</button>
                    <a href="teachers.php" class="btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2026 School Management System. All rights reserved.</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
