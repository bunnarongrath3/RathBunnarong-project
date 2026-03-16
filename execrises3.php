<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>គណនាលទ្ធផលសិក្សា</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Kantumruy Pro', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            padding: 40px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #34495e; }
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s;
        }
        button:hover { background-color: #2980b9; }
        .result-box {
            margin-top: 25px;
            padding: 20px;
            border-radius: 8px;
            border-left: 5px solid;
        }
        .pass { background-color: #d4edda; border-left-color: #28a745; color: #155724; }
        .fail { background-color: #f8d7da; border-left-color: #dc3545; color: #721c24; }
        .retake { background-color: #fff3cd; border-left-color: #ffc107; color: #856404; }
    </style>
</head>
<body>

<div class="container">
    <h2>ពិនិត្យលទ្ធផលសិក្សា</h2>
    <form method="POST">
        <div class="form-group">
            <label>ឈ្មោះនិស្សិត:</label>
            <input type="text" name="name" required placeholder="បញ្ចូលឈ្មោះ...">
        </div>
        <div class="form-group">
            <label>ចំនួនអវត្តមាន (ដង):</label>
            <input type="number" name="absent" required min="0" max="20">
        </div>
        <div class="form-group">
            <label>ពិន្ទុ Midterm :</label>
            <input type="number" name="midterm" required min="0" max="40" value="">
        </div>
        <div class="form-group">
            <label>ពិន្ទុ Final :</label>
            <input type="number" name="final" required min="0" max="60"​ value="">
        </div>
        <button type="submit" name="check">បង្ហាញលទ្ធផល</button>
    </form>

    <?php
    if (isset($_POST['check'])) {
        $name = htmlspecialchars($_POST['name']);
        $absent = (int)$_POST['absent'];
        $midterm = (float)$_POST['midterm'];
        $final = (float)$_POST['final'];
        $total = $midterm + $final;

        $result = "";
        $status_class = "";

        // ១. បើអវត្តមានចាប់ពី ១៦ដងឡើងទៅ
        if ($absent >= 16) {
            $result = "គ្មានសិទ្ធិប្រលងទេ គឺត្រូវរៀនសងឡើងវិញ";
            $status_class = "fail";
        } 
        // ២. បើអវត្តមានចាប់ពី ១១ដង ដល់ ១៥ដង
        elseif ($absent >= 11 && $absent <= 15) {
            $result = "គ្មានសិទ្ធិប្រលងទេ គឺត្រូវប្រលងសង";
            $status_class = "retake";
        } 
        // ៣. បើអវត្តមានត្រឹម ១០ដង ឬតិចជាង
        else {
            if ($midterm < 20) {
                $result = "ត្រូវរៀនសងឡើងវិញលើមុខវិជ្ជានេះ ";
                $status_class = "fail";
            } elseif ($midterm >= 20 && $total < 60) {
                $result = "ត្រូវប្រលងសងលើមុខវិជ្ជានេះ ";
                $status_class = "retake";
            } else {
                $result = "ប្រលងជាប់លើមុខវិជ្ជានេះ";
                $status_class = "pass";
            }
        }

        // ៤. បង្ហាញលទ្ធផល
        echo "<div class='result-box $status_class'>";
        echo "<strong>ឈ្មោះនិស្សិត:</strong> $name <br>";
        echo "<strong>ពិន្ទុ Midterm:</strong> $midterm <br>";
        echo "<strong>ពិន្ទុ Final:</strong> $final <br>";
        echo "<strong>ពិន្ទុរុប:</strong> $total <br>";
        echo "<hr>";
        echo "<strong>លទ្ធផល:</strong> $result";
        echo "</div>";
    }
    ?>
</div>
<script>
    // ឃាត់មិនឱ្យ User វាយលេខលើសពីកំណត់ (Real-time)
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.oninput = function () {
            let maxVal = parseInt(this.max);
            let currentVal = parseInt(this.value);

            if (currentVal > maxVal) {
                // លោត Message Box ប្រាប់
                alert("អ្នកមិនអាចបញ្ចូលលេខលើសពី " + maxVal + " បានទេ!");
                // កែតម្រូវលេខមកត្រឹម Max វិញភ្លាមៗ
                this.value = maxVal;
            }
        };
    });

    // ត្រួតពិនិត្យម្តងទៀតនៅពេលចុច Submit
    document.getElementById('scoreForm').onsubmit = function(e) {
        let midterm = document.getElementById('midterm').value;
        let final = document.getElementById('final').value;
        
        if (midterm > 40 || final > 60) {
            alert("សូមបញ្ចូលពិន្ទុឱ្យបានត្រឹមត្រូវ!");
            e.preventDefault();
        }
    };
</script>

</body>
</html>