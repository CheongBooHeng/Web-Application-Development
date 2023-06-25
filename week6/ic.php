<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Malaysian IC</title>
</head>

<body>
    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    ?>
    <div class="container">
        <h3>Malaysian IC</h3>
        <form method="POST" action="">
            <div class="form-group my-3">
                <label for="ic">IC Number:</label>
                <input type="text" class="ic" id="ic" name="ic" pattern="[0-9]{6}-[0-9]{2}-[0-9]{4}" required>
            </div>
            <button type="submit" class="btn btn-primary mb-3" name="submit">Submit</button>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $icNumber = $_POST["ic"];
            $pattern = "/^[0-9]{6}-[0-9]{2}-[0-9]{4}$/";

            // Check if the IC number is valid
            if (preg_match($pattern, $icNumber)) {
                $year = substr($icNumber, 0, 2);
                $month = substr($icNumber, 2, 2);
                $day = substr($icNumber, 4, 2);
                $place = substr($icNumber, 7, 2);
                $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
                
                if ($year > (date('Y') - 2000)) {
                    $birthyear = $year + 1900;
                } else {
                    $birthyear = $year + 2000;
                }

                if (checkdate($month, $day, $birthyear)) {
                    $birthmonth = $month - 1;
                    echo "Date of Birth: " . $months[$birthmonth] . " " . $day . ", " . $birthyear;
                    $zodiacs = array('Monkey', 'Rooster', 'Dog', 'Pig', 'Rat', 'Ox', 'Tiger', 'Rabbit', 'Dragon', 'Snake', 'Horse', 'Sheep');
                    $count = $birthyear % 12;
                    $zodiac = $zodiacs[$count];

                    if ($zodiac == 'Monkey') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src = "img/monkey.jpg" alt="Monkey" width="15%">';
                    } else if ($zodiac == 'Rooster') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src ="img/rooster.jpg" alt="Rooster" width="15%">';
                    } else if ($zodiac == 'Dog') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/dog.jpg" alt="Dog" width="15%">';
                    } else if ($zodiac == 'Pig') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/pig.jpg" alt="Pig" width="15%">';
                    } else if ($zodiac == 'Rat') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/rat.jpg" alt="Rat" width="15%">';
                    } else if ($zodiac == 'Ox') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/ox.jpg" alt="Ox" width="15%">';
                    } else if ($zodiac == 'Tiger') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/tiger.jpg" alt="Tiger" width="15%">';
                    } else if ($zodiac == 'Rabbit') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/rabbit.jpg" alt="Rabbit" width="15%">';
                    } else if ($zodiac == 'Dragon') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/dragon.jpg" alt="Dragon" width="15%">';
                    } else if ($zodiac == 'Snake') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/snake.jpg" alt="Snake" width="15%">';
                    } else if ($zodiac == 'Horse') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/horse.jpg" alt="Horse" width="15%">';
                    } else if ($zodiac == 'Sheep') {
                        echo '<br>Chinese Zodiac: ' . $zodiac;
                        echo '<br><img src="img/sheep.jpg" alt="Sheep" width="15%">';
                    }

                    $starZodiac = " ";
                    if (($month == 1 && $day > 19) || ($month == 2 && $day < 19)) {
                        $starZodiac = "Aquarius";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/aquarius.jpg" alt="Aquarius" width="15%">';
                    } elseif (($month == 2 && $day > 18) || ($month == 3 && $day < 21)) {
                        $starZodiac = "Pisces";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/pisces.jpg" alt="Pices" width="15%">';
                    } elseif (($month == 3 && $day > 20) || ($month == 4 && $day < 20)) {
                        $starZodiac = "Aries";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/aries.jpg" alt="Aries" width="15%">';
                    } elseif (($month == 4 && $day > 19) || ($month == 5 && $day < 21)) {
                        $starZodiac = "Taurus";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/taurus.jpg" alt="Taurus" width="15%">';
                    } elseif (($month == 5 && $day > 20) || ($month == 6 && $day < 21)) {
                        $starZodiac = "Gemini";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/gemini.jpg" alt="Gemini" width="15%">';
                    } elseif (($month == 6 && $day > 20) || ($month == 7 && $day < 23)) {
                        $starZodiac = "Cancer";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/cancer.jpg" alt="Cancer" width="15%">';
                    } elseif (($month == 7 && $day > 22) || ($month == 8 && $day < 23)) {
                        $starZodiac = "Leo";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/leo.jpg" alt="Leo" width="15%">';
                    } elseif (($month == 8 && $day > 22) || ($month == 9 && $day < 23)) {
                        $starZodiac = "Virgo";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/virgo.jpg" alt="Virgo" width="15%">';
                    } elseif (($month == 9 && $day > 22) || ($month == 10 && $day < 23)) {
                        $starZodiac = "Libra";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/libra.jpg" alt="Libra" width="15%">';
                    } elseif (($month == 10 && $day > 22) || ($month == 11 && $day < 22)) {
                        $starZodiac = "Scorpio";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/scorpio.jpg" alt="Scorpio" width="15%">';
                    } elseif (($month == 11 && $day > 21) || ($month == 12 && $day < 22)) {
                        $starZodiac = "Sagittarius";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/sagittarius.jpg" alt="Sagittarius" width="15%">';
                    } elseif (($month == 12 && $day > 21) || ($month == 1 && $day < 20)) {
                        $starZodiac = "Capricorn";
                        echo '<br>Star Zodiac: ' . $starZodiac;
                        echo '<br><img src="img/capricorn.jpg" alt="Capricorn" width="15%">';
                    }

                    if ($place == 1 || $place == 21 || $place == 22 || $place == 23 || $place == 24) {
                        $placeofbirth = "Johor";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/johor.jpg" alt="Johor" width="15%">';
                    } else if ($place == 2 || $place == 25 || $place == 26 || $place == 27) {
                        $placeofbirth = "Kedah";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/kedah.jpg" alt="Kedah" width="15%">';
                    } else if ($place == 3 || $place == 28 || $place == 29) {
                        $placeofbirth = "Kelantan";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/kelantan.jpg" alt="Kelantan" width="15%">';
                    } else if ($place == 4 || $place == 30) {
                        $placeofbirth = "Malacca";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/melaka.jpg" alt="Malacca" width="15%">';
                    } else if ($place == 5 || $place == 31 || $place == 59) {
                        $placeofbirth = "Negeri Sembilan";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/negeri_sembilan.jpg" alt="Negeri Sembilan" width="15%">';
                    } else if ($place == 6 || $place == 32 || $place == 33) {
                        $placeofbirth = "Pahang";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/pahang.jpg" alt="Pahang" width="15%">';
                    } else if ($place == 7 || $place == 34 || $place == 35) {
                        $placeofbirth = "Penang";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/penang.jpg" alt="Penang" width="15%">';
                    } else if ($place == 8 || $place == 36 || $place == 37 || $place == 38 || $place == 39) {
                        $placeofbirth = "Perak";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/perak.jpg" alt="Penang" width="15%">';
                    } else if ($place == 9 || $place == 40) {
                        $placeofbirth = "Perlis";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/perlis.jpg" alt="Perlis" width="15%">';
                    } else if ($place == 10 || $place == 41 || $place == 42 || $place == 43 || $place == 44) {
                        $placeofbirth = "Selangor";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/selangor.jpg" alt="Selangor" width="15%">';
                    } else if ($place == 11 || $place == 45 || $place == 46) {
                        $placeofbirth = "Terengganu";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/terrengganu.jpg" alt="Terengganu" width="15%">';
                    } else if ($place == 12 || $place == 47 || $place == 48 || $place == 49) {
                        $placeofbirth = "Sabah";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/sabah.jpg" alt="Sabah" width="15%">';
                    } else if ($place == 13 || $place == 50 || $place == 51 || $place == 52 || $place == 53) {
                        $placeofbirth = "Sarawak";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/sarawak.jpg" alt="Sarawak" width="15%">';
                    } else if ($place == 14 || $place == 54 || $place == 55 || $place == 56 || $place == 57) {
                        $placeofbirth = "Federal Territory of Kuala Lumpur";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/kl.jpg" alt="Federal Territory of Kuala Lumpur" width="15%">';
                    } else if ($place == 15 || $place == 58) {
                        $placeofbirth = "Federal Territory of Labuan";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/labuan.jpg" alt="Federal Territory of Labuan" width="15%">';
                    } else if ($place == 16) {
                        $placeofbirth = "Federal Territory of Putrajaya";
                        echo '<br>Place of Birth: ' . $placeofbirth;
                        echo '<br><img src="img/putrajaya.jpg" alt="Federal Territory of Putrajaya" width="15%">';
                    } else {
                        echo "<br>Place of birth not found!";
                    }
                } else {
                    echo "Invalid date of birth!";
                }
            }
             else {
                echo "Invalid IC number!";
        }
    }
        ?>
    </div>
</body>

</html>