<html>
<head>
	<meta content="text/html; charset=utf-8">
	<title>Запись в БД через форму на php</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">
body {
	font-family: "Open Sans";
	margin: auto;
}
header {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
}
table tbody tr:first-child {
	text-transform: uppercase;
}
.result {
	display: flex;
	justify-content: center;
}
.addform {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
}
</style>
</head>
<body>
<header>
	<a href="./">индекс /</a>
	<a href="../">/ вверх</a>
</header>
<?php
/* создаем БД
CREATE TABLE `mytable` (
  `id` int(20) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf32 NOT NULL,
  `text` text NOT NULL
)
*/

// Параметры для подключения
$db_host = "localhost"; 
$db_user = "grom"; // Логин БД
$db_password = "3101"; // Пароль БД
$db_base = "gromtestbase"; // Имя БД
$db_table = "mytable"; // Имя Таблицы БД

// Подключение к базе данных
$mysqli = new mysqli($db_host,$db_user,$db_password,$db_base);

// Если есть ошибка соединения, выводим её и убиваем подключение
if ($mysqli->connect_error) {
    die('Ошибка : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

// Переменные с формы
$name = $_POST['name'];
$text = $_POST['text'];
$deleteId = $_POST['del-id'];

// Запись в БД
if (isset($_POST['name']) && isset($_POST['text'])){

    $result = $mysqli->query("INSERT INTO ".$db_table." (name,text) VALUES ('$name','$text')");

    // Вывод отчета
    if ($result == true){
    	echo "Информация занесена в базу данных";
    }else{
    	echo "Информация не занесена в базу данных";
    }
}

// Удаление из БД
if (isset($_POST['del-id'])){

    $result = $mysqli->query("DELETE FROM `mytable` WHERE `mytable`.`id` = ('$deleteId')");

    // Вывод отчета
    if ($result == true){
    	echo "Информация удалена из базы данных";
    }else{
    	echo "Информация не удалена из базы данных";
    }
}
?>
<div class="result">
<?php
$query ="SELECT * FROM mytable";

$result = mysqli_query($mysqli, $query) or die("Ошибка " . mysqli_error($mysqli)); 
if($result)
{
    $rows = mysqli_num_rows($result); // количество полученных строк
     
    echo "<table><tr><th>Id</th><th>Модель</th><th>Производитель</th></tr>";
    for ($i = 0 ; $i < $rows ; ++$i)
    {
        $row = mysqli_fetch_row($result);
        echo "<tr>";
            for ($j = 0 ; $j < 3 ; ++$j) echo "<td>$row[$j]</td>";
        echo "</tr>";
    }
    echo "</table>";

    // очищаем результат
    mysqli_free_result($result);
}
?>
</div>
<?php

mysqli_close($mysqli);
?>
<div class="addform">
	<form method="POST" action="">
		<input name="name" type="text" placeholder="Имя"/><br />
		<input name="text" type="text" placeholder="Текст"/><br />
		<input type="submit" value="Отправить"/>
		<hr>
	</form>
</div>
<div class="addform">
	<form method="POST" action="">
		<input name="del-id" type="number" placeholder="Введите ID"/>
		<input type="submit" value="Удалить"/>
	</form>
</div>
</body>
</html>
