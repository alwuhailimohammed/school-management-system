<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$conn = getDBConnection();

// Handle delete
if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];
    $conn->query("DELETE FROM classes WHERE class_id = $class_id");
    $_SESSION['success'] = 'Class deleted successfully';
    header('Location: classes.php');
    exit();
}

// Handle add
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];
    $section = $_POST['section'];
    $teacher_id = !empty($_POST['teacher_id']) ? $_POST['teacher_id'] : NULL;
    $room_number = $_POST['room_number'];
    
    $stmt = $conn->prepare("INSERT INTO classes (class_name, section, teacher_id, room_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $class_name, $section, $teacher_id, $room_number);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Class added successfully';
        header('Location: classes.php');
        exit();
    }
    $stmt->close();
}

// Get all classes with teacher names
$classes = $conn->query("SELECT c.*, u.full_name as teacher_name FROM classes c LEFT JOIN teachers t ON c.teacher_id = t.teacher_id LEFT JOIN users u ON t.user_id = u.user_id ORDER BY c.class_id DESC");

// Get all teachers for dropdown
$teachers = $conn->query("SELECT t.teacher_id, u.full_name FROM teachers t JOIN users u ON t.user_id = u.user_id ORDER BY u.full_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes - School Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🎓 School Management System</h1>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="students.php">Students</a>
                <a href="teachers.php">Teachers</a>
                <a href="courses.php">Courses</a>
                <a href="classes.php">Classes</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <div class="dashboard">
            <h2>Classes Management</h2>
            
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            
            <h3>Add New Class</h3>
            <form method="POST" action="" style="margin-bottom: 30px;">
                <div class="form-group">
                    <label for="class_name">Class Name</label>
                    <input type="text" id="class_name" name="class_name" required placeholder="e.g., Grade 10">
                </div>
                
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" placeholder="e.g., A">
                </div>
                
                <div class="form-group">
                    <label for="teacher_id">Class Teacher</label>
                    <select id="teacher_id" name="teacher_id">
                        <option value="">-- Select Teacher --</option>
                        <?php 
                        $teachers->data_seek(0); // Reset pointer
                        while($teacher = $teachers->fetch_assoc()): 
                        ?>
                        <option value="<?php echo $teacher['teacher_id']; ?>"><?php echo htmlspecialchars($teacher['full_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="room_number">Room Number</label>
                    <input type="text" id="room_number" name="room_number">
                </div>
                
                <button type="submit" name="add_class" class="btn btn-success">Add Class</button>
            </form>
            
            <h3>All Classes</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Class Name</th>
                        <th>Section</th>
                        <th>Class Teacher</th>
                        <th>Room Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($classes->num_rows > 0): ?>
                        <?php while($class = $classes->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $class['class_id']; ?></td>
                            <td><?php echo htmlspecialchars($class['class_name']); ?></td>
                            <td><?php echo htmlspecialchars($class['section']); ?></td>
                            <td><?php echo $class['teacher_name'] ? htmlspecialchars($class['teacher_name']) : 'Not assigned'; ?></td>
                            <td><?php echo htmlspecialchars($class['room_number']); ?></td>
                            <td>
                                <a href="classes.php?delete=<?php echo $class['class_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No classes found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <footer>
        <p>&copy; 2026 School Management System. All rights reserved.</p>
    </footer>
</body>
</html>
<?php $conn->close(); ?>
