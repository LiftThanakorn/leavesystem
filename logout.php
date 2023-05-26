<?php
// เริ่มเซสชัน
session_start();

// ยกเลิกเซสชัน
session_unset();
session_destroy();

// เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ
header("Location: login.php");
exit();
?>