<?php

class Validation
{
    protected $error = false;
    public $errors = [];

    public function nameValidate()
    {
        if (empty($this->name)) {
            $this->error = true;
            $this->errors[] = "name is empty";
        }

        if (strlen($this->name) > 100) {
            $this->error = true;
            $this->errors[] = "name size: " . strlen($this->name);
        }

        return $this;
    }

    public function surnameValidate()
    {
        if (empty($this->surname)) {
            $this->error = true;
            $this->errors[] = "surname is empty";
        }

        if (strlen($this->surname) > 100) {
            $this->error = true;
            $this->errors[] = "surname size: " . strlen($this->surname);
        }

        return $this;
    }

    public function emailValidate()
    {
        if (empty($this->email)) {
            $this->error = true;
            $this->errors[] = "email is empty";
        }

        if (strlen($this->email) > 150) {
            $this->error = true;
            $this->errors[] = "email size: " . strlen($this->email);
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error = true;
            $this->errors[] = "invalid email";
        }

        return $this;
    }

    public function employee_idValidate()
    {
        if (empty($this->employee_id)) {
            $this->error = true;
            $this->errors[] = "employee_id is empty";
        }

        if (strlen($this->employee_id) > 13) {
            $this->error = true;
            $this->errors[] = "employee_id size: " . strlen($this->employee_id);
        }

        return $this;
    }

    public function phoneValidate()
    {
        // numara boş imu
        if (empty($this->phone)) {
            $this->error = true;
            $this->errors[] = "phone is empty";
        }

        // numaraı diziye çevir
        $phone = str_split($this->phone);

        // numarada olabilecek ifadeler
        $find = ['-', '_', '(', ')', ''];

        // olabilecek ifadeleri numaradan çıkar
        $this->phone  = array_values(array_filter(array_diff($phone, $find), 'strlen'));

        // numaranın başında 0 varsa sil
        if ($this->phone[0] == 0)
            unset($this->phone[0]);

        // numara string'e çevrildi
        $this->phone = implode($this->phone);

        // numarada eğer rakamlardan oluşmuyorsa
        // numarada 10 haneden farklıysa
        if (strlen($this->phone) != 10 || is_numeric($this->phone) == false) {
            $this->error = true;
            $this->errors[] =  "invalid number";
        }

        if (strlen($this->phone) != 10) {
            $this->error = true;
            $this->errors[] =  "phone size: " . strlen($this->phone);
        }

        return $this;
    }

    public function pointsValidate()
    {
        if (empty($this->points)) {
            $this->error = true;
            $this->errors[] = "points is empty";
        }

        if (strlen($this->points) > 5) {
            $this->error = true;
            $this->errors[] = "points size: " . strlen($this->points);
        }

        return $this;
    }

    public function lineValidation($line)
    {
        $this->name = $line[0];
        $this->surname = $line[1];
        $this->email = $line[2];
        $this->employee_id = $line[3];
        $this->phone = $line[4];
        $this->points = $line[5];

        $this->nameValidate()->surnameValidate()->emailValidate()->employee_idValidate()->phoneValidate()->pointsValidate();

        // hata yoksa geriye true değerini döndürür
        if ($this->error == true)
            return false;

        return true;
    }
}
