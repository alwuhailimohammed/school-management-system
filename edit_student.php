<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$conn = getDBConnection();

// Get student ID
if (!isset($_GET['id'])) {
    header('Location: students.php');
    exit();
}

$student_id = $_GET['id'];

// Get student data
$stmt = $conn->prepare("SELECT s.*, u.username, u.email, u.full_name FROM students s JOIN users u ON s.user_id = u.user_id WHERE s.student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: students.php');
    exit();
}

$student = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $roll_number = $_POST['roll_number'];
    $class = $_POST['class'];
    $section = $_POST['section'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $parent_name = $_POST['parent_name'];
    $parent_phone = $_POST['parent_phone'];
    
    // Update user info
    $stmt = $conn->prepare("UPDATE users SET full_name = ?, email = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $full_name, $email, $student['user_id']);
    $stmt->execute();
    $stmt->close();
    
    // Update student info
    $stmt = $conn->prepare("UPDATE students SET roll_number = ?, class = ?, section = ?, date_of_birth = ?, gender = ?, address = ?, phone = ?, parent_name = ?, parent_phone = ? WHERE student_id = ?");
    $stmt->bind_param("sssssssssi", $roll_number, $class, $section, $date_of_birth, $gender, $address, $phone, $parent_name, $parent_phone, $student_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Student updated successfully';
        header('Location: students.php');
        exit();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student - School Management System</title>
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
            <h2>Edit Student</h2>
            
            <form method="POST" action="">
                <h3>Account Information</h3>
                <div class="form-group">
                    <label for="username">Username (Read Only)</label>
                    <input type="text" id="username" value="<?php echo htmlspecialchars($student['username']); ?>" readonly style="background: #f0f0f0;">
                </div>
                
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($student['full_name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
                </div>
                
                <h3>Student Information</h3>
                <div class="form-group">
                    <label for="roll_number">Roll Number</label>
                    <input type="text" id="roll_number" name="roll_number" value="<?php echo htmlspecialchars($student['roll_number']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="class">Class</label>
                    <input type="text" id="class" name="class" value="<?php echo htmlspecialchars($student['class']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" value="<?php echo htmlspecialchars($student['section']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $student['date_of_birth']; ?>">
                </div>
                
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender">
                        <option value="Male" <?php echo $student['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $student['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $student['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($student['address']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($student['phone']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="parent_name">Parent Name</label>
                    <input type="text" id="parent_name" name="parent_name" value="<?php echo htmlspecialchars($student['parent_name']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="parent_phone">Parent Phone</label>
                    <input type="text" id="parent_phone" name="parent_phone" value="<?php echo htmlspecialchars($student['parent_phone']); ?>">
                </div>
                
                <div class="action-buttons">
                    <button type="submit" class="btn btn-success">Update Student</button>
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
