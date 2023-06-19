<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Zodiac</title>
</head>

<body>
    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    ?>
    <div class="container">
        <form method="POST" action="">
            <div class="row">
                <div class="col">
                    <label for="day">Day</label>
                    <select class="form-select" aria-label="Default select example" name="day">
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="month">Month</label>
                    <select class="form-select" name="month" required>
                        <?php
                        $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                        foreach ($months as $x => $month) {
                            $y = $x + 1;
                            echo "<option value=\"$y\">$month</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="year">Year</label>
                    <select class="form-select" aria-label="Default select example" name="year">
                        <?php
                        $currentYear = date('Y');
                        for ($i = 1900; $i <= $currentYear; $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary my-3" name="submit">Submit</button>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $day = $_POST['day'];
            $months = $_POST['month'];
            $year = $_POST['year'];
            if (!checkdate($months, $day, $year)) {
                echo "Invalid date!";
                return;
            }
            $currentYear = date('Y');
            $age = $currentYear - $year;
            $zodiacs = array('Rat', 'Cow', 'Tiger', 'Rabbit', 'Dragon', 'Snake', 'Horse', 'Goat', 'Monkey', 'Rooster', 'Dog', 'Pig');
            $count = ($year - 1900) % 12;
            $zodiac = $zodiacs[$count];

            $constellation = " ";
            if (($months == 1 && $day > 19) || ($months == 2 && $day < 19)) {
                $constellation = "Aquarius";
            } elseif (($months == 2 && $day > 18) || ($months == 3 && $day < 21)) {
                $constellation = "Pisces";
            } elseif (($months == 3 && $day > 20) || ($months == 4 && $day < 20)) {
                $constellation = "Aries";
            } elseif (($months == 4 && $day > 19) || ($months == 5 && $day < 21)) {
                $constellation = "Taurus";
            } elseif (($months == 5 && $day > 20) || ($months == 6 && $day < 21)) {
                $constellation = "Gemini";
            } elseif (($months == 6 && $day > 20) || ($months == 7 && $day < 23)) {
                $constellation = "Cancer";
            } elseif (($months == 7 && $day > 22) || ($months == 8 && $day < 23)) {
                $constellation = "Leo";
            } elseif (($months == 8 && $day > 22) || ($months == 9 && $day < 23)) {
                $constellation = "Virgo";
            } elseif (($months == 9 && $day > 22) || ($months == 10 && $day < 23)) {
                $constellation = "Libra";
            } elseif (($months == 10 && $day > 22) || ($months == 11 && $day < 22)) {
                $constellation = "Scorpio";
            } elseif (($months == 11 && $day > 21) || ($months == 12 && $day < 22)) {
                $constellation = "Sagittarius";
            } elseif (($months == 12 && $day > 21) || ($months == 1 && $day < 20)) {
                $constellation = "Capricorn";
            }

            echo "Date of Birth: " . $day . " " . $months . " " . $year;
            echo "<br>Your chinese zodiac sign is: $zodiac";
            echo "<br>Your constellation is: $constellation";
        }
        ?>
    </div>
</body>
</html>