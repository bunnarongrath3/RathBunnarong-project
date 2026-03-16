<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>វិក្កយបត្រអគ្គិសនីឌីជីថល</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;700&display=swap" rel="stylesheet">
    <link href="execrises.html">
    <style>
        body {
            font-family: 'Kantumruy Pro', sans-serif;
            background: #eef2f7;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .bill-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
            padding: 30px;
        }
        .header-title { color: #007bff; font-weight: 700; text-align: center; margin-bottom: 25px; }
        .form-control { border-radius: 10px; border: 1px solid #ddd; padding: 10px; }
        .btn-calc { 
            background: #007bff; border: none; border-radius: 10px; padding: 12px;
            font-weight: 700; color: #fff; transition: 0.3s;
        }
        .btn-calc:hover { background: #0056b3; }
        .result-box { 
            background: #fdfdfd; border: 2px solid #f1f1f1; border-radius: 15px;
            padding: 20px; margin-top: 25px; position: relative;
        }
        .line-item { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.95rem; }
        .total-amount { font-size: 1.8rem; color: #dc3545; font-weight: 700; }
        .date-badge { background: #fff3cd; color: #856404; padding: 5px 10px; border-radius: 5px; font-size: 0.85rem; }
    </style>
</head>
<body>
<div class="bill-card">
    <h4 class="header-title"> គណនាថ្លៃអគ្គិសនី</h4>
    
    <form method="POST">
        <div class="mb-3">
            <label class="form-label small fw-bold">ឈ្មោះអតិថិជន</label>
            <input type="text" name="name" class="form-control" placeholder="បញ្ចូលឈ្មោះ..." required>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label class="form-label small fw-bold">លេខចាស់</label>
                <input type="number" name="old" class="form-control" placeholder="0" required>
            </div>
            <div class="col-6">
                <label class="form-label small fw-bold">លេខថ្មី</label>
                <input type="number" name="new" class="form-control" placeholder="0" required>
            </div>
        </div>
        <button type="submit" name="submit" class="btn btn-calc w-100">បង្ហាញវិក្កយបត្រ</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $name = htmlspecialchars($_POST['name']);
        $old = (int)$_POST['old'];
        $new = (int)$_POST['new'];
        $usage = $new - $old;

        if ($usage < 0) {
            echo "<div class='alert alert-danger mt-3'>កំហុស៖ លេខថ្មីមិនអាចតូចជាងលេខចាស់!</div>";
        } else {
            // តម្លៃតាមលក្ខខណ្ឌក្នុងរូបភាព
            if ($usage <= 10) $price = 700;
            elseif ($usage <= 20) $price = 800;
            elseif ($usage <= 30) $price = 900;
            else $price = 1000;

            $total = $usage * $price;
            
            // កំណត់កាលបរិច្ឆេទ (ថ្ងៃនេះ និង ថ្ងៃត្រូវបង់ក្នុងរយៈពេល ១៥ ថ្ងៃទៀត)
            $today = date("d-m-Y");
            $due_date = date("d-m-Y", strtotime("+15 days"));
    ?>
            <div class="result-box">
                <div class="text-center mb-3">
                    <span class="date-badge">កាលបរិច្ឆេទចេញវិក្កយបត្រ៖ <?php echo $today; ?></span>
                </div>
                
                <div class="line-item">
                    <span>ឈ្មោះអតិថិជន៖</span>
                    <span class="fw-bold"><?php echo $name; ?></span>
                </div>
                <div class="line-item">
                    <span>លេខអំណានចាស់៖</span>
                    <span class="text-muted"><?php echo $old; ?> kWh</span>
                </div>
                <div class="line-item">
                    <span>លេខអំណានថ្មី៖</span>
                    <span class="text-muted"><?php echo $new; ?> kWh</span>
                </div>
                <div class="line-item">
                    <span>ប្រើប្រាស់សរុប៖</span>
                    <span class="fw-bold text-primary"><?php echo $usage; ?> kWh</span>
                </div>
                <div class="line-item">
                    <span>តម្លៃឯកតា៖</span>
                    <span><?php echo $price; ?> ៛/kWh</span>
                </div>
                
                <hr style="border-style: dashed;">
                
                <div class="line-item mt-2">
                    <span class="fw-bold text-danger">ថ្ងៃកំណត់បង់ប្រាក់៖</span>
                    <span class="fw-bold text-danger"><?php echo $due_date; ?></span>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">ទឹកប្រាក់សរុបត្រូវបង់</small>
                    <div class="total-amount">៛ <?php echo number_format($total, 0, '.', ','); ?></div>
                </div>
            </div>
    <?php
        }
    }
    ?>
</div>
<div>
  <a href="Back" class="btn-outline-secondary btn-sm">
</div>
</body>
</html>