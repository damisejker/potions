<?php
// Противоаллергическое зелье
if(@$_GET['potion'] == 4) {
 echo "<div class='content'>";
 
 echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | <a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>
<h3>ТОНИЗИРУЮЩЕЕ ЗЕЛЬЕ</h3>
<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>    
<div id='recipe' style='display: none;'>
<b>Стоимость ингредиентов за зелье:</b> &#8930;2,15
<br><br>
<b>Ингредиенты:</b>

<br>Розовая вода 1,5 л
<br>Ягоды гуми 10 гр
<br>Лимонный сок 5 гр
<br>Корень червоточника 3 шт
<br>Мята (сухие листья) 5 шт

<br><br><b>Приготовление:</b>

<br>В котел залить розовой воды и лимонного сока, дать настояться 5 минут, включить огонь и нагревать 15 минут, не доводя до кипения. Добавить корень червоточника, после этого помешивать 4 раза по часовой стрелке каждые 5 минут. Когда зелье станет розового цвета и будет пахнуть лимоном, добавить ягоды и прекратить помешивания. Через 10 минут добавить листья, помешивать беспрерывно: один раз против часовой стрелки, второй по часовой. Зелье должно стать синего цвета - снять котел с огня и, не закрывая крышкой, дать остыть. Разлить по 4 флаконам.
Употреблять можно спустя день после варки.Хранить до полугода в темном месте.

<br><br><b>Последовательность добавления ингредиентов в котел: </b>розовая вода => лимонный сок => корень червоточника => ягоды гуми => мята (сухие листья)
<br><br><b>Итоговые характеристики зелья:</b> Синего цвета, пахнущее лимоном и мятой зелье.

<hr>
</div>
";


if(@$_POST['begin']) {
    
    $random = rand(0, 9999);
    $geid = md5($random);
    $start = time();
    
    $check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion4'");
    	if(!mysqli_num_rows($check)) {
    	$query = mysqli_query($conn, "INSERT INTO `potions` SET `login`='$login', `lekvar`='potion4', `sessionid`='$geid', `timestart`='$start', `timefinish`='',`progress`=1");    
    	}
    
    
	$name = strip_tags($_POST['imie']);
}


$check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion4'");
$row = mysqli_fetch_array($check);
$progress = $row['progress'];
$igraid = $row['sessionid'];

 $recept = array("Розовая вода", "Ягоды гуми", "Лимонный сок", "Корень червоточника", "Мята (сухие листья)");   
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
     <a href='?potion=4&takeaway=grant'><img class='readypotion float' src='https://magismo.ru/potions/images/tonikzel.png' height='89'></a>
     </center>
     	
     </div> ";
     
     // Отдаём зелье владельцу
     if(@$_GET['potion'] == 4 and @$_GET['takeaway'] == "grant") {
         
        $sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
         if(mysqli_num_rows($sql)) {
    
         $date = date("Y-m-d", time());
         
        $nea =  $login; 
        $ima = explode(" ", $nea);
         $gde = "chat";
         $spent = "2.15";
         $keyword = "выпивает собственно-приготовленное <b>тонизирующее зелье</b>. Тело мага наполняется приливом сил и энергии. Усталость отступает. $ima[0] ощущает себя теперь бодро.";
         $desc = "Зелье придаёт ощущение прилива сил и энергии, устранение усталости. При передозировке возможно усиление самомнения, беспокойство, тонус мышц, невозможность усидеть на месте.";
        //в депозитарий
         mysqli_query($conn, "INSERT INTO `depositarium` SET `tid`=0, `login`='$login', `date_add`='$date', `goodname`='Тонизирующее зелье', `spent`='$spent', `keyword` = '$keyword', `gooddescr`='$desc', `picture`='https://magismo.ru/potions/images/tonikzel.png', `category`='magismo', `usable`=1, `wheretouse`='$gde', `used`=0, `shop`='lab'");     
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
     $myArr = array("Розовая вода", "Ягоды гуми", "Лимонный сок", "Корень червоточника", "Мята (сухие листья)");
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($tovar, $myArr, true); 
     if($vrecepte == 1) {
         echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
     } else {
       echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
     }
    
    
echo "<br><div id='puff'></div><a href='?potion=4&n=$tovar&t=$tovarid&s=$igraid' id='myLink'><span style='color:#ffffff')><img src='$tovarp' height='48'> <b> $tovar </b></span></a>";
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
     if(@$_GET['potion'] == 4 and @$_GET['n'] and @$_GET['t'] and @$_GET['s']) {
         $name = $_GET['n'];
         $tid = $_GET['t'];
         $sid = $_GET['s'];
    
     // Прописываем в массив ингредиенты для зелья
     $myArr = array("Розовая вода", "Ягоды гуми", "Лимонный сок", "Корень червоточника", "Мята (сухие листья)");
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($name, $myArr, true); 
     
     //Если да, то 
     if($vrecepte == 1) {
         
     //обозначаем предмет использованным
     mysqli_query($conn, "UPDATE `depositarium` SET `used`=1 WHERE `id` = '$tid'");
     //обозначаем что у нас в котле
     mysqli_query($conn, "INSERT INTO `potionkotel` SET `login`='$login', `sessionid`='$sid', `ingredient`='$name'");
     
    
     //возвращаем человеков ко главной
     echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=4'; }</script>";
     
     } else {
         echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=4'; }</script>";
     }
 }