<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marksheet</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: lightskyblue;
        }

        #main {
            width: 500px;
            height: 500px;
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            background-color: white;
        }

        td,
        th {
            border: 1px solid black;
        }

        td {
            width: 100px;
        }

        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            text-align: center;
            background-color: white;
            width: 500px;
        }
    </style>
</head>

<body>
    <h1>Marksheet</h1>
    <table id="main">
        <thead>
            <tr>
                <th>Serial No</th>
                <th>Subject</th>
                <th>Obtained Marks</th>
                <th>Total Marks</th>
                <th>Percentage</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php
        $subjects = [
            // "Maths" => ["total" => 100, "obtained" => 65],
            // "Physics" => ["total" => 100, "obtained" => 78],
            // "Chemistry" => ["total" => 100, "obtained" => 75],
            // "Ethics" => ["total" => 100, "obtained" => 90],
            // "English" => ["total" => 100, "obtained" => 76],
            // "Computer" => ["total" => 100, "obtained" => 80],
            // "History" => ["total" => 100, "obtained" => 65],
            // "Urdu" => ["total" => 100, "obtained" => 42]
        ];

            $totalObMarks = 0;
            $totalTotalMarks = 0;
            $serialNum = 0;

            if (empty($subjects)) {
                echo "<tr><td colspan='6'><h1>No record found</h1></td></tr>";
            } else {
                foreach ($subjects as $subject => $marks) {
                    $percentage = ($marks["obtained"] / $marks["total"]) * 100;

                    if ($percentage >= 90) {
                        $grade = 'A++';
                    } elseif ($percentage >= 80) {
                        $grade = 'A+';
                    } elseif ($percentage >= 70) {
                        $grade = 'A';
                    } elseif ($percentage >= 60) {
                        $grade = 'B';
                    } elseif ($percentage >= 50) {
                        $grade = 'C';
                    } else {
                        $grade = 'F';
                    }

                    $serialNum++;
                    $totalObMarks += $marks["obtained"];
                    $totalTotalMarks += $marks["total"];
                    ?>
                    <tr>
                        <td><?php echo $serialNum; ?></td>
                        <td><?php echo $subject; ?></td>
                        <td><?php echo $marks["obtained"]; ?></td>
                        <td><?php echo $marks["total"]; ?></td>
                        <td><?php echo $percentage . "%" ?></td>
                        <td style="background-color:<?php
                            echo ($grade == 'A++') ? 'darkgreen' : (($grade == 'A+') ? 'green' : (($grade == 'A') ? 'lightgreen' : (($grade == 'B') ? 'yellow' : (($grade == 'C') ? 'orange' : 'red'))));
                            ?>"><?php echo $grade; ?></td>
                    </tr>
                <?php } 
            }
            ?>
        </tbody>
    </table>

    <?php
    if (empty($subjects)) {
        $finalPercent = 0;
        $finalGrade = 'F';
    } else {
        $finalPercent = ($totalObMarks / $totalTotalMarks) * 100;

        if ($finalPercent >= 90) {
            $finalGrade = 'A++';
        } elseif ($finalPercent >= 80) {
            $finalGrade = 'A+';
        } elseif ($finalPercent >= 70) {
            $finalGrade = 'A';
        } elseif ($finalPercent >= 60) {
            $finalGrade = 'B';
        } elseif ($finalPercent >= 50) {
            $finalGrade = 'C';
        } elseif ($finalPercent >= 0) {
            $finalGrade = 'F';
        }
    }
    ?>
    <table>
        <tr>
            <td>
                <h4>Total Obtained Marks:</h4>
            </td>
            <td>
                <h4><?php echo $totalObMarks ?: 0; ?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Overall Percentage:</h4>
            </td>
            <td>
                <h4><?php echo $finalPercent . "%"; ?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Overall Grade:</h4>
            </td>
            <td style="background-color:<?php
                echo ($finalGrade == 'A++') ? 'darkgreen' : (($finalGrade == 'A+') ? 'green' : (($finalGrade == 'A') ? 'lightgreen' : (($finalGrade == 'B') ? 'yellow' : (($finalGrade == 'C') ? 'orange' : 'red'))));
                ?>">
                <h4><?php echo $finalGrade; ?></h4>
            </td>
        </tr>
    </table>

</body>

</html>
