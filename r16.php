<?php
// Противоаллергическое зелье
if(@$_GET['potion'] == 16) {
 echo "<div class='content'>";
 
 echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | <a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>
<h3>ЗЕЛЬЕ МЕНТАЛЬНОГО ВОССТАНОВЛЕНИЯ</h3>
<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>    
<div id='recipe' style='display: none;'>
<b>Стоимость ингредиентов за зелье:</b> &#8930;3.00
<br><br>
<b>Ингредиенты:</b>

<br>1. Розовая вода – 50 мл.
<br>2. Вода родниковая — 750 мл.
<br>3. Лирный корень — 3 штуки, толченные.
<br>4. Лимонный сок — 10 мл.
<br>5. Ягоды шиповника — 20 ягод, очищенных от шкурки.
<br>6. Душица (сухие листья) — 34 гр., растолченная.
<br>7. Чертополох — 2 веточки с цветами
<br>8. Алоэ древовидное (сок) — 12 гр.
<br>9. Зверобой — 15 лепестков.
<br>10. Пустырник пятилопастный (сухие листья) — 26 гр. растолченный.
<br>11. Эфирное масло лаванды — 5 капель.
<br>12. Кипрей — 5 листочков свежих или слегка засушенных.
<br>13. Руна Манназ

<br><br><b>Приготовление:</b>

<br>1 этап — подготовительный. Растолочь лирный корень, душицу, пустырник; выжать сок лимона; снять с шиповника шкурку, чтобы осталась мякоть, очистить алоэ так же до мякоти. Достать листочки кипрея, зверобоя, эфирное масло лаванды, веточки чертополоха с цветами, подготовить воду, смешав в ней розовую воду.

<br>2 этап. Довести смесь воды до кипения, при появлении первых пузырьков уменьшить огонь до минимума. Далее нужно по очереди добавлять ингредиенты и помешивать после каждого добавления: чертополох, алоэ и шиповник вместе, масло лаванды, листочки кипрея. Оставить на малом огне на сорок минут, не закрывая крышкой. Спустя это время добавить так же по очереди, не перемешивая: лирный корень, душицу, зверобой, пустырник. Оставить на 20 минут под крышкой. После сразу же добавить лимонный сок.

<br>3 этап. Сразу же после добавления сока 15 минут выводить руну Манназ, палочкой, ложкой, главное, чтобы они не были деревянными, желательно керамические. Для добавления эффекта лучше будет в голове проговаривать свойства руны. Если есть малахитовый камень с высеченной руной, то после сока немедленно его добавить и помешивать 15 минут. Далее закрыть крышку, оставить на огне еще на 15 минут, после выключить и остудить, не снимая крышки и не трогая котел. Остужаться зелье должно естественным способом. При переливании в склянку зелье может быть теплым, но не должно быть горячим. Примерное время приготовления зелья: два с половиной часа и более.

<br><br><b>Последовательность добавления ингредиентов в котел: </b>Вода родниковая => Розовая вода => Чертополох => Алоэ древовидное (сок) => Ягоды шиповника => Эфирное масло лаванды => Кипрей => Лирный корень => Душица (сухие листья) => Зверобой => Пустырник пятилопастный (сухие листья) => Лимонный сок => Руна Манназ

<br><br><b>Итоговые характеристики зелья:</b> При правильном изготовлении будет иметь травяной цвет с темно-зелеными прожилками и вкраплениями желтого цвета или же малахитовый цвет. Запах душицы, свежий и легкий, с примесью запаха лимона.

<br><br><b>Магические свойства:</b> Успокоение, ясное и чистое сознание, трезвая оценка себя и ситуации без эмоций, стереотипов, программ.
Зелье поможет запустить в организме определенные процессы, помогающие ускорить успокоение и трезвый взгляд на мир. Использовать его можно при помутнении сознания, депрессии, просто при затяжном плохом настроении, при панических атаках, когда очень сильно волнуешься, боишься, то есть присутствует много страха.

<br><br><b>Побочные эффекты:</b> Если приготовить зелье неправильно, добавить не то количество ингредиентов или перепутать последовательность, побочные эффекты. Слишком сильно плачевных эффектов не будет, то есть летальный исход исключен из-за набора трав в зелье. Однако может быть дереализация, помутнение сознания, галлюцинации, тошнота и рвота, тремор тела, сонливость.

<hr>
</div>
";


if(@$_POST['begin']) {
    
    $random = rand(0, 9999);
    $geid = md5($random);
    $start = time();
    
    $check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion16'");
    	if(!mysqli_num_rows($check)) {
    	$query = mysqli_query($conn, "INSERT INTO `potions` SET `login`='$login', `lekvar`='potion16', `sessionid`='$geid', `timestart`='$start', `timefinish`='',`progress`=1");    
    	}
    
    
	$name = strip_tags($_POST['imie']);
}


$check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion16'");
$row = mysqli_fetch_array($check);
$progress = $row['progress'];
$igraid = $row['sessionid'];

 $recept = array("Вода родниковая", "Розовая вода", "Чертополох", "Алоэ древовидное (сок)", "Ягоды шиповника", "Эфирное масло лаванды", "Кипрей", "Лирный корень", "Душица (сухие листья)", "Зверобой", "Пустырник пятилопастный (сухие листья)", "Лимонный сок", "Руна Манназ");   
 sort($recept);
 $sumr = count($recept);

//Проверяем все ли нужные ингредиенты в котле
$sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid' ORDER BY `id`");
while($rr = mysqli_fetch_array($sql)) {
    
  $vkotle = array($rr['ingredient'] => 1);
  sort($vkotle);
  $sumd = count($vkotle);
  
$a += sizeof($vkotle);
$sum = substr($a,-1);
}
// все в котле зелье готовченко!
if($sumr == $a) {
     $gotovo .= 1;
     
      echo "Получилось! Всё готово.
     <br><b>Пожалуйста, заберите зелье, кликнув на него.</b></div>
     <br>
     <div id='raysDemoHolder'><div id='rays'></div>
     <center>
     <a href='?potion=16&takeaway=grant'><img class='readypotion float' src='https://magismo.ru/potions/images/clearmindpo.png' height='89'></a>
     </center>
     	
     </div> ";
     
     // Отдаём зелье владельцу
     if(@$_GET['potion'] == 16 and @$_GET['takeaway'] == "grant") {
         
        $sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
         if(mysqli_num_rows($sql)) {
    
         $date = date("Y-m-d", time());
         
        $nea =  $login; 
        $ima = explode(" ", $nea);
         $gde = "chat";
         $spent = "3.00";
         $potionn = "Зелье ментального восстановления";
         $keyword = "достаёт собственно-приготовленное <b>зелье ментального восстановления</b> и выпивает его. $ima[0] успокаивается, приобретает ясное и чистое сознание, трезвую оценку себя и ситуации без эмоций, стереотипов и программ.";
         $desc = "Успокоение, ясное и чистое сознание, трезвая оценка себя и ситуации без эмоций, стереотипов, программ.
Зелье поможет запустить в организме определенные процессы, помогающие ускорить успокоение и трезвый взгляд на мир. Использовать его можно при помутнении сознания, депрессии, просто при затяжном плохом настроении, при панических атаках, когда очень сильно волнуешься, боишься, то есть присутствует много страха.";
        //в депозитарий
         mysqli_query($conn, "INSERT INTO `depositarium` SET `tid`=0, `login`='$login', `date_add`='$date', `goodname`='$potionn', `spent`='$spent', `keyword` = '$keyword', `gooddescr`='$desc', `picture`='https://magismo.ru/potions/images/clearmindpo.png', `category`='magismo', `usable`=1, `wheretouse`='$gde', `used`=0, `shop`='lab'");     
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
     $myArr = array("Вода родниковая", "Розовая вода", "Чертополох", "Алоэ древовидное (сок)", "Ягоды шиповника", "Эфирное масло лаванды", "Кипрей", "Лирный корень", "Душица (сухие листья)", "Зверобой", "Пустырник пятилопастный (сухие листья)", "Лимонный сок", "Руна Манназ");  
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($tovar, $myArr, true); 
     if($vrecepte == 1) {
         echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
     } else {
       echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
     }
    
    
echo "<br><div id='puff'></div><a href='?potion=16&n=$tovar&t=$tovarid&s=$igraid' id='myLink'><span style='color:#ffffff')><img src='$tovarp' height='48'> <b> $tovar </b></span></a>";
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
     if(@$_GET['potion'] == 16 and @$_GET['n'] and @$_GET['t'] and @$_GET['s']) {
         $name = $_GET['n'];
         $tid = $_GET['t'];
         $sid = $_GET['s'];
    
     // Прописываем в массив ингредиенты для зелья
     $myArr = array("Вода родниковая", "Розовая вода", "Чертополох", "Алоэ древовидное (сок)", "Ягоды шиповника", "Эфирное масло лаванды", "Кипрей", "Лирный корень", "Душица (сухие листья)", "Зверобой", "Пустырник пятилопастный (сухие листья)", "Лимонный сок", "Руна Манназ");    
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($name, $myArr, true); 
     
     //Если да, то 
     if($vrecepte == 1) {
         
     //обозначаем предмет использованным
     mysqli_query($conn, "UPDATE `depositarium` SET `used`=1 WHERE `id` = '$tid'");
     //обозначаем что у нас в котле
     mysqli_query($conn, "INSERT INTO `potionkotel` SET `login`='$login', `sessionid`='$sid', `ingredient`='$name'");
     
    
     //возвращаем человеков ко главной
     echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=16'; }</script>";
     
     } else {
         echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=16'; }</script>";
     }
 }