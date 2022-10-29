<?php

// numaraı diziye çevir
$phone = str_split("0123-43242-120");
var_dump($phone);

// numarada olabilecek ifadeler
$find = ['-', '_', '(', ')', ''];

// olabilecek ifadeleri numaradan çıkar
$phoneArray  = array_values(array_filter(array_diff($phone, $find), 'strlen'));
var_dump($phoneArray);

// numaranın başında 0 varsa sil
if ($phoneArray[0] == 0)
    unset($phoneArray[0]);

// numara string'e çevrildi
$phoneString = implode($phoneArray);
var_dump($phoneString);

// numarada eğer rakamlardan oluşmuyorsa
// numarada 10 haneden farklıysa
if (strlen($phoneString) != 10 || is_numeric($phoneString) == false)
    echo 'HATA geçersiz numara';




exit;

$replace = [""];
$arr = ["Hello", "world", "!"];

print_r(str_replace($find, $replace, $arr));
