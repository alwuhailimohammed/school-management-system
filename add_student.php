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
    
    $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, email, user_type) VALUES (?, ?, ?, ?, 'student')");
    $stmt->bind_param("ssss", $username, $password, $full_name, $email);
    
    if ($stmt->execute()) {
        $user_id = $conn->insert_id;
        
        // Insert student details
        $roll_number = $_POST['roll_number'];
        $class = $_POST['class'];
        $section = $_POST['section'];
        $date_of_birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $parent_name = $_POST['parent_name'];
        $parent_phone = $_POST['parent_phone'];
        $enrollment_date = $_POST['enrollment_date'];
        
        $stmt2 = $conn->prepare("INSERT INTO students (user_id, roll_number, class, section, date_of_birth, gender, address, phone, parent_name, parent_phone, enrollment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->bind_param("issssssssss", $user_id, $roll_number, $class, $section, $date_of_birth, $gender, $address, $phone, $parent_name, $parent_phone, $enrollment_date);
        
        if ($stmt2->execute()) {
            $_SESSION['success'] = 'Student added successfully';
            header('Location: students.php');
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
    <title>Add Student - School Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🎓 School Management System</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="students.php">Students</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <div class="dashboard">
            <h2>Add New Student</h2>
            
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
                
                <h3>Student Information</h3>
                <div class="form-group">
                    <label for="roll_number">Roll Number</label>
                    <input type="text" id="roll_number" name="roll_number" required>
                </div>
                
                <div class="form-group">
                    <label for="class">Class</label>
                    <input type="text" id="class" name="class" required>
                </div>
                
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section">
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
                    <label for="parent_name">Parent Name</label>
                    <input type="text" id="parent_name" name="parent_name">
                </div>
                
                <div class="form-group">
                    <label for="parent_phone">Parent Phone</label>
                    <input type="text" id="parent_phone" name="parent_phone">
                </div>
                
                <div class="form-group">
                    <label for="enrollment_date">Enrollment Date</label>
                    <input type="date" id="enrollment_date" name="enrollment_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="action-buttons">
                    <button type="submit" class="btn btn-success">Add Student</button>
                    <a href="students.php" class="btn">Cancel</a>
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
