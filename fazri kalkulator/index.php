<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Analog dengan Riwayat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="calculator bg-light">
            <div class="card">
                <div class="text-end mb-1">
                    <!-- Toggle switch untuk mode gelap -->
                    <label class="form-check-label me-0 col-form-label-sm">Thema</label>
                    <div class="form-check form-switch d-inline-block">
                        <input class="form-check-input" type="checkbox" id="themeToggle">
                    </div>
                </div>
                <div class="card-header text-center bg-primary text-white">
                    <h4>Kalkulator Analog</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <!-- Tampilan Display -->
                        <input type="text" class="form-control mb-3 display" name="display" id="display" readonly
                            value="<?php echo isset($_POST['display']) ? htmlspecialchars($_POST['display']) : ''; ?>">

                        <!-- Tombol-Tombol -->
                        <div class="row g-2 mb-3">
                            <?php
                            $buttons = [
                                ['7', '8', '9', '/'],
                                ['4', '5', '6', '*'],
                                ['1', '2', '3', '-'],
                                ['0', 'C', '=', '+']
                            ];
                            foreach ($buttons as $row) {
                                foreach ($row as $btn) {
                                    $class = is_numeric($btn) ? 'btn-number ' : ($btn === 'C' || $btn === '=' ? 'btn-clear' : 'btn-operator');
                                    echo '<div class="col-3">';
                                    echo '<button type="submit" name="button" value="' . $btn . '" class="btn ' . $class . ' w-100">' . $btn . '</button>';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>

                        <!-- Riwayat Perhitungan -->
                        <textarea class="form-control mb-3" name="history" rows="5" readonly><?php
                        echo isset($_POST['history']) ? htmlspecialchars($_POST['history']) : '';
                        ?></textarea>

                        <!-- Tombol Clear History -->
                        <button type="submit" name="clear_history" class="btn btn-danger w-100">Clear History</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $current = $_POST['display'] ?? '';
        $button = $_POST['button'] ?? '';
        $history = $_POST['history'] ?? '';

        if (isset($_POST['clear_history'])) {
            $history = '';
            $current = '';
        } elseif ($button === 'C') {
            $current = '';
        } elseif ($button === '=') {
            try {
                // Evaluasi ekspresi menggunakan fungsi PHP
                $result = @eval("return $current;");
                if ($result === false) {
                    $current = 'Error';
                } else {
                    $history .= $current . ' = ' . $result . PHP_EOL;
                    $current = $result;
                }
            } catch (Exception $e) {
                $current = 'Error';
            }
        } else {
            $current .= $button;
        }
        // Simpan nilai di elemen input
        echo '<script>
            document.getElementById("display").value = "' . htmlspecialchars($current) . '";
            document.getElementsByName("history")[0].value = `' . htmlspecialchars($history) . '`;
        </script>';
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
