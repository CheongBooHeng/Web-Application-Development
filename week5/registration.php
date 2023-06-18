<!DOCTYPE html>
<html>
<head>
  <title>Registration Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <h1>Registration Form</h1>
    <form action="register.php" method="POST">
      <div class="mb-3">
        <label for="firstName" class="form-label">First Name:</label>
        <input type="text" class="form-control" id="firstName" name="firstName" required>
      </div>
      <div class="mb-3">
        <label for="lastName" class="form-label">Last Name:</label>
        <input type="text" class="form-control" id="lastName" name="lastName" required>
      </div>
      <div class="mb-3">
        <label for="Day" class="form-label">Date of Birth:</label>
        <div class="row">
          <div class="col">
            <select class="form-select" id="day" name="day" required>
              <option value="">Day</option>
              <?php
              for ($day = 1; $day <= 31; $day++) {
                echo "<option value=\"$day\">$day</option>";
              }
              ?>
            </select>
          </div>
          <div class="col">
            <select class="form-select" id="month" name="month" required>
              <option value="">Month</option>
              <?php
            $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            foreach ($months as $month) {
              echo "<option value=\"$month\">$month</option>";
            }
            ?>
            </select>
          </div>
          <div class="col">
            <select class="form-select" id="year" name="year" required>
              <option value="">Year</option>
              <?php
              $currentYear = date('Y');
              for ($year = 1900; $year <= $currentYear; $year++) {
                echo "<option value=\"$year\">$year</option>";
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div class="mb-3">
        <label for="gender" class="form-label">Gender:</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" required>
          <label class="form-check-label" for="genderMale">Male</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" required>
          <label class="form-check-label" for="genderFemale">Female</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other" required>
          <label class="form-check-label" for="genderOther">Other</label>
        </div>
      </div>
      <div class="mb-3">
        <label for="username" class="form-label">Username:</label>
        <input type="text" class="form-control" id="username" name="username" pattern="[a-zA-Z_][a-zA-Z0-9_-]{5,}" required>
        <span class="text">Minimum 6 characters, the first character cannot be a number, and only "_" or "-" is allowed in between.</span>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" class="form-control" id="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[-+$()%@#]).{6,}$" required>
        <span class="text">Minimum 6 characters, at least 1 uppercase letter, 1 lowercase letter, and 1 number. No symbols like +$()% (@#) allowed.</span>
      </div>
      <div class="mb-3">
        <label for="confirmPassword" class="form-label">Confirm Password:</label>
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
