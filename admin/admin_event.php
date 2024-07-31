
<?php 
include("admin_header.php");
?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php 
        include("admin_sidebar.php");
        ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php 
                include("admin_topbar.php");
                ?>


<?php 
include("../include/connection.php");
?>


                <!-- Begin Page Content -->
                
                <div class="container-fluid">

                <div class="container mt-3 text-right">
                <button onclick="openModal()"
                style="background-color: #4e73df; color: #ffffff;"
                class="btn btn-primary">+ Add Event</button>
</div>

                <!DOCTYPE html>
<html>
<head>
  <title></title>
  <style>
    /* Custom styles */
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      text-align: center;
      padding: 20px;
    }
    th {
      background-color: #f2f2f2;
    }
    td {
      border: 1px solid #ddd;
      cursor: pointer;
    }
    .today {
      background-color: #ffc107;
    }
    .event {
      background-color: #007bff;
      color: #fff;
    }
    .add-event-form {
      margin-top: 50px;
    }
  </style>
 <script>
    document.addEventListener('DOMContentLoaded', function() {
      var currentDate = new Date();
      var currentMonth = currentDate.getMonth();
      var currentYear = currentDate.getFullYear();

      displayCalendar(currentMonth, currentYear);

      document.getElementById('prev').addEventListener('click', function() {
        currentMonth--;
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        }
        displayCalendar(currentMonth, currentYear);
      });

      document.getElementById('next').addEventListener('click', function() {
        currentMonth++;
        if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        displayCalendar(currentMonth, currentYear);
      });

      function displayCalendar(month, year) {
        var calendar = document.getElementById('calendar');
        calendar.innerHTML = '';

        var monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        var firstDay = new Date(year, month, 1).getDay();
        var numDays = new Date(year, month + 1, 0).getDate();

        var header = '<tr>';
        for (var i = 0; i < daysOfWeek.length; i++) {
          header += '<th>' + daysOfWeek[i] + '</th>';
        }
        header += '</tr>';
        calendar.innerHTML += header;

        var date = 1;
        for (var i = 0; i < 6; i++) {
          var row = '<tr>';
          for (var j = 0; j < 7; j++) {
            if (i === 0 && j < firstDay) {
              row += '<td></td>';
            } else if (date > numDays) {
              break;
            } else {
              var className = '';
              var eventDate = year + '-' + (month + 1) + '-' + date;
              <?php
                // Assuming you have an array of event dates
                $eventDates = array('2022-05-10', '2022-05-15', '2022-05-20');
                foreach ($eventDates as $eventDate) {
              ?>
              if (eventDate === '<?php echo $eventDate; ?>') {
                className = 'event';
              }
              <?php
                }
              ?>
              if (date === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear()) {
                className += ' today';
              }
              row += '<td class="' + className + '">' + date + '</td>';
              date++;
            }
          }
          row += '</tr>';
          calendar.innerHTML += row;
        }

        var cells = calendar.getElementsByTagName('td');
        for (var i = 0; i < cells.length; i++) {
          cells[i].addEventListener('click', function() {
            var selectedDate = this.innerHTML;
            var selectedMonth = month + 1; // Months are zero-based in JavaScript
            var selectedYear = year;
            console.log('Selected date: ' + selectedMonth + '/' + selectedDate + '/' + selectedYear);
            // You can perform further processing with the selected date
            // For example, update a form field with the selected date
            // document.getElementById('selectedDate').value = selectedMonth + '/' + selectedDate + '/' + selectedYear;

            // Add or remove a class to style the selected date
            var selectedCell = document.getElementsByClassName('selected');
            if (selectedCell.length > 0) {
              selectedCell[0].classList.remove('selected');
            }
            this.classList.add('selected');
            
          });
        }
      }
    });
  </script>

</head>
</head>
<body>
<body>

  <?php
    $currentDate = date('Y-m-d');
    $currentYear = date('Y');
    $currentMonth = date('n');
    $firstDay = date('w', strtotime($currentYear . '-' . $currentMonth . '-01'));
    $numDays = date('t', strtotime($currentYear . '-' . $currentMonth . '-01'));
  ?>


  <?php
    // Set the desired time zone
    date_default_timezone_set('America/New_York');

    // Get the current year and month
    $year = date('Y');
    $month = date('n');

    // Get the number of days in the current month
    $numDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Get the first day of the month
    $firstDay = date('w', strtotime("$year-$month-1"));

    // Create an array of month names
    $monthNames = array(
      1 => 'January',
      2 => 'February',
      3 => 'March',
      4 => 'April',
      5 => 'May',
      6 => 'June',
      7 => 'July',
      8 => 'August',
      9 => 'September',
      10 => 'October',
      11 => 'November',
      12 => 'December'
    );

    // Create an array of day names
    $dayNames = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');

    // Create an array to store the events
    $events = array(
      
      0 => 'Event 1',
      0 => 'Event 2',
      0 => 'Event 3'

    );

    // Display the calendar
    echo "<h2>{$monthNames[$month]} $year</h2>";
    echo "<table>";
    echo "<tr>";
    foreach ($dayNames as $day) {
      echo "<th>$day</th>";
    }
    echo "</tr>";
    
    $dayCount = 1;
    $row = 1;

    while ($dayCount <= $numDays) {
      echo "<tr>";
      for ($col = 0; $col < 7; $col++) {
        if (($row === 1 && $col < $firstDay) || $dayCount > $numDays) {
          echo "<td></td>";
        } else {
          $class = ($dayCount === date('j')) ? 'today' : '';
          if (isset($events[$dayCount])) {
            $class .= ' event';
          }
          echo "<td class='$class' data-date='$month/$dayCount/$year'>$dayCount</td>";
          $dayCount++;
        }
      }
      echo "</tr>";
      $row++;
    }

    echo "</table>";
  ?>
</body>
</html>
  <br>
  <br>
</body>
</html>

<?php 
include("admin_footer.php");
?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
  <style>
    /* Custom styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }
    .modal-content {
      background-color: #f9f9f9;
      margin: 10% auto;
      padding: 40px;
      border: 1px solid #888;
      width: 400px;
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }
    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }
  
  </style>
  <script>
    function openModal() {
      document.getElementById("myModal").style.display = "block";
    }

    function closeModal() {
      document.getElementById("myModal").style.display = "none";
    }
  </script>
</head>
<body>
 

  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <h3>Add Event</h3>
      <form action="admin_add_event.php" method="post">
        <label for="date">Date:</label>
        <input type="date" name="date" placeholder="date" required><br>
        <label for="time">Time:</label>
        <input type="time" name="time" placeholder="time" required><br>
        <label for="title">Title:</label>
        <input type="text" name="title" required><br>
        <label for="description">Description:</label>
        <textarea id="event_description" name="description" required  rows="5" cols="30"></textarea><br>
        <label for="location">Location:</label>
        <input type="text" name="location" required><br><br>

        <button type="submit" class="btn btn-pimary">+ Add</button>
  </form>

       
  
</body>
</html>
