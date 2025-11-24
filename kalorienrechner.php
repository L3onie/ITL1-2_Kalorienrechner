<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalorienrechner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f0f4f8;
            color: #333;
        }

        h1 {
            color: #1a73e8;
            margin-bottom: 20px;
        }

        form {
            max-width: 500px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 6px;
            margin-top: 4px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .radio-group {
            margin-top: 5px;
        }

        input[type="radio"]+label {
            display: inline-block;
            margin-right: 15px;
        }

        input[type="submit"] {
            margin-top: 15px;
            padding: 8px 12px;
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #1669c1;
        }

        .result {
            margin-top: 20px;
            padding: 10px;
            background-color: #d2e3fc;
            /* hellblau */
            border-left: 4px solid #1a73e8;
            border-radius: 4px;
        }

        .result p {
            margin: 5px 0;
        }
    </style>
</head>

<h1>Kalorienrechner</h1>

<body>
    <form method="post" action="">
        <label>Geschlecht:</label>
        <input type="radio" id="male" name="gender" value="männlich" required>
        <label for="male">Männlich</label>

        <input type="radio" id="female" name="gender" value="weiblich">
        <label for="female">Weiblich</label>

        <label for="age">Alter (Jahre):</label>
        <input type="number" id="age" name="age" min="0" required>

        <label for="weight">Gewicht (kg):</label>
        <input type="number" id="weight" name="weight" min="0" step="0.1" required>

        <label for="height">Größe (cm):</label>
        <input type="number" id="height" name="height" min="0" step="0.1" required>

        <label>Sitzend / Liegend (h):</label>
        <input type="number" name="hours_sedentary" min="0" step="0.1" required>

        <label>Vorwiegend sitzend (h):</label>
        <input type="number" name="hours_office" min="0" step="0.1" required>

        <label>Zwischendurch stehend / gehend (h):</label>
        <input type="number" name="hours_light" min="0" step="0.1" required>

        <label>Aktiv / viel gehen (h):</label>
        <input type="number" name="hours_active" min="0" step="0.1" required>

        <label>Körperlich anstrengende Arbeiten (h):</label>
        <input type="number" name="hours_heavy" min="0" step="0.1" required>


        <input type="submit" name="submit" value="Berechnen">
    </form>

    <?php if (isset($_POST['submit'])) {
        $gender = $_POST['gender'];
        $age = $_POST['age'];
        $weight = $_POST['weight'];
        $height = $_POST['height'];
        $calories = calculateKalorienbedarf($gender, $age, $weight, $height);
        $hours_sedentary = $_POST['hours_sedentary'];
        $hours_office = $_POST['hours_office'];
        $hours_light = $_POST['hours_light'];
        $hours_active = $_POST['hours_active'];
        $hours_heavy = $_POST['hours_heavy'];
        $pal = calculatePAL($hours_sedentary, $hours_office, $hours_light, $hours_active, $hours_heavy);
        $daily_calories = $calories * $pal;
       
        echo '<div style="margin-top:20px;padding:10px;background-color:#d2e3fc;
            border-left:4px solid #1a73e8;border-radius:4px;">
            Dein Kalorienbedarf beträgt: ' . round($calories) . ' kcal<br>
            Der PAL Faktor für den Tag: ' . round($pal, 2) . '<br>
            Täglicher Kalorienbedarf: ' . round($daily_calories, 2) . ' kcal
            </div>';

    }
    function calculateKalorienbedarf($gender, $age, $weight, $height)
    {
        if ($gender == 'männlich') {
            return 66.47 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
        } else {
            return 655.1 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
        }
    }
    function calculatePAL($hours_sedentary, $hours_office, $hours_light, $hours_active, $hours_heavy)
    {
        $hours_sleep = 24 - ($hours_sedentary + $hours_office + $hours_light + $hours_active + $hours_heavy);
        $pal_avg = ($hours_sedentary * 1.2) + ($hours_office * 1.4) + ($hours_light * 1.6) + ($hours_active * 1.8) + ($hours_heavy * 2.0) + ($hours_sleep * 0.95);
        $pal_avg /= 24;
        return $pal_avg;
    } ?>
</body>

</html>