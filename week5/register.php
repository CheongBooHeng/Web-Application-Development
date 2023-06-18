<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
    <title>Detail</title>
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $formattedFirstName = ucwords(strtolower($firstName));
  $formattedLastName = ucwords(strtolower($lastName));
  $day = $_POST['day'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $gender = $_POST['gender'];
  $formattedGender = ucwords(strtolower($gender));
  $username = $_POST['username'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $email = $_POST['email'];

  $errors = [];

  if (empty($firstName)) {
    $errors[] = 'First name is required.';
  }

  if (empty($lastName)) {
    $errors[] = 'Last name is required.';
  }

  if (empty($day) || empty($month) || empty($year)) {
    $errors[] = 'Date of birth is required.';
  }

  if (empty($gender)) {
    $errors[] = 'Gender is required.';
  }

  if (empty($username)) {
    $errors[] = 'Username is required.';
  } elseif (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_-]{5,}$/', $username)) {
    $errors[] = 'Invalid username format.';
  }

  if (empty($password)) {
    $errors[] = 'Password is required.';
  } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?!.*[-+$()%@#]).{6,}$/', $password)) {
    $errors[] = 'Invalid password format.';
  }

  if (empty($confirmPassword)) {
    $errors[] = 'Confirm password is required.';
  } elseif ($password !== $confirmPassword) {
    $errors[] = 'Passwords do not match.';
  }

  if (empty($email)) {
    $errors[] = 'Email is required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
  }

  if (!empty($errors)) {
    echo '<h2 class="text-danger">Error:</h2>';
    echo '<ul>';
    foreach ($errors as $error) {
      echo $error;
    }
    echo '</ul>';
    echo '<a href="registration.php">Go back to the registration form</a>';
    exit;
  }
}

echo '<h2>Registration Successful!</h2>';
echo '<h3>Submitted Information:</h3>';
echo '<p><strong>First Name:</strong> ' . $formattedFirstName . '</p>';
echo '<p><strong>Last Name:</strong> ' . $formattedLastName . '</p>';
echo '<p><strong>Date of Birth:</strong> ' . $day . '/' . $month . '/' . $year . '</p>';
echo '<p><strong>Gender:</strong> ' . $formattedGender . '</p>';
echo '<p><strong>Username:</strong> ' . $username . '</p>';
echo '<p><strong>Email:</strong> ' . $email . '</p>';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>