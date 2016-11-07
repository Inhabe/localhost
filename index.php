<?php
  session_start();
/* Подключение к базе данных MySQL, используя вызов драйвера */
$dsn = 'mysql:dbname=DatabaseT;host=127.0.0.1';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}





// Сервер в формате: <computer>\<instance name> или
// <server>,<port> при использовании нестандартного порта
//$server = 'ROMAN-PC\SQLEXPRESS';

// Подключение к MSSQL
// Выводим страницу пользователя
if ((strlen($_GET['route']) == 0) && $_SERVER["REQUEST_METHOD"] == 'GET')
{
  echo file_get_contents(__DIR__."/NewTicket.html");
  exit;
}
//Отправка тикета API
if ($_GET['route'] == "ticket" && $_SERVER["REQUEST_METHOD"] == 'POST')
{
    $date = date('Y-m-d H:i:s');
    //echo $date;
    $sql = "INSERT INTO `Tickets`(`name`, `contacts`, `text`, `urgency`, `complete`, `date`) VALUES  ('{$_POST['name']}', '{$_POST['contacts']}','{$_POST['text']}',{$_POST['urgency']},0,'{$date}')";
    //echo $sql;

    $dbh->query($sql);

    header('Content-type: application/json');
    echo json_encode([
      'name'=>  $_POST['name'],
      'contacts' => $_POST['contacts'],
      'text'=> $_POST['text'],
      'urgency'=> $_POST['urgency'],
      'complete'=> 0,
      'date'=> $date,
      'id' => $dbh->lastInsertId()
    ]);

    exit;
    //echo $dbh->query($sql);
}


// Выводим страницу админа
if ($_GET['route'] == "admin" && $_SERVER["REQUEST_METHOD"] == 'GET')
{
  if(  $_SESSION['Admin'] == true) {
    echo file_get_contents(__DIR__."/adminticket.html");
    //echo "Привет, админ";
  } else {
    echo file_get_contents(__DIR__."/Login.html");
  }

  exit;
}


//авторизация
if ($_GET['route'] == "admin/auth" && $_SERVER["REQUEST_METHOD"] == 'POST')
{
  $sql = "SELECT id FROM `Admin` WHERE password = '{$_POST['password']}' AND name = '{$_POST['name']}'";
  $data = $dbh->query($sql);

if ($data->rowCount() == 1)
{
  $_SESSION['Admin'] = true;
  header("HTTP/1.0 200 OK");
} else
{
  header("HTTP/1.0 401 Unauthorized");
}

//echo    $dbh->fetch();
  exit;
}
//Деавторизация
if ($_GET['route'] == "admin/deauth" && $_SERVER["REQUEST_METHOD"] == 'POST')
{

if ($_SESSION['Admin'] == true)
{
  $_SESSION['Admin'] = false;
  header("HTTP/1.0 200 OK");
} else
{
  header("HTTP/1.0 401 Unauthorized");
}

//echo    $dbh->fetch();
  exit;
}





//запрос тикетов для админа API
if ($_GET['route'] == "admin/tickets" && $_SERVER["REQUEST_METHOD"] == 'GET')
{
    if(  $_SESSION['Admin'] == true)
    {
      $array = [];
      $sql = "SELECT * FROM `Tickets` WHERE 1";
      $data = $dbh->query($sql);
      foreach ($data as $row)
      {
        array_push($array, [
          'name'=>  $row['name'],
          'contacts' => $row['contacts'],
          'text'=> $row['text'],
          'urgency'=> $row['urgency'],
          'complete'=> $row['complete'],
          'date'=> $row['date'],
          'id' => $row['id']
        ]);
      }
      header('Content-type: application/json');
      echo json_encode($array);


    } else
    {
      header("HTTP/1.0 401 Unauthorized");
    }
    exit;
}

//Обновление тикета
if ($_GET['route'] == "admin/ticket" && $_SERVER["REQUEST_METHOD"] == 'POST')
{
    if(  $_SESSION['Admin'] == true)
    {

      $sql = "UPDATE `Tickets` SET `complete`={$_POST['complete']} WHERE `id` = {$_POST['id']}";
      $dbh->query($sql);
      header("HTTP/1.0 200 OK");

    } else
    {
      header("HTTP/1.0 401 Unauthorized");
    }
    exit;
}
