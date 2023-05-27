<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <title>Date</title>
</head>

<body>
  <div class="container">
    <?php
    echo "<b>What is your date of birth</b>";
    ?>
    <form>
      <div class="row">
        <div class="col">
          <label for="day">Day</label>
          <select class="form-select" aria-label="Default select example">
            <?php
            for ($i = 1; $i <= 31; $i++) {
              echo "<option value=\"$i\">$i</option>";
            }
            ?>
          </select>
        </div>
        <div class="col">
          <label for="day">Month</label>
          <select class="form-select" aria-label="Default select example">
            <?php
            for ($i = 1; $i <= 12; $i++) {
              echo "<option value=\"$i\">$i</option>";
            }
            ?>
          </select>
        </div>
        <div class="col">
          <label for="day">Year</label>
          <select class="form-select" aria-label="Default select example">
            <?php
            $currentYear = date('Y');
            for ($i = 1900; $i <= $currentYear; $i++) {
              echo "<option value=\"$i\">$i</option>";
            }
            ?>
          </select>
        </div>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>