<?php
// Противоаллергическое зелье
if(@$_GET['potion'] == 7) {
 echo "<div class='content'>";
 
 echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | <a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>
<h3>ЗЕЛЬЕ \"ЩИТ ЯСНОГО СОЗНАНИЯ\"</h3>
<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>    
<div id='recipe' style='display: none;'>
<b>Стоимость ингредиентов за зелье:</b> &#8930;0,64
<br><br>
<b>Ингредиенты:</b>

<br>Вода речная – 1 л
<br>Шалфей (сухие листья) – 65 г
<br>Полынь (сухие листья) – 25 г
<br>Бегония (сухие листья) – 40 г
<br>Коралл белый (мелкий порошок) – 8 г
<br>Алоэ древовидное (сок) – 12 мл
<br>Экстракт имбиря – 15 мл

<br><br><b>Приготовление:</b>

<br>В небольшой медный или оловянный котел налить 1 литр чистой речной воды, поставить на средний огонь. Пока вода закипает, приготовить ингредиенты. Листья должны быть без веточек и черешков, коралл в виде мелкого порошка, при необходимости растолочь в ступке, сок алоэ приготовить свежий или взять консервированный, разбавить пятьюдесятью миллилитрами воды. Когда вода закипит, положить листья шалфея и полыни, перемешать. Мешать зелье строго по часовой стрелке, количество помешиваний значения не имеет. Добавить листья бегонии, помешать, варить 5 мин. Высыпать порошок коралла, мешать 1 мин., убавить огонь, томить 30 мин. Влить разбавленный сок алоэ, хорошо помешать зелье, варить 5 мин, круговыми движениями влить экстракт имбиря и сразу снять с огня.
<br>Для усиленного варианта произнести заклинание «ментальный блок», держа руку над котелком или указывая на него волшебной палочкой (доступно только для ментальных магов).
<br>Закрыть котелок крышкой, настаивать зелье 12 часов при комнатной температуре, после чего процедить через мелкое сито и разлить по бутылочкам. Срок годности — 1 год, после его истечения зелье постепенно теряет свои свойства.

<br><br><b>Последовательность добавления ингредиентов в котел: </b>Вода речная => Шалфей (сухие листья) => Полынь (сухие листья) => Бегония (сухие листья) => Коралл белый (мелкий порошок) => Алоэ древовидное (сок) => Экстракт имбиря
<br><br><b>Итоговые характеристики зелья:</b> В готовом виде зелье зеленоватое, полупрозрачное со слабо полынным запахом и горько-травяным вкусом. 
<br><br><b>Магические свойства:</b> Защищает сознание от ментальных воздействий – магии подчинения, легилименции, телепатии, чтения мыслей. Приготовить его может любой зельевар среднего уровня, но у ментального мага зелье получится сильнее. Применение: перед возможной атакой выпить одну порцию зелья – 30 мл. Время действия до 5 часов, зависит от силы и продолжительности воздействия на сознание, при сильной ментальной атаке время действия сокращается до часа, защита может быть не полной.

<hr>
</div>
";


if(@$_POST['begin']) {
    
    $random = rand(0, 9999);
    $geid = md5($random);
    $start = time();
    
    $check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion7'");
    	if(!mysqli_num_rows($check)) {
    	$query = mysqli_query($conn, "INSERT INTO `potions` SET `login`='$login', `lekvar`='potion7', `sessionid`='$geid', `timestart`='$start', `timefinish`='',`progress`=1");    
    	}
    
    
	$name = strip_tags($_POST['imie']);
}


$check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion7'");
$row = mysqli_fetch_array($check);
$progress = $row['progress'];
$igraid = $row['sessionid'];

 $recept = array("Вода речная", "Шалфей (сухие листья)", "Полынь (сухие листья)", "Бегония (сухие листья)", "Коралл белый (мелкий порошок)", "Алоэ древовидное (сок)", "Экстракт имбиря");   
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
     <a href='?potion=7&takeaway=grant'><img class='readypotion float' src='https://magismo.ru/potions/images/brightmind.png' height='89'></a>
     </center>
     	
     </div> ";
     
     // Отдаём зелье владельцу
     if(@$_GET['potion'] == 7 and @$_GET['takeaway'] == "grant") {
         
        $sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
         if(mysqli_num_rows($sql)) {
    
         $date = date("Y-m-d", time());
         
        $nea =  $login; 
        $ima = explode(" ", $nea);
         $gde = "chat";
         $spent = "0.64";
         $keyword = "выпивает собственно-приготовленное <b>зелье \"Щит ясного сознания\"</b> и ощущает как сознание приобретает защиту от ментальных воздействий – магии подчинения, легилименции, телепатии и чтения мыслей. $ima[0] ментально неуязвим следующие 5 часов.";
         $desc = "Защищает сознание от ментальных воздействий – магии подчинения, легилименции, телепатии, чтения мыслей. Приготовить его может любой зельевар среднего уровня, но у ментального мага зелье получится сильнее.";
        //в депозитарий
         mysqli_query($conn, "INSERT INTO `depositarium` SET `tid`=0, `login`='$login', `date_add`='$date', `goodname`='Зелье \"Щит ясного сознания\"', `spent`='$spent', `keyword` = '$keyword', `gooddescr`='$desc', `picture`='https://magismo.ru/potions/images/brightmind.png', `category`='magismo', `usable`=1, `wheretouse`='$gde', `used`=0, `shop`='lab'");     
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
     $myArr = array("Вода речная", "Шалфей (сухие листья)", "Полынь (сухие листья)", "Бегония (сухие листья)", "Коралл белый (мелкий порошок)", "Алоэ древовидное (сок)", "Экстракт имбиря");  
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($tovar, $myArr, true); 
     if($vrecepte == 1) {
         echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
     } else {
       echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
     }
    
    
echo "<br><div id='puff'></div><a href='?potion=7&n=$tovar&t=$tovarid&s=$igraid' id='myLink'><span style='color:#ffffff')><img src='$tovarp' height='48'> <b> $tovar </b></span></a>";
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
     if(@$_GET['potion'] == 7 and @$_GET['n'] and @$_GET['t'] and @$_GET['s']) {
         $name = $_GET['n'];
         $tid = $_GET['t'];
         $sid = $_GET['s'];
    
     // Прописываем в массив ингредиенты для зелья
     $myArr = array("Вода речная", "Шалфей (сухие листья)", "Полынь (сухие листья)", "Бегония (сухие листья)", "Коралл белый (мелкий порошок)", "Алоэ древовидное (сок)", "Экстракт имбиря");   
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($name, $myArr, true); 
     
     //Если да, то 
     if($vrecepte == 1) {
         
     //обозначаем предмет использованным
     mysqli_query($conn, "UPDATE `depositarium` SET `used`=1 WHERE `id` = '$tid'");
     //обозначаем что у нас в котле
     mysqli_query($conn, "INSERT INTO `potionkotel` SET `login`='$login', `sessionid`='$sid', `ingredient`='$name'");
     
    
     //возвращаем человеков ко главной
     echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=7'; }</script>";
     
     } else {
         echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=7'; }</script>";
     }
 }