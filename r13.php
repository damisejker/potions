<?php
// Противоаллергическое зелье
if(@$_GET['potion'] == 13) {
 echo "<div class='content'>";
 
 echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | <a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>
<h3>ОХЛАЖДАЮЩАЯ ПАСТА</h3>
<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>    
<div id='recipe' style='display: none;'>
<b>Стоимость ингредиентов за зелье:</b> &#8930;1.02
<br><br>
<b>Ингредиенты:</b>

<br>Вода родниковая – 1 л
<br>Мята (сухие листья) - 50 шт
<br>Листочки щавеля - 50 шт
<br>Миндальное масло - 20 капель
<br>Эфирное масло эвкалипта - 8 капель

<br><br><b>Приготовление:</b>

<br>Вскипятить воду с 5 каплями миндального масла, после образования на поверхности пузырьков уменьшить огонь. В это время натереть или растолочь листья мяты и щавеля до состояния кашицы и добавить масло эвкалипта, перемешать массу. В воду добавить оставшиеся капли миндального масла и следом опустить массу из листьев, варить до загустения - около 30 минут. Снять с огня и, накрыв крышкой, оставить остужаться и загустевать на 6 часов.

<br><br><b>Последовательность добавления ингредиентов в котел: </b>Вода родниковая => Миндальное масло => Мята (сухие листья) => Листочки щавеля => Эфирное масло эвкалипта 

<br><br><b>Итоговые характеристики зелья:</b> Паста имеет темно-зеленый цвет с вкраплениями более крупных фрагментов листьев и насыщенный запах мяты и эвкалипта, могут пробиваться нотки миндаля.

<br><br><b>Магические свойства:</b> Паста обладает охлаждающим эффектом, который усиливается в ветреную погоду. Требуемая дозировка - 1 небольшой шарик для приема внутрь (для безопасного охлаждения в жаркую погоду, действует 3 часа) и 1 полоска длиной в фалангу указательного пальца для растирания определенного участка на теле с примерными характеристиками 30х30 (действует 2 часа). Начинает действовать через 5 минут. Хранить в прозрачной мягкой тубе, чтобы удобно было выдавливать. Разрешается хранить в стеклянной баночке с широким горлом и плотно закрытой крышкой. Срок годности 2 года.

<br><br><b>Побочные эффекты:</b> При чрезмерном употреблении возможно переохлаждение. Особенно осторожным нужно быть с употреблением пасты внутрь, так как ледяные ожоги лечатся трудно.

<hr>
</div>
";


if(@$_POST['begin']) {
    
    $random = rand(0, 9999);
    $geid = md5($random);
    $start = time();
    
    $check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion13'");
    	if(!mysqli_num_rows($check)) {
    	$query = mysqli_query($conn, "INSERT INTO `potions` SET `login`='$login', `lekvar`='potion13', `sessionid`='$geid', `timestart`='$start', `timefinish`='',`progress`=1");    
    	}
    
    
	$name = strip_tags($_POST['imie']);
}


$check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion13'");
$row = mysqli_fetch_array($check);
$progress = $row['progress'];
$igraid = $row['sessionid'];

 $recept = array("Вода родниковая", "Миндальное масло", "Мята (сухие листья)", "Листочки щавеля", "Эфирное масло эвкалипта");   
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
     <a href='?potion=13&takeaway=grant'><img class='readypotion float' src='https://magismo.ru/potions/images/coolingpaste.png' height='89'></a>
     </center>
     	
     </div> ";
     
     // Отдаём зелье владельцу
     if(@$_GET['potion'] == 13 and @$_GET['takeaway'] == "grant") {
         
        $sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
         if(mysqli_num_rows($sql)) {
    
         $date = date("Y-m-d", time());
         
        $nea =  $login; 
        $ima = explode(" ", $nea);
         $gde = "chat";
         $spent = "1.02";
         $potionn = "Охлаждающая паста";
         $keyword = "достаёт собственно-приготовленную <b>охлаждающую пасту</b> и наносит небольшое количество пасты на тело. $ima[0] ощущает как по телу побежала приятная прохлада.";
         $desc = "Паста обладает охлаждающим эффектом, который усиливается в ветреную погоду. Требуемая дозировка - 1 небольшой шарик для приема внутрь (для безопасного охлаждения в жаркую погоду, действует 3 часа) и 1 полоска длиной в фалангу указательного пальца для растирания определенного участка на теле с примерными характеристиками 30х30 (действует 2 часа). Начинает действовать через 5 минут. Хранить в прозрачной мягкой тубе, чтобы удобно было выдавливать. Разрешается хранить в стеклянной баночке с широким горлом и плотно закрытой крышкой. Срок годности 2 года.";
        //в депозитарий
         mysqli_query($conn, "INSERT INTO `depositarium` SET `tid`=0, `login`='$login', `date_add`='$date', `goodname`='$potionn', `spent`='$spent', `keyword` = '$keyword', `gooddescr`='$desc', `picture`='https://magismo.ru/potions/images/coolingpaste.png', `category`='magismo', `usable`=1, `wheretouse`='$gde', `used`=0, `shop`='lab'");     
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
     $myArr = array("Вода родниковая", "Миндальное масло", "Мята (сухие листья)", "Листочки щавеля", "Эфирное масло эвкалипта");  
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($tovar, $myArr, true); 
     if($vrecepte == 1) {
         echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
     } else {
       echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
     }
    
    
echo "<br><div id='puff'></div><a href='?potion=13&n=$tovar&t=$tovarid&s=$igraid' id='myLink'><span style='color:#ffffff')><img src='$tovarp' height='48'> <b> $tovar </b></span></a>";
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
     if(@$_GET['potion'] == 13 and @$_GET['n'] and @$_GET['t'] and @$_GET['s']) {
         $name = $_GET['n'];
         $tid = $_GET['t'];
         $sid = $_GET['s'];
    
     // Прописываем в массив ингредиенты для зелья
     $myArr = array("Вода родниковая", "Миндальное масло", "Мята (сухие листья)", "Листочки щавеля", "Эфирное масло эвкалипта");   
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($name, $myArr, true); 
     
     //Если да, то 
     if($vrecepte == 1) {
         
     //обозначаем предмет использованным
     mysqli_query($conn, "UPDATE `depositarium` SET `used`=1 WHERE `id` = '$tid'");
     //обозначаем что у нас в котле
     mysqli_query($conn, "INSERT INTO `potionkotel` SET `login`='$login', `sessionid`='$sid', `ingredient`='$name'");
     
    
     //возвращаем человеков ко главной
     echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=13'; }</script>";
     
     } else {
         echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=13'; }</script>";
     }
 }