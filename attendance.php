<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$conn = getDBConnection();

// Handle add attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_attendance'])) {
    $student_id = $_POST['student_id'];
    $class_id = $_POST['class_id'];
    $attendance_date = $_POST['attendance_date'];
    $status = $_POST['status'];
    $remarks = $_POST['remarks'];
    
    $stmt = $conn->prepare("INSERT INTO attendance (student_id, class_id, attendance_date, status, remarks) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE status = ?, remarks = ?");
    $stmt->bind_param("iisssss", $student_id, $class_id, $attendance_date, $status, $remarks, $status, $remarks);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Attendance recorded successfully';
        header('Location: attendance.php');
        exit();
    }
    $stmt->close();
}

// Get recent attendance records
$attendance = $conn->query("SELECT a.*, s.roll_number, u.full_name as student_name, c.class_name, c.section 
    FROM attendance a 
    JOIN students s ON a.student_id = s.student_id 
    JOIN users u ON s.user_id = u.user_id 
    JOIN classes c ON a.class_id = c.class_id 
    ORDER BY a.attendance_date DESC LIMIT 50");

// Get students for dropdown
$students = $conn->query("SELECT s.student_id, s.roll_number, u.full_name FROM students s JOIN users u ON s.user_id = u.user_id ORDER BY u.full_name");

// Get classes for dropdown
$classes = $conn->query("SELECT class_id, class_name, section FROM classes ORDER BY class_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance - School Management System</title>
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
                <a href="attendance.php">Attendance</a>
                <a href="grades.php">Grades</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    
    <div class="container">
        <div class="dashboard">
            <h2>Attendance Management</h2>
            
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            
            <h3>Record Attendance</h3>
            <form method="POST" action="" style="margin-bottom: 30px;">
                <div class="form-group">
                    <label for="student_id">Student</label>
                    <select id="student_id" name="student_id" required>
                        <option value="">-- Select Student --</option>
                        <?php 
                        $students->data_seek(0);
                        while($student = $students->fetch_assoc()): 
                        ?>
                        <option value="<?php echo $student['student_id']; ?>"><?php echo htmlspecialchars($student['roll_number'] . ' - ' . $student['full_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="class_id">Class</label>
                    <select id="class_id" name="class_id" required>
                        <option value="">-- Select Class --</option>
                        <?php 
                        $classes->data_seek(0);
                        while($class = $classes->fetch_assoc()): 
                        ?>
                        <option value="<?php echo $class['class_id']; ?>"><?php echo htmlspecialchars($class['class_name'] . ' - ' . $class['section']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="attendance_date">Date</label>
                    <input type="date" id="attendance_date" name="attendance_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Late">Late</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea id="remarks" name="remarks" rows="2"></textarea>
                </div>
                
                <button type="submit" name="add_attendance" class="btn btn-success">Record Attendance</button>
            </form>
            
            <h3>Recent Attendance Records</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Roll Number</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($attendance->num_rows > 0): ?>
                        <?php while($att = $attendance->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $att['attendance_date']; ?></td>
                            <td><?php echo htmlspecialchars($att['roll_number']); ?></td>
                            <td><?php echo htmlspecialchars($att['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($att['class_name'] . ' - ' . $att['section']); ?></td>
                            <td>
                                <span style="color: <?php echo $att['status'] == 'Present' ? 'green' : ($att['status'] == 'Absent' ? 'red' : 'orange'); ?>">
                                    <?php echo $att['status']; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($att['remarks']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">No attendance records found</td>
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
