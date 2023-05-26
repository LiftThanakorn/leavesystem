<?php
// เริ่มเซสชัน
session_start();

// ตรวจสอบสถานะการเข้าสู่ระบบ
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// รับข้อมูลผู้ใช้จากเซสชัน
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["name"];

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

// ดึงข้อมูลผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_email = $row["email"];
    $user_password = $row["password"];
} else {
    // ไม่พบข้อมูลผู้ใช้งาน
    header("Location: login.php");
    exit();
}


// ตรวจสอบการส่งแบบฟอร์มการแก้ไขข้อมูลส่วนตัว
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST["email"];
    $new_password = $_POST["password"];
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // อัปเดตข้อมูลผู้ใช้ในฐานข้อมูล
    $sql = "UPDATE users SET email = '$new_email', password = '$hashed_password' WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        // อัปเดตข้อมูลสำเร็จ
        $user_email = $new_email;
        $user_password = $new_password;
        

        $success_message = "อัปเดตข้อมูลส่วนตัวสำเร็จ";
    } else {
        $error_message = "เกิดข้อผิดพลาดในการอัปเดตข้อมูลส่วนตัว: " . $conn->error;
    }
}

// ดึงข้อมูลการลาของผู้ใช้จากฐานข้อมูล
$sql = "SELECT * FROM leaves WHERE user_id = '$user_id'";
$result = $conn->query($sql);

$leaves = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leave = array(
            "leave_type" => $row["leave_type"],
            "start_date" => $row["start_date"],
            "end_date" => $row["end_date"]
        );
        $leaves[] = $leave;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Leave Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    /* Custom CSS */
  </style>
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Leave Management System</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="container mt-5">
    <h1>Welcome, <?php echo $user_name; ?>!</h1>
    <p>This is your dashboard.</p>

    <h2>Personal Information</h2>
    <?php if (isset($success_message)): ?>
      <div class="alert alert-success" role="alert">
        <?php echo $success_message; ?>
      </div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
      <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user_email; ?>" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="<?php echo $user_password; ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <h2>Leave History</h2>
    <?php if (count($leaves) > 0): ?>
      <table class="table">
        <thead>
          <tr>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($leaves as $leave): ?>
            <tr>
              <td><?php echo $leave["leave_type"]; ?></td>
              <td><?php echo $leave["start_date"]; ?></td>
              <td><?php echo $leave["end_date"]; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No leave history found.</p>
    <?php endif; ?>
    <a href="leavepage.php">leavepage</a>
    <a href="leaverequest.php">ยื่นขอลางาน</a>
  </section>

  <footer class="bg-dark text-white text-center p-3 mt-5">
    &copy; 2023 Leave Management System
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
