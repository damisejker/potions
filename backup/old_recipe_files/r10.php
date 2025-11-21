<?php
// Противоаллергическое зелье
if(@$_GET['potion'] == 10) {
    
 echo "<div class='content'>";
 
 echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | <a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>
<h3>ЗЕЛЬЕ \"ПРИТОК СИЛ\"</h3>
<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>    
<div id='recipe' style='display: none;'>
<b>Стоимость ингредиентов за зелье:</b> &#8930;0,56
<br><br>
<b>Ингредиенты:</b>

<br>Вода родниковая
<br>Малина
<br>Земляника 
<br>Листья чёрной смородины
<br>Листья земляники
<br>Листья ежевики
<br>Мята (сухие листья)

<br><br><b>Приготовление:</b>

<br>Листья смородины, земляники, ежевики, мяты не измельчая положить в котел и залить 1 литром кипятка. Поставить на медленный огонь и оставить на 10 минут. Затем, не снимая с огня, если сильно кипит уменьшить огонь еще, помешать 6 раз по часовой стрелке и 6 раз против часовой стрелки. Выключить огонь и перелить в толстую керамическую или глиняную посудину. Положить плоды малины и земляники. Дать остыть. Процедить. Можно употреблять или разлить по склянкам.
Срок хранения: 48 часов.

<br><br><b>Последовательность добавления ингредиентов в котел: </b>Вода родниковая => Листья чёрной смородины => Листья земляники => Листья ежевики => Мята (сухие листья) => Малина => Земляника
<br><br><b>Итоговые характеристики зелья:</b> Светло-зеленая прозрачная жидкость с приятным малиново-земляничным запахом и чуть сладковатым вкусом.
<br><br><b>Магические свойства:</b> 
<br>1) Восстанавливает Магический резерв сил.
<br>2) Восстанавливает физический резерв сил.
<br>Наступает действие зелья через 30-40 секунд.

<br><br><b>Побочные эффекты:</b> Применять не больше одного раза в 5 дней иначе зелье станет не эффективным. После применения в течении 3-4 часов вызывает повышенный аппетит. 

<br><br><b>Передозировка:</b> Возможны личная аллергическая реакция на один или несколько компонентов. 

<br><br><b>Противопоказания:</b> Личная непереносимость одного или нескольких компонентов.


<hr>
</div>
";


if(@$_POST['begin']) {
    
    $random = rand(0, 9999);
    $geid = md5($random);
    $start = time();
    
    $check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion10'");
    	if(!mysqli_num_rows($check)) {
    	$query = mysqli_query($conn, "INSERT INTO `potions` SET `login`='$login', `lekvar`='potion10', `sessionid`='$geid', `timestart`='$start', `timefinish`='',`progress`=1");    
    	}
    
    
	$name = strip_tags($_POST['imie']);
}


$check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion10'");
$row = mysqli_fetch_array($check);
$progress = $row['progress'];
$igraid = $row['sessionid'];

 $recept = array("Вода родниковая", "Листья чёрной смородины", "Листья земляники", "Листья ежевики", "Мята (сухие листья)", "Малина", "Земляника");   
 sort($recept);
 $sumr = count($recept);

//Проверяем все ли нужные ингредиенты в котле
$sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
while($rr = mysqli_fetch_array($sql)) {
    
  $vkotle = array($rr['ingredient'] => 1);
  sort($vkotle);

$a += sizeof($vkotle);
$sum = substr($a,-1);
}

// все в котле зелье готовченко!
if($sumr == $sum) {
     $gotovo .= 1;
     
      echo "Получилось! Всё готово.
     <br><b>Пожалуйста, заберите зелье, кликнув на него.</b></div>
     <br>
     <div id='raysDemoHolder'><div id='rays'></div>
     <center>
     <a href='?potion=10&takeaway=grant'><img class='readypotion float' src='https://magismo.ru/potions/images/poweracquisition.png' height='89'></a>
     </center>
     	
     </div> ";
     
     // Отдаём зелье владельцу
     if(@$_GET['potion'] == 10 and @$_GET['takeaway'] == "grant") {
         
        $sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
         if(mysqli_num_rows($sql)) {
    
         $date = date("Y-m-d", time());
         
        $nea =  $login; 
        $ima = explode(" ", $nea);
         $gde = "chat";
         $spent = "0.56";
         $potionn = "Зелье \"Приток сил\"";
         $keyword = "выпивает собственно-приготовленное <b>зелье \"Приток сил\"</b>. $ima[0] восстанавливает магический и физический резервы сил.";
         $desc = "Восстанавливает магический и физический резервы сил.";
        //в депозитарий
         mysqli_query($conn, "INSERT INTO `depositarium` SET `tid`=0, `login`='$login', `date_add`='$date', `goodname`='$potionn', `spent`='$spent', `keyword` = '$keyword', `gooddescr`='$desc', `picture`='https://magismo.ru/potions/images/poweracquisition.png', `category`='magismo', `usable`=1, `wheretouse`='$gde', `used`=0, `shop`='lab'");     
        //удаляем сессию
        mysqli_query($conn, "DELETE FROM `potions` WHERE `login`='$login' and `sessionid`='$igraid'");    
        mysqli_query($conn, "DELETE FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");    
        echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/'; }</script>";
            echo "<div id='mess' style='display:none;color:lightgreen'>Зелье было перемещено в Ваш депозитарий</div>";
         } else {
             
         }
         
         
     }

 }

// заканчиваем готовку
else {
    $gotovo .= 0;
    
    
//если мы в процессе варки, то не инициируем
if($progress == 1) {
    



echo" <h3>Доступные ингредиенты</h3>";

$d = "SELECT DISTINCT `id`, `goodname`, `picture`
FROM `depositarium`
WHERE `login` = '$login' AND `used` != 1 AND `goodname` != 'Опрыскиватель'
AND `category` IN ('plants', 'fruits', 'liquids', 'stones', 'powder', 'animals')
GROUP BY `goodname`
ORDER BY `goodname` DESC
";
    $obr = mysqli_query($conn, $d);
    
    while($fetch = mysqli_fetch_array($obr)) {
    $tovar = $fetch['goodname'];
    $tovarp = $fetch['picture'];
    $tovarid = $fetch['id'];
    $cc = $fetch['count'];

// Прописываем в массив ингредиенты для зелья
     $myArr = array("Вода родниковая", "Листья чёрной смородины", "Листья земляники", "Листья ежевики", "Мята (сухие листья)", "Малина", "Земляника");  
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($tovar, $myArr, true); 
     if($vrecepte == 1) {
         echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
     } else {
       echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
     }
    
    
echo "<br><div id='puff'></div><a href='?potion=10&n=$tovar&t=$tovarid&s=$igraid' id='myLink'><span style='color:#ffffff')><img src='$tovarp' height='48'> <b> $tovar </b></span></a>";
}

// если нет записи в базе, предлагаем кнопку
} else {
echo"
<!-- <h1 id='countdown'></h1> -->

<form method='post'>
<input type='submit' name='begin' value='Начать варку'>
</form>";
}
}
echo "</div>";


    }
    
    
    ///////////////// если мы решаем добавить Ингредиент в КОТЕЛ ///////////////////////
     if(@$_GET['potion'] == 10 and @$_GET['n'] and @$_GET['t'] and @$_GET['s']) {
         $name = $_GET['n'];
         $tid = $_GET['t'];
         $sid = $_GET['s'];
    
     // Прописываем в массив ингредиенты для зелья
     $myArr = array("Вода родниковая", "Листья чёрной смородины", "Листья земляники", "Листья ежевики", "Мята (сухие листья)", "Малина", "Земляника");   
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($name, $myArr, true); 
     
     //Если да, то 
     if($vrecepte == 1) {
         
     //обозначаем предмет использованным
     mysqli_query($conn, "UPDATE `depositarium` SET `used`=1 WHERE `id` = '$tid'");
     //обозначаем что у нас в котле
     mysqli_query($conn, "INSERT INTO `potionkotel` SET `login`='$login', `sessionid`='$sid', `ingredient`='$name'");
     
    
     //возвращаем человеков ко главной
     echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=10'; }</script>";
     
     } else {
         echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=10'; }</script>";
     }
 }