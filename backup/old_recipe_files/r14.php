<?php
// Противоаллергическое зелье
if(@$_GET['potion'] == 14) {
 echo "<div class='content'>";
 
 echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | <a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>
<h3>ПРОТИВОЯДИЕ ОТ САМЫХ СИЛЬНЫХ ЛЮБОВНЫХ ЗЕЛИЙ</h3>
<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>    
<div id='recipe' style='display: none;'>
<b>Стоимость ингредиентов за зелье:</b> &#8930;2.23
<br><br>
<b>Ингредиенты:</b>

<br>Вода родниковая – 1 л
<br>Ягоды бузины
<br>Волосы вейлы
<br>Цветок визгопёрки
<br>Розовый опал

<br><br><b>Приготовление:</b>

<br>Сначала подготовьте рабочее место и подготовьте правильную лабораторную одежду. Дальше, когда все будет готово и вода начнет слегка закипать добавьте целые ягоды бузины и варите их около часа. Бузину мешать не обязательно, ведь она сама кипит и бурлит. Дальше нарежьте соломинкой цветок визгопёрки и добавляем их после ягод бузины через час при этом непрерывно помешивайте все по часовой стрелке. Варим это двадцать минут, а потом добавляем волос вейлы и опал, который перед этим нужно перетереть в пыль, а также который перед этим нужно остудить. Дальше продолжаем непрерывно все помешивать. Делаем три зигзагообразных движения лопаткой, чтобы вмешать в состав розовый опал, восемь оборотов против часовой стрелки, и мешать до готовности по часовой стрелке. Зелье будет готово, когда зелье загустеет, побагровеет и перестанет бурлить. Потом нужно перенести котел в темное место, чтобы все остыло. 

<br><br><b>Последовательность добавления ингредиентов в котел: </b>Вода родниковая => Ягоды бузины => Цветок визгопёрки => Волосы вейлы => Розовый опал

<br><br><b>Итоговые характеристики зелья:</b> В готовом виде зелье розового цвета
<br><br><b>Магические свойства:</b> Зелье освобождает от приворота.


<hr>
</div>
";


if(@$_POST['begin']) {
    
    $random = rand(0, 9999);
    $geid = md5($random);
    $start = time();
    
    $check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion14'");
    	if(!mysqli_num_rows($check)) {
    	$query = mysqli_query($conn, "INSERT INTO `potions` SET `login`='$login', `lekvar`='potion14', `sessionid`='$geid', `timestart`='$start', `timefinish`='',`progress`=1");    
    	}
    
    
	$name = strip_tags($_POST['imie']);
}


$check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion14'");
$row = mysqli_fetch_array($check);
$progress = $row['progress'];
$igraid = $row['sessionid'];

 $recept = array("Вода родниковая", "Ягоды бузины", "Цветок визгопёрки", "Волосы вейлы", "Розовый опал");   
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
     <a href='?potion=14&takeaway=grant'><img class='readypotion float' src='https://magismo.ru/potions/images/antilove.png' height='89'></a>
     </center>
     	
     </div> ";
     
     // Отдаём зелье владельцу
     if(@$_GET['potion'] == 14 and @$_GET['takeaway'] == "grant") {
         
        $sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
         if(mysqli_num_rows($sql)) {
    
         $date = date("Y-m-d", time());
         
        $nea =  $login; 
        $ima = explode(" ", $nea);
         $gde = "chat";
         $spent = "2.23";
         $potionn = "Противоядие от самых сильных любовных зелий";
         $keyword = "выпивает собственно-приготовленное <b>противоядие от самых сильных любовных зелий</b>. $ima[0] лишается любовных чар и имеющийся приворот прекращает воздействовать на разум.";
         $desc = "Зелье освобождает от приворота.";
        //в депозитарий
         mysqli_query($conn, "INSERT INTO `depositarium` SET `tid`=0, `login`='$login', `date_add`='$date', `goodname`='$potionn', `spent`='$spent', `keyword` = '$keyword', `gooddescr`='$desc', `picture`='https://magismo.ru/potions/images/antilove.png', `category`='magismo', `usable`=1, `wheretouse`='$gde', `used`=0, `shop`='lab'");     
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
     $myArr = array("Вода родниковая", "Ягоды бузины", "Цветок визгопёрки", "Волосы вейлы", "Розовый опал");  
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($tovar, $myArr, true); 
     if($vrecepte == 1) {
         echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
     } else {
       echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
     }
    
    
echo "<br><div id='puff'></div><a href='?potion=14&n=$tovar&t=$tovarid&s=$igraid' id='myLink'><span style='color:#ffffff')><img src='$tovarp' height='48'> <b> $tovar </b></span></a>";
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
     if(@$_GET['potion'] == 14 and @$_GET['n'] and @$_GET['t'] and @$_GET['s']) {
         $name = $_GET['n'];
         $tid = $_GET['t'];
         $sid = $_GET['s'];
    
     // Прописываем в массив ингредиенты для зелья
     $myArr = array("Вода родниковая", "Ягоды бузины", "Цветок визгопёрки", "Волосы вейлы", "Розовый опал");   
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($name, $myArr, true); 
     
     //Если да, то 
     if($vrecepte == 1) {
         
     //обозначаем предмет использованным
     mysqli_query($conn, "UPDATE `depositarium` SET `used`=1 WHERE `id` = '$tid'");
     //обозначаем что у нас в котле
     mysqli_query($conn, "INSERT INTO `potionkotel` SET `login`='$login', `sessionid`='$sid', `ingredient`='$name'");
     
    
     //возвращаем человеков ко главной
     echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=14'; }</script>";
     
     } else {
         echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=14'; }</script>";
     }
 }