<?php

include 'config.php';

include 'classes/Validation.php';
include 'classes/FileUpload.php';
include 'classes/CsvImport.php';

$validation = new Validation();
$fileUpload = new FileUpload();
$csvImport = new CsvImport();

$ajaxResult = [
    'errors' => [],
    'message' => '',
    'status' => false,
    'csvLineError' => [],
    'addedLines' => []
];

// SECTION FileUpload

// SECTION Formdan gelen veriler boş mu ya da atanmış mı
$companyName = $_POST['companyName'] ?? null;
$date = $_POST['date'] ?? null;
$file = $_FILES['file']['size'] > 0 ? $_FILES['file'] : null;

if ($companyName === null || empty($companyName))
    $ajaxResult['errors'][] = "Not empty company name";


if ($date === null)
    $ajaxResult['errors'][] = "Select date";

if ($file === null)
    $ajaxResult['errors'][] = "Select a file";

// !SECTION Formdan gelen veriler boş mu ya da atanmış mı

// SECTION Yüklenecek dosyanın kontrol edilmesi, hata yoksa yüklenmesi
if (isset($file)) {
    $file_name = $file['name'];
    $file_size = $file['size'];
    $file_tmp = $file['tmp_name'];
    $file_type = $file['type'];

    // file types of the uploaded file
    $extensions = ["text/csv"];

    // extension control
    if (in_array($file_type, $extensions) === false) {
        $ajaxResult['errors'][] = "Extension not allowed, please choose a csv file.";
    }

    // file size control
    if ($file_size > MAX_FILE_SIZE) {
        $ajaxResult['errors'][] = 'File size must be excately 2 MB';
    }

    // move files if no errors
    if (empty($ajaxResult['errors']) == true) {
        $uploadedFile = "uploads/" . date('ymdhis_') . $file_name;

        if (move_uploaded_file($file_tmp, $uploadedFile)) {
            $ajaxResult['message'] = 'File uploaded';
            $ajaxResult['status'] = true;
        }
    }
}
// !SECTION Yüklenecek dosyanın kontrol edilmesi, hata yoksa yüklenmesi

// Hata varsa programı burada bitir geriye hata mesajlarını dön
if ($ajaxResult['status'] == false) {
    echo json_encode($ajaxResult);
    die();
}
// !SECTION FileUpload

// SECTION CsvImport
$myfile = fopen($uploadedFile, "r");

$i = 0;
while (!feof($myfile)) {
    $validation = new Validation();

    // satır bazlı hataları tutulması
    $lineError = [];

    $lineString = fgets($myfile);
    $line = explode(';', $lineString);

    // satır başlıklarını alıyor
    if ($i == 0) {
        $i++;
        continue;
    }

    if (count($line) != 6) {
        array_push($lineError, 'row format wrong');
    } else {
        if ($validation->lineValidation($line)) {
            // validate ederken hata yoksa db ye kayıt edilmesi
            $sql = "INSERT INTO users (name, surname, email, employee_id, phone, points) VALUES (?,?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);

            try {
                $pdoResult = $stmt->execute($validation->line);

                array_push($ajaxResult['addedLines'], $validation->line);
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    array_push($lineError, "line has duplicate key");
                } else {
                    array_push($lineError, "insert error");
                    // var_dump($e->getMessage());
                }
            }
        } else {
            array_push($lineError, ...$validation->errors);
        }
    }

    if (count($lineError) > 0) {
        $ajaxResult['csvLineError'][$lineString] = $lineError;
    }

    // satır numaraları
    $i++;
}

fclose($myfile);
// !SECTION CsvImport

echo json_encode($ajaxResult, JSON_PRETTY_PRINT);
