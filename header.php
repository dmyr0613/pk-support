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
</head>

<?php
  //DB接続文字列をグローバル変数に格納
  global $pdo;

  //Heroku PostgresSQL
  $dsn = 'pgsql:dbname=d5a5uarogr4ag5 host=ec2-52-73-155-171.compute-1.amazonaws.com port=5432';
  $user = 'wiqxmjieopiick';
  $password = 'c691b8de99e71d03b591f0ff325298fdbe4ad6e801ba3bfccbde567eda9fadbf';
  $pdo = new PDO($dsn, $user, $password);
?>

<body class="is-preload">
  <!-- Wrapper -->
    <div id="wrapper">
