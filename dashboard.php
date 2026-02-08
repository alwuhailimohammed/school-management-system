<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

$conn = getDBConnection();

// Get statistics
$total_students = $conn->query("SELECT COUNT(*) as count FROM students")->fetch_assoc()['count'];
$total_teachers = $conn->query("SELECT COUNT(*) as count FROM teachers")->fetch_assoc()['count'];
$total_courses = $conn->query("SELECT COUNT(*) as count FROM courses")->fetch_assoc()['count'];
$total_classes = $conn->query("SELECT COUNT(*) as count FROM classes")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - School Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🎓 School Management System</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <div class="dashboard">
            <h2>Dashboard</h2>
            
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            
            <div class="stats-container">
                <div class="stat-card">
                    <h3><?php echo $total_students; ?></h3>
                    <p>Total Students</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $total_teachers; ?></h3>
                    <p>Total Teachers</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $total_courses; ?></h3>
                    <p>Total Courses</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $total_classes; ?></h3>
                    <p>Total Classes</p>
                </div>
            </div>
            
            <h3>Quick Access</h3>
            <div class="menu-links">
                <?php if (isAdmin()): ?>
                <a href="students.php" class="menu-link">
                    <h3>👨‍🎓 Students</h3>
                    <p>Manage Students</p>
                </a>
                <a href="teachers.php" class="menu-link">
                    <h3>👨‍🏫 Teachers</h3>
                    <p>Manage Teachers</p>
                </a>
                <a href="courses.php" class="menu-link">
                    <h3>📚 Courses</h3>
                    <p>Manage Courses</p>
                </a>
                <a href="classes.php" class="menu-link">
                    <h3>🏫 Classes</h3>
                    <p>Manage Classes</p>
                </a>
                <a href="attendance.php" class="menu-link">
                    <h3>📋 Attendance</h3>
                    <p>Track Attendance</p>
                </a>
                <a href="grades.php" class="menu-link">
                    <h3>📊 Grades</h3>
                    <p>Manage Grades</p>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2026 School Management System. All rights reserved.</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
