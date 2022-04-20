<!DOCTYPE html>
<html>
<head>
<title>PKSupport</title>
<link rel="shortcut icon" type="image" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="assets/css/main.css" />
<!-- <link href="https://fonts.googleapis.com/earlyaccess/nikukyu.css" rel="stylesheet"> -->
<link href="https://fonts.googleapis.com/css?family=M+PLUS+1p" rel="stylesheet">
</head>

<?php
  //DB接続文字列をグローバル変数に格納
  global $pdo;

  // localhost mySql
  $pdo=new PDO('mysql:host=localhost;dbname=pksupport;charset=utf8', 'sbs', 'sbs_toro');

  // //Heroku PostgresSQL
  // $dsn = 'pgsql:dbname=dehvcdqgtekqb0 host=ec2-34-194-73-236.compute-1.amazonaws.com port=5432';
  // $user = 'wquiwpacdiajcc';
  // $password = 'ad11385cbb40f80154f981dc388d5c94e1149eb71ffd71c9d390f1d60a5cc4a8';
  // $pdo = new PDO($dsn, $user, $password);
?>

<body class="is-preload">
  <!-- Wrapper -->
    <div id="wrapper">
