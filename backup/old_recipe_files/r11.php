<?php
// Противоаллергическое зелье
if(@$_GET['potion'] == 11) {

    
 echo "<div class='content'>";
 
 echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | <a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>
<h3>БЫСТРОЗАЖИВЛЯЮЩАЯ УНИВЕРСАЛЬНАЯ МАЗЬ</h3>
<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>    
<div id='recipe' style='display: none;'>
<b>Стоимость ингредиентов за зелье:</b> &#8930;3,48
<br><br>
<b>Ингредиенты:</b>

<br>Маковая роса - 0,4 л и 10 мл
<br>Ягоды облепихи - 30 гр
<br>Крапивная настойка - 15 гр
<br>Шверский мох - 5 шт
<br>Сухая ламинария - 10 шт
<br>Сок подснежника - 10 гр
<br>Сок шиповника - 10 гр
<br>Сок алоэ - 12 гр
<br>Сок чистотела - 2 гр

<br><br><b>Приготовление:</b>

<br>Смешать соки растений и крапивную настойку в одной емкости. Маковую росу разогреть до температуры в 125 градусов по Цельсию, выключить огонь и добавить основу из соков. Оставить остужаться на час, жидкость не должна быть горячей или теплой, приемлемая температура - 15-20 градусов.
<br>Пока зелье остужается, растолочь ламинарию в кашицу, добавить мох, сделав из них тягучую массу, по консистенции похожей на засыхающие чернила - не растекающаяся, но и не твердая. Ягоды облепихи очистить от кожуры и мякоть растолочь вместе с мхом.
<br>Поставить массу на огонь на 7 минут, она должна быть темно-зеленого цвета. После влить жидкость, оставить на 2 минуты, далее помешивать каждые 2 минуты до тех пор, пока зелье не начнет сгущаться, теряя в объеме, принимая консистенцию мази. Выключить огонь, добавить маковой росы и перемешать до момента, пока масса не станет травяного цвета.
<br>Хранить 2 года в плотно закрытой таре.

<br><br><b>Последовательность добавления ингредиентов в котел: </b>Сок подснежника => Сок шиповника =>  Алоэ древовидное (сок) => Сок чистотела => Крапивная настойка => Маковая роса => Сухая ламинария => Шверский мох => Ягоды облепихи
<br><br><b>Итоговые характеристики зелья:</b> Травяного цвета, с более темными вкраплениями мха, пахнущая свежесрезанной травой.
<br><br><b>Магические свойства:</b> Мазь для способствования заживлению царапин, рубцов (если им до полугода), ожогов I степени (без волдырей), синяков и ушибов. Начинает действовать через 5 минут, для полного заживления необходимо лечить по схеме: на один-два пальца нанести немного мази, без горки, в два слоя помазать необходимое место, 2 раза в день 4 дня.

<br><br><b>Побочные эффекты:</b> При чрезмерном употреблении место нанесения может на время окраситься в зеленоватый цвет - пройдет само.


<hr>
</div>
";


if(@$_POST['begin']) {
    
    $random = rand(0, 9999);
    $geid = md5($random);
    $start = time();
    
    $check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion11'");
    	if(!mysqli_num_rows($check)) {
    	$query = mysqli_query($conn, "INSERT INTO `potions` SET `login`='$login', `lekvar`='potion11', `sessionid`='$geid', `timestart`='$start', `timefinish`='',`progress`=1");    
    	}
    
    
	$name = strip_tags($_POST['imie']);
}


$check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion11'");
$row = mysqli_fetch_array($check);
$progress = $row['progress'];
$igraid = $row['sessionid'];

 $recept = array("Сок подснежника", "Сок шиповника", "Алоэ древовидное (сок)", "Сок чистотела", "Крапивная настойка", "Маковая роса", "Сухая ламинария", "Шверский мох", "Ягоды облепихи");   
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
     <a href='?potion=11&takeaway=grant'><img class='readypotion float' src='https://magismo.ru/potions/images/healingointment.png' height='89'></a>
     </center>
     	
     </div> ";
     
     // Отдаём зелье владельцу
     if(@$_GET['potion'] == 11 and @$_GET['takeaway'] == "grant") {
         
        $sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
         if(mysqli_num_rows($sql)) {
    
         $date = date("Y-m-d", time());
         
        $nea =  $login; 
        $ima = explode(" ", $nea);
         $gde = "chat";
         $spent = "3,48";
         $potionn = "Быстрозаживляющая универсальная мазь";
         $keyword = "достаёт собственно-приготовленную <b>быстрозаживляющую универсальную мазь</b> и начинает обрабатывать раны. Мазь начинает действовать через 5 минут.";
         $desc = "Мазь для способствования заживлению царапин, рубцов (если им до полугода), ожогов I степени (без волдырей), синяков и ушибов. Начинает действовать через 5 минут, для полного заживления необходимо лечить по схеме: на один-два пальца нанести немного мази, без горки, в два слоя помазать необходимое место, 2 раза в день 4 дня. ";
        //в депозитарий
         mysqli_query($conn, "INSERT INTO `depositarium` SET `tid`=0, `login`='$login', `date_add`='$date', `goodname`='$potionn', `spent`='$spent', `keyword` = '$keyword', `gooddescr`='$desc', `picture`='https://magismo.ru/potions/images/healingointment.png', `category`='magismo', `usable`=1, `wheretouse`='$gde', `used`=0, `shop`='lab'");     
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
     $myArr = array("Сок подснежника", "Сок шиповника", "Алоэ древовидное (сок)", "Сок чистотела", "Крапивная настойка", "Маковая роса", "Сухая ламинария", "Шверский мох", "Ягоды облепихи");  
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($tovar, $myArr, true); 
     if($vrecepte == 1) {
         echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
     } else {
       echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
     }
    
    
echo "<br><div id='puff'></div><a href='?potion=11&n=$tovar&t=$tovarid&s=$igraid' id='myLink'><span style='color:#ffffff')><img src='$tovarp' height='48'> <b> $tovar </b></span></a>";
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
     if(@$_GET['potion'] == 11 and @$_GET['n'] and @$_GET['t'] and @$_GET['s']) {
         $name = $_GET['n'];
         $tid = $_GET['t'];
         $sid = $_GET['s'];
    
     // Прописываем в массив ингредиенты для зелья
     $myArr = array("Сок подснежника", "Сок шиповника", "Алоэ древовидное (сок)", "Сок чистотела", "Крапивная настойка", "Маковая роса", "Сухая ламинария", "Шверский мох", "Ягоды облепихи");   
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($name, $myArr, true); 
     
     //Если да, то 
     if($vrecepte == 1) {
         
     //обозначаем предмет использованным
     mysqli_query($conn, "UPDATE `depositarium` SET `used`=1 WHERE `id` = '$tid'");
     //обозначаем что у нас в котле
     mysqli_query($conn, "INSERT INTO `potionkotel` SET `login`='$login', `sessionid`='$sid', `ingredient`='$name'");
     
    
     //возвращаем человеков ко главной
     echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=11'; }</script>";
     
     } else {
         echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=11'; }</script>";
     }
 }