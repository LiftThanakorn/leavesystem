<?php
// เชื่อมต่อกับฐานข้อมูล MySQL
$servername = "localhost"; // ชื่อเซิร์ฟเวอร์ฐานข้อมูล MySQL
$username = "root"; // ชื่อผู้ใช้ฐานข้อมูล MySQL
$password = ""; // รหัสผ่านฐานข้อมูล MySQL
$dbname = "leave_management_system"; // ชื่อฐานข้อมูล

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบการส่งแบบฟอร์มการลงทะเบียน
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm-password"];

    // ตรวจสอบรหัสผ่านที่ถูกยืนยัน
    if ($password !== $confirmPassword) {
        $error = "รหัสผ่านที่ยืนยันไม่ตรงกัน";
    } else {
        // เข้ารหัสรหัสผ่านก่อนบันทึกลงฐานข้อมูล
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // เพิ่มข้อมูลผู้ใช้ใหม่ลงในฐานข้อมูล
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            // สำเร็จในการลงทะเบียน
            header("Location: login.php");
            exit();
        } else {
            $error = "เกิดข้อผิดพลาดในการลงทะเบียน: " . $conn->error;
        }
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล MySQL
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Leave Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    /* Custom CSS */
  </style>
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="index.php">Leave Management System</a>
      </div>
    </nav>
  </header>

  <section class="container mt-5">
    <h1>Register</h1>
    <?php if (isset($error)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
      </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="mb-3">
        <label for="confirm-password" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
  </section>

  <footer class="bg-dark text-white text-center p-3 mt-5">
    &copy; 2023 Leave Management System
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
