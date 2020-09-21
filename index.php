<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
  require __DIR__ . '/vendor/autoload.php';

  $db_hostname = getenv('DB_HOSTNAME');
  $db_name = getenv('DB_NAME');
  $db_user = getenv('DB_USER');
  $db_password = getenv('DB_PASSWORD');

  $pdo = new PDO("mysql:dbname=$db_name;host=$db_hostname;charset=utf8mb4", $db_user, $db_password);
  $db = \Delight\Db\PdoDatabase::fromPdo($pdo);

  $isset_table = $db->exec('SHOW TABLES LIKE "test"');

  if($isset_table)
  {
    $db->exec('DROP TABLE `test`');
  }

  $db->exec('CREATE TABLE `test` (
    id INT(10) NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(35),
    middlename VARCHAR(50),
    lastname VARCHAR(50) default "bato",
    CONSTRAINT id_pk PRIMARY KEY (id)
  )');

  $row = $db->selectRow('SELECT * FROM test WHERE lastname = "Igor"');

  if(empty($row))
  {
    $db->insert('test',[
      'firstname' => 'Shirockov Dev',
      'middlename' => 'Igorevich',
      'lastname' => 'Igor'
    ]);

    $row = $db->selectRow('SELECT * FROM test WHERE lastname = "Igor"');
  }

  $name = $row['firstname'] ?? 'no';
  $family = $row['lastname'] ?? 'no';
  $middlename = $row['middlename'] ?? 'no';

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sample Deployment</title>
  <style>
    body {
      color: #ffffff;
      background-color: #007f3f;
      font-family: Arial, sans-serif;
      font-size: 14px;
    }

    h1 {
      font-size: 500%;
      font-weight: normal;
      margin-bottom: 0;
    }

    h2 {
      font-size: 200%;
      font-weight: normal;
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <div align="center">
    <h1>Congratulations! Dev!</h1>
    <h2>You is <?= $family ?> <?= $name ?> <?= $middlename ?></h2>
    <h2>You have successfully created a pipeline that retrieved this source application from an Amazon S3 bucket and deployed it
	to three Amazon EC2 instances using AWS CodeDeploy.</h2>
    <p>For next steps, read the AWS CodePipeline Documentation.</p>
  </div>
</body>
</html>
