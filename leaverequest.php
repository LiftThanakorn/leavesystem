<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leaverequest - ระบบลางาน</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    /* Custom CSS */
  </style>
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">ระบบลางาน</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="logout.php">ออกจากระบบ</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="container mt-5">
    <h1>ยื่นขอลางาน</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // ดึงข้อมูลจากฟอร์ม
      $leave_type = $_POST["leave_type"];
      $start_date = $_POST["start_date"];
      $end_date = $_POST["end_date"];

      // ตรวจสอบความถูกต้องของข้อมูลการลา
      $errors = [];

      if (empty($leave_type)) {
        $errors[] = "โปรดเลือกประเภทการลา";
      }

      if (empty($start_date) || empty($end_date)) {
        $errors[] = "โปรดเลือกวันที่เริ่มต้นและวันที่สิ้นสุดของการลา";
      } elseif ($start_date > $end_date) {
        $errors[] = "วันที่เริ่มต้นต้องไม่มากกว่าวันที่สิ้นสุดของการลา";
      }

      // ถ้าไม่มีข้อผิดพลาด
      if (empty($errors)) {
        // ทำการบันทึกข้อมูลการลาลงฐานข้อมูล
        // ...

        // แสดงข้อความสำเร็จ
        echo '<div class="alert alert-success" role="alert">ยื่นขอลางานสำเร็จแล้ว</div>';
      } else {
        // แสดงข้อผิดพลาด
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error) {
          echo '<p>' . $error . '</p>';
        }
        echo '</div>';
      }
    }
    ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="mb-3">
        <label for="leaveType" class="form-label">ประเภทการลา</label>
        <select class="form-select" id="leaveType" name="leave_type">
          <option value="">โปรดเลือก</option>
          <option value="ลาป่วย">ลาป่วย</option>
          <option value="ลากิจ">ลากิจ</option>
          <option value="ลาพักร้อน">ลาพักร้อน</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="startDate" class="form-label">วันที่เริ่มต้น</label>
        <input type="date" class="form-control" id="startDate" name="start_date">
      </div>
      <div class="mb-3">
        <label for="endDate" class="form-label">วันที่สิ้นสุด</label>
        <input type="date" class="form-control" id="endDate" name="end_date">
      </div>
      <button type="submit" class="btn btn-primary">ส่งคำขอลา</button>
    </form>
    <button>link</button>
    <a href="leavepage.php">ดู</a>
  </section>

  <footer class="bg-dark text-white text-center p-3 mt-5">
    &copy; 2023 ระบบลางาน
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
