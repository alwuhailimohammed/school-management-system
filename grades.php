<?php
require_once 'config/database.php';
require_once 'includes/auth.php';

if (!isAdmin()) {
    header('Location: dashboard.php');
    exit();
}

$conn = getDBConnection();

// Handle add grade
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_grade'])) {
    $student_id = $_POST['student_id'];
    $course_id = $_POST['course_id'];
    $exam_type = $_POST['exam_type'];
    $marks_obtained = $_POST['marks_obtained'];
    $total_marks = $_POST['total_marks'];
    $exam_date = $_POST['exam_date'];
    $remarks = $_POST['remarks'];
    
    // Calculate grade
    $percentage = ($marks_obtained / $total_marks) * 100;
    if ($percentage >= 90) $grade = 'A+';
    elseif ($percentage >= 80) $grade = 'A';
    elseif ($percentage >= 70) $grade = 'B';
    elseif ($percentage >= 60) $grade = 'C';
    elseif ($percentage >= 50) $grade = 'D';
    else $grade = 'F';
    
    $stmt = $conn->prepare("INSERT INTO grades (student_id, course_id, exam_type, marks_obtained, total_marks, grade, exam_date, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisddsss", $student_id, $course_id, $exam_type, $marks_obtained, $total_marks, $grade, $exam_date, $remarks);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Grade added successfully';
        header('Location: grades.php');
        exit();
    }
    $stmt->close();
}

// Get all grades
$grades = $conn->query("SELECT g.*, s.roll_number, u.full_name as student_name, c.course_name, c.course_code 
    FROM grades g 
    JOIN students s ON g.student_id = s.student_id 
    JOIN users u ON s.user_id = u.user_id 
    JOIN courses c ON g.course_id = c.course_id 
    ORDER BY g.exam_date DESC LIMIT 50");

// Get students for dropdown
$students = $conn->query("SELECT s.student_id, s.roll_number, u.full_name FROM students s JOIN users u ON s.user_id = u.user_id ORDER BY u.full_name");

// Get courses for dropdown
$courses = $conn->query("SELECT course_id, course_name, course_code FROM courses ORDER BY course_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades - School Management System</title>
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
            <h2>Grades Management</h2>
            
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            
            <h3>Add Grade/Marks</h3>
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
                    <label for="course_id">Course</label>
                    <select id="course_id" name="course_id" required>
                        <option value="">-- Select Course --</option>
                        <?php 
                        $courses->data_seek(0);
                        while($course = $courses->fetch_assoc()): 
                        ?>
                        <option value="<?php echo $course['course_id']; ?>"><?php echo htmlspecialchars($course['course_code'] . ' - ' . $course['course_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="exam_type">Exam Type</label>
                    <input type="text" id="exam_type" name="exam_type" required placeholder="e.g., Midterm, Final, Quiz">
                </div>
                
                <div class="form-group">
                    <label for="marks_obtained">Marks Obtained</label>
                    <input type="number" id="marks_obtained" name="marks_obtained" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="total_marks">Total Marks</label>
                    <input type="number" id="total_marks" name="total_marks" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="exam_date">Exam Date</label>
                    <input type="date" id="exam_date" name="exam_date" required value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea id="remarks" name="remarks" rows="2"></textarea>
                </div>
                
                <button type="submit" name="add_grade" class="btn btn-success">Add Grade</button>
            </form>
            
            <h3>Recent Grades</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Roll Number</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Exam Type</th>
                        <th>Marks</th>
                        <th>Grade</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($grades->num_rows > 0): ?>
                        <?php while($g = $grades->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $g['exam_date']; ?></td>
                            <td><?php echo htmlspecialchars($g['roll_number']); ?></td>
                            <td><?php echo htmlspecialchars($g['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($g['course_code'] . ' - ' . $g['course_name']); ?></td>
                            <td><?php echo htmlspecialchars($g['exam_type']); ?></td>
                            <td><?php echo $g['marks_obtained'] . '/' . $g['total_marks']; ?></td>
                            <td><strong><?php echo $g['grade']; ?></strong></td>
                            <td><?php echo htmlspecialchars($g['remarks']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No grades found</td>
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
