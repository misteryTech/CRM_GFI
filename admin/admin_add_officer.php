<!DOCTYPE html>
<html>
<head>
  <title>Add Officer</title>
  <style>
    /* Custom styles */
    .form-container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: rgba(255, 255, 255, 0.8);
    }
    .form-container h2 {
      text-align: center;
    }
    .form-container label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }
    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="tel"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .form-container button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 4px;
      background-color: #6495ed;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }
    .form-container button:hover {
      background-color: #4169e1;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Add Officer</h2>

    <?php
      // Assuming you have established a database connection

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the form submission to add the officer to the database
        $officerName = $_POST['officer_name'];
        $officerPosition = $_POST['officer_position'];
        $officerEmail = $_POST['officer_email'];
        $officerPhone = $_POST['officer_phone'];

        // Perform the database insertion operation
        $query = "INSERT INTO officers (name, position, email, phone) VALUES ('$officerName', '$officerPosition', '$officerEmail', '$officerPhone')";
        $result = mysqli_query($connection, $query);

        if ($result) {
          echo "<p>Officer added successfully.</p>";
        } else {
          echo "<p>Error: Failed to add officer.</p>";
        }
      }
    ?>

    <form method="POST">
                    <label for="fullname">Fullname:</label>
                    <input type="text" id="fullname" name="fullname" required>

                    <label for="course">Course</label>
                    <select name="course" id="course" required></select>

                    <label for="year_section">Year&Section</label>
                    <input type="text" id="year_section" name="year_section" required>

                    <label for="position">Position:</label>
                    <input type="text" id="position" name="position" required>

                    <button type="submit">Add Officer</button>
    </form>
  </div>

</body>
</html>