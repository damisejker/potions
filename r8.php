<?php
// Противоаллергическое зелье
if(@$_GET['potion'] == 8) {
 echo "<div class='content'>";
 
 echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | <a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> |  <a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a> | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>
<h3>ЗЕЛЬЕ \"ХРАНИТЕЛЬ ОТ НЕЧИСТИ\"</h3>
<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>    
<div id='recipe' style='display: none;'>
<b>Стоимость ингредиентов за зелье:</b> &#8930;0,36
<br><br>
<b>Ингредиенты:</b>

<br>Бутылёк с очищенной водой
<br>Чертополох - 5 цветков
<br>Зверобой - 4 веточки 
<br>Полынь (сухие листья) - 3 веточки 

<br><br><b>Приготовление:</b>

<br>Зверобой и чертополох мелко покрошить, положить в сухой котел и заварить литром крутого кипятка. Поставить котел на средний огонь, после чего медленно помешать зелье по часовой стрелке 12 раз, проговаривая \"варись-варись, хранитель, от сил недобрых избавитель, защити, заслони, очисти\".
<br>Когда зелье закипит, уменьшить огонь, подождать 10 минут. В это время растереть в пыль веточки полыни в ступке и осторожно всыпать их в котел. Помешать 5 раз по часовой стрелке, выключить. Процедить.
<br>Перелить зелье в керамическую посуду или склянку, неплотно прикрыть крышкой на полчаса. После этого можно употреблять или закрыть плотно крышкой или пробкой, хранить в темном месте при температуре не более 20 градусов. Срок хранения зелья: 10 дней, магическими способами можно продлить его.

<br><br><b>Последовательность добавления ингредиентов в котел: </b>Бутылёк с очищенной водой => Зверобой => Чертополох => Полынь (сухие листья)
<br><br><b>Итоговые характеристики зелья:</b> Желтовато-коричневатого цвета прозрачная жидкость с резковатым специфическим запахом и горьковатым вкусом.
<br><br><b>Магические свойства:</b> Будет снято до 80% уже нанесенного нечистью вреда нефизического рода: морок, оцепенение, резкий упадок сил, наведенная тоска и прочее. При принятии зелья до встречи с нечистью, она не сможет причинить никакого вреда.
<br>Наступает действие в среднем через 1 минуту после употребления зелья, доится в зависимости от выпитого количества (в глотках): 1 глоток - 30 минут, каждый последующий глоток по 15 минут.
<br><br><b>Побочные эффекты:</b> если зелье принимать очень часто, то могут возникнуть запоры, боль в печени, галлюцинации и судороги, если много - может быть замедление реакций, сонливость. Не рекомендуется или рекомендуется в малых дозах при стойком повышении кровяного давления. Нельзя при малокровии, тромбофлебите, обострении заболеваний ЖКТ, беременным и кормящим женщинам.
<hr>
</div>
";


if(@$_POST['begin']) {
    
    $random = rand(0, 9999);
    $geid = md5($random);
    $start = time();
    
    $check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion8'");
    	if(!mysqli_num_rows($check)) {
    	$query = mysqli_query($conn, "INSERT INTO `potions` SET `login`='$login', `lekvar`='potion8', `sessionid`='$geid', `timestart`='$start', `timefinish`='',`progress`=1");    
    	}
    
    
	$name = strip_tags($_POST['imie']);
}


$check = mysqli_query($conn, "SELECT * FROM `potions` WHERE `login`='$login' and `lekvar`='potion8'");
$row = mysqli_fetch_array($check);
$progress = $row['progress'];
$igraid = $row['sessionid'];

 $recept = array("Бутылёк с очищенной водой", "Зверобой", "Чертополох", "Полынь (сухие листья)");   
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
     <a href='?potion=8&takeaway=grant'><img class='readypotion float' src='https://magismo.ru/potions/images/evilspiritprotect.png' height='89'></a>
     </center>
     	
     </div> ";
     
     // Отдаём зелье владельцу
     if(@$_GET['potion'] == 8 and @$_GET['takeaway'] == "grant") {
         
        $sql = mysqli_query($conn, "SELECT * FROM `potionkotel` WHERE `login`='$login' and `sessionid`='$igraid'");
         if(mysqli_num_rows($sql)) {
    
         $date = date("Y-m-d", time());
         
        $nea =  $login; 
        $ima = explode(" ", $nea);
         $gde = "chat";
         $spent = "0.36";
         $potionn = "Зелье \"Хранитель от нечисти\"";
         $keyword = "выпивает собственно-приготовленное <b>зелье \"Хранитель от нечисти\"</b>. Зелье снимает 80% уже нанесенного нечистью вреда нефизического рода: морок, оцепенение, резкий упадок сил, наведенная тоска и прочее. $ima[0] защищён следующие 30 минут от нечисти.";
         $desc = "Будет снято до 80% уже нанесенного нечистью вреда нефизического рода: морок, оцепенение, резкий упадок сил, наведенная тоска и прочее. При принятии зелья до встречи с нечистью, она не сможет причинить никакого вреда.
Наступает действие в среднем через 1 минуту после употребления зелья, длится в зависимости от выпитого количества (в глотках): 1 глоток - 30 минут, каждый последующий глоток по 15 минут.";
        //в депозитарий
         mysqli_query($conn, "INSERT INTO `depositarium` SET `tid`=0, `login`='$login', `date_add`='$date', `goodname`='$potionn', `spent`='$spent', `keyword` = '$keyword', `gooddescr`='$desc', `picture`='https://magismo.ru/potions/images/evilspiritprotect.png', `category`='magismo', `usable`=1, `wheretouse`='$gde', `used`=0, `shop`='lab'");     
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
     $myArr = array("Бутылёк с очищенной водой", "Зверобой", "Чертополох", "Полынь (сухие листья)");  
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($tovar, $myArr, true); 
     if($vrecepte == 1) {
         echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
     } else {
       echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
     }
    
    
echo "<br><div id='puff'></div><a href='?potion=8&n=$tovar&t=$tovarid&s=$igraid' id='myLink'><span style='color:#ffffff')><img src='$tovarp' height='48'> <b> $tovar </b></span></a>";
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
     if(@$_GET['potion'] == 8 and @$_GET['n'] and @$_GET['t'] and @$_GET['s']) {
         $name = $_GET['n'];
         $tid = $_GET['t'];
         $sid = $_GET['s'];
    
     // Прописываем в массив ингредиенты для зелья
     $myArr = array("Бутылёк с очищенной водой", "Зверобой", "Чертополох", "Полынь (сухие листья)");   
     // Проверяем добавляем ли мы всё по рецепту
     $vrecepte = in_array($name, $myArr, true); 
     
     //Если да, то 
     if($vrecepte == 1) {
         
     //обозначаем предмет использованным
     mysqli_query($conn, "UPDATE `depositarium` SET `used`=1 WHERE `id` = '$tid'");
     //обозначаем что у нас в котле
     mysqli_query($conn, "INSERT INTO `potionkotel` SET `login`='$login', `sessionid`='$sid', `ingredient`='$name'");
     
    
     //возвращаем человеков ко главной
     echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=8'; }</script>";
     
     } else {
         echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=8'; }</script>";
     }
 }