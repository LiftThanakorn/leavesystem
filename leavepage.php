<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leave Page - Leave Management System</title>
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
    <h1>Leave Page</h1>
    
    <h2>Leave Summary</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Leave Type</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <!-- Loop through leave data and populate table rows -->
        <?php foreach ($leaves as $leave): ?>
          <tr>
            <td><?php echo $leave["leave_type"]; ?></td>
            <td><?php echo $leave["start_date"]; ?></td>
            <td><?php echo $leave["end_date"]; ?></td>
            <td><?php echo $leave["status"]; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h2>Leave Calendar</h2>
    <div id='calendar'></div>
  </section>

  <footer class="bg-dark text-white text-center p-3 mt-5">
    &copy; 2023 Leave Management System
  </footer>

  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>

  <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

    </script>
</body>
</html>
