<!DOCTYPE html>
<html>
<head>
<title>PKSupport</title>
<link rel="shortcut icon" type="image" href="images/favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="stylesheet" href="assets/css/main.css" />
</head>

<?php
  //DB接続文字列をグローバル変数に格納
  global $pdo;
  //localhost mySql
  // $pdo=new PDO('mysql:host=localhost;dbname=marcs;charset=utf8', 'sbs', 'sbs_toro');

  //Heroku PostgresSQL
  // $dsn = 'pgsql:dbname=d13p6kmhdcirvm host=ec2-174-129-208-118.compute-1.amazonaws.com port=5432';
  // $user = 'gkijtxlavebgol';
  // $password = 'ecff643bfa3612a94627c9d668f867a06ce4b86e4a69f8a42d981af26c50a505';

  //20220404 接続文字列変更
  $dsn = 'pgsql:dbname=dbejrl8163lahl host=ec2-54-156-80-253.compute-1.amazonaws.com port=5432';
  $user = 'ocmkfhxxlrdqcl';
  $password = '19a9523daf9e628a66d12d0a17aa5a0f9505d09ede0aa9857dccedc78c4f4a1f';
  $pdo = new PDO($dsn, $user, $password);
?>

<body class="is-preload">
  <!-- Wrapper -->
    <div id="wrapper">
