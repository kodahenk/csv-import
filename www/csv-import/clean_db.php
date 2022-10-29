<?php

require 'config.php';

$pdo->exec('DELETE FROM users');

header("location:index.php");