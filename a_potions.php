<?php
// Подключаем конфиг
include "../config.php";

// Модули проверки авторизации, сессии и т.д.
include "topfile.php";

//Получаем данные о пользователе
$sql = "SELECT * FROM `users` WHERE `login`='$login'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($result);
$avatar = $rows['avatar'];
$nid = $rows['id'];
$kafedra = $rows['kafedra'];
$sex = $rows['sex'];
$fakultet = $rows['fac'];
$rang = $rows['rang'];
$data = $rows['data'];
$color_n = $rows['color_name'];
$color_t = $rows['color_text'];
$mail = $rows['email'];
$about = $rows['desc'];
$access = $rows['dostup'];
$prof = $rows['kafedra'];
$birthday = $rows['birth'];
$ex = explode("-", $birthday);
$birt = "$ex[2].$ex[1].$ex[0]";
$fon = $rows['lk_fon'];

// Получаем кол-во жителей
$sql = "SELECT COUNT(id) as `nas` FROM `users`";
$res = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($res);
$us = 0;
$us = $rows['nas'];

// Получаем кол-во жителей
$sql = "SELECT COUNT(id) as `ucitel` FROM `users` WHERE `dostup` > 7 and `dostup` < 13";
$res = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($res);
$uc = 0;
$uc = $rows['ucitel'];

// Получаем кол-во жителей
$sql = "SELECT COUNT(id) as `st` FROM `users` WHERE `dostup` > 0 and `dostup` < 5";
$res = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($res);
$st = 0;
$st = $rows['st'];

// Получаем кол-во непрочитанных сообщений
$sql = "SELECT COUNT(id) as `max` FROM `message` WHERE `recipient` = '$login' and status='0'";
$result = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($result);
$mess = 0;
$mess = $rows['max'];

// Получаем кол-во жителей
$sql = "SELECT COUNT(id) as `h` FROM `homework`";
$res = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($res);
$h = 0;
$h = $rows['h'];

// Получаем кол-во жителей
$sql = "SELECT COUNT(id) as `hw` FROM `homework` WHERE `status`!='1' and `status`!='2'";
$res = mysqli_query($conn, $sql);
$rows = mysqli_fetch_array($res);
$hw = 0;
$hw = $rows['hw'];


// Taking into account the reports
$sql_report = "SELECT SUM(`r`.`mark`) as `reports`,  `u`.`fac` as `fac` FROM `users` as `u` LEFT JOIN `reports` as `r` ON (`r`.`student` = `u`.`login`) WHERE `u`.`fac` != '-' and `u`.`dostup`>0 and `u`.`dostup`<6  GROUP BY `u`.`fac`";
$resultat = mysqli_query($conn, $sql_report);
$facs = array();
while($getr = mysqli_fetch_array($resultat)) {
    $facs[$getr['fac']]['reports'] = (int)$getr['reports'];
    $magnus_reports = $facs['Магнус']['reports'];
    $sajres_reports = $facs['Сайрес']['reports'];
    $bertraim_reports = $facs['Бертрайм']['reports'];
    $presct_reports = $facs['Прешт']['reports'];
}

// Получаем баллы всех факультетов и число студентов
$sql = "SELECT SUM(`h`.`mark`) as `ocena`,  `u`.`fac` as `fac` FROM `users` as `u` LEFT JOIN `homework` as `h` ON (`h`.`student` = `u`.`login`) WHERE `u`.`fac` != '-' and `u`.`dostup`>0 and `u`.`dostup`<6  GROUP BY `u`.`fac`";
$res = mysqli_query($conn, $sql);
$facs = array();
while($rows = mysqli_fetch_array($res)) {
    $facs[$rows['fac']]['ocena'] = (int)$rows['ocena'];
}


// TAKING INTO ACCOUNT FINES
$sql = "SELECT SUM(`p`.`ball`) as `penalty`,  `u`.`fac` as `fac` FROM `users` as `u` LEFT JOIN `penalty` as `p` ON (`p`.`student` = `u`.`login`) WHERE `u`.`fac` != '-' and `u`.`dostup`>0 and `u`.`dostup`<6  GROUP BY `u`.`fac`";
$res = mysqli_query($conn, $sql);
while($rows = mysqli_fetch_array($res)) {
	$facs[$rows['fac']]['fine'] = (int)$rows['penalty'];
}


$sql = "SELECT COUNT(`id`) as `countst`, `fac` FROM `users` WHERE `fac` != '-' and `dostup`>0 and `dostup`<6 GROUP BY `fac`";
$res = mysqli_query($conn, $sql);
$countst = array();
while($rows = mysqli_fetch_array($res)) {
    $countst[$rows['fac']] = $rows['countst'];
   
}

$sql1 = "SELECT SUM(`a`.`ball`) as `adminb`,  `u`.`fac` as `fac` FROM `users` as `u` LEFT JOIN `adminball` as `a` ON (`a`.`student` = `u`.`login`) WHERE `u`.`fac` != '-' and `u`.`dostup`>0 and `u`.`dostup`<6  GROUP BY `u`.`fac`";
$res1 = mysqli_query($conn, $sql1);
while($rows = mysqli_fetch_array($res1)) {
	$facs[$rows['fac']]['ab'] = (int)$rows['adminb'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head><meta charset="windows-1251">
    
    <title>Личная комната</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.js"></script>
  
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/loader-style.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="stylesheet" href="assets/css/profile.css">
            
            
            
<style type="text/css">
    body {
    background: url('https://magismo.ru/myroom/assets/img/<?=$fon?>.jpg') no-repeat top center fixed;
    }
    </style>


    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
     <!-- Favicon-->
    <link rel="shortcut icon" href="../favicon.ico">
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">&nbsp;</div>
    </div>
    <?php
    include_once "topbox.php";
    ?>

    
    <?php
    include_once "leftbox.php";
    ?>



    <!--  PAPER WRAP -->
    <div class="wrap-fluid">
        <div class="container-fluid paper-wrap bevel tlbr">





            <!-- CONTENT -->
            <!--TITLE -->
            <div class="row">
                <div id="paper-top">
                    <div class="col-sm-3">
                        <h5 class="tittle-content-header">
                            <i class="icon-media-record"></i> 
                            <span style="font-family:Candara;">Админка
                            </span>
                        </h5>

                    </div>

                    <div class="col-sm-7">
                        <div class="devider-vertical visible-lg"></div>
                        <div class="tittle-middle-header">



                        </div>

                    </div>
                    <div class="col-sm-2">
                       
                        


                    </div>
                </div>
            </div>
            <!--/ TITLE -->

            <!-- BREADCRUMB -->
            <ul id="breadcrumb">
                <li>
                    <span class="entypo-home"></span>
                </li>
                <li><i class="fa fa-lg fa-angle-right"></i>
                </li>
                <li>Административная панель</li>
                <li><i class="fa fa-lg fa-angle-right"></i></li>
                <li>Управление замком</li>
                
                
            </ul>

            <!-- END OF BREADCRUMB -->

           <div class="content-wrap">
                <div class="row">


                    <div class="col-sm-12">
                        <!-- BLANK PAGE-->

<?
  // User has access, proceed with page content
if ($currentLinkId !== null && userHasAccess($conn, $_SESSION['login'], $currentLinkId)) {
  

    ?>

                        <div class="nest" id="Blank_PageClose">
                            <div class="title-alt">
                                <h6>
                               Товары в чате - добавление</h6>
                                <div class="titleClose">
                                    <a class="gone" href="#Blank_PageClose">
                                        <span class="entypo-cancel"></span>
                                    </a>
                                </div>
                                <div class="titleToggle">
                                    <a class="nav-toggle-alt" href="#Blank_Page_Content">
                                        <span class="entypo-up-open"></span>
                                    </a>
                                </div>

                            </div>

                            <div class="body-nest" id="Blank_Page_Content">
                                
    <h5>Размер изображений не должен превышать 15 МБ</h5>                            
	<?php
	
	// ЗАКУСКИ //
$uploaddir = '../hall/imgs/zakuski/';
// это папка, в которую будет загружаться картинка
$apend=date('mdHis').rand(1,100).'.png'; 
// это имя, которое будет присвоенно изображению 
$uploadfile = "$uploaddir$apend"; 
//в переменную $uploadfile будет входить папка и имя изображения

// В данной строке самое важное - проверяем загружается ли изображение (а может вредоносный код?)
// И проходит ли изображение по весу. В нашем случае до 9 МБ
if(($_FILES['userfile']['type'] == 'image/gif' || $_FILES['userfile']['type'] == 'image/jpeg' || $_FILES['userfile']['type'] == 'image/png') && ($_FILES['userfile']['size'] != 0 and $_FILES['userfile']['size']<=15000000)) 
{ 
// Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб 
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
   { 
   //Здесь идет процесс загрузки изображения 
   $size = getimagesize($uploadfile); 
   // с помощью этой функции мы можем получить размер пикселей изображения 
     if ($size[0] < 2000 && $size[1]<2000) 
     { 
     // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте 
     echo "<h3>Картинка загружена!</h3> ССЫЛКА: <a href='https://magismo.ru/hall/imgs/zakuski/".$apend."' target='_blank'><b>".$apend."</a></b>
     <br>В поле ниже не копируйте полную ссылку, а только название файла \"12345.png\".<br>
     "; 
     } else {
     echo "Загружаемое изображение превышает допустимые нормы (ширина не более - 2000; высота не более 2000)<br>"; 
     unlink($uploadfile); 
     // удаление файла 
     } 
   } else {
   echo "Файл не загружен, вернитеcь и попробуйте еще раз<br>";
   } 
} else { 
echo "";
} 

// НАПИТКИ // 

$uploaddir = '../hall/imgs/napitki/';
// это папка, в которую будет загружаться картинка
$apend=date('mdHis').rand(1,100).'.png'; 
// это имя, которое будет присвоенно изображению 
$uploadfile = "$uploaddir$apend"; 
//в переменную $uploadfile будет входить папка и имя изображения

// В данной строке самое важное - проверяем загружается ли изображение (а может вредоносный код?)
// И проходит ли изображение по весу. В нашем случае до 9 МБ
if(($_FILES['napitki']['type'] == 'image/gif' || $_FILES['napitki']['type'] == 'image/jpeg' || $_FILES['napitki']['type'] == 'image/png') && ($_FILES['napitki']['size'] != 0 and $_FILES['napitki']['size']<=15000000)) 
{ 
// Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб 
  if (move_uploaded_file($_FILES['napitki']['tmp_name'], $uploadfile)) 
   { 
   //Здесь идет процесс загрузки изображения 
   $size = getimagesize($uploadfile); 
   // с помощью этой функции мы можем получить размер пикселей изображения 
     if ($size[0] < 10000 && $size[1]<10000) 
     { 
     // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте 
     echo "<h3>Картинка загружена!</h3> ССЫЛКА: <a href='https://magismo.ru/hall/imgs/napitki/".$apend."' target='_blank'><b>".$apend."</a></b>
     <br>В поле ниже не копируйте полную ссылку, а только название файла \"12345.png\".<br>
     "; 
     } else {
     echo "Загружаемое изображение превышает допустимые нормы (ширина не более - 2000; высота не более 2000)<br>"; 
     unlink($uploadfile); 
     // удаление файла 
     } 
   } else {
   echo "Файл не загружен, вернитеcь и попробуйте еще раз<br>";
   } 
} else { 
echo "";
} 

// EDA // 

$uploaddir = '../hall/imgs/eda/';
// это папка, в которую будет загружаться картинка
$apend=date('mdHis').rand(1,100).'.png'; 
// это имя, которое будет присвоенно изображению 
$uploadfile = "$uploaddir$apend"; 
//в переменную $uploadfile будет входить папка и имя изображения

// В данной строке самое важное - проверяем загружается ли изображение (а может вредоносный код?)
// И проходит ли изображение по весу. В нашем случае до 9 МБ
if(($_FILES['eda']['type'] == 'image/gif' || $_FILES['eda']['type'] == 'image/jpeg' || $_FILES['eda']['type'] == 'image/png') && ($_FILES['eda']['size'] != 0 and $_FILES['eda']['size']<=15000000)) 
{ 
// Указываем максимальный вес загружаемого файла. Сейчас до 512 Кб 
  if (move_uploaded_file($_FILES['eda']['tmp_name'], $uploadfile)) 
   { 
   //Здесь идет процесс загрузки изображения 
   $size = getimagesize($uploadfile); 
   // с помощью этой функции мы можем получить размер пикселей изображения 
     if ($size[0] < 2000 && $size[1]<2000) 
     { 
     // если размер изображения не более 500 пикселей по ширине и не более 1500 по  высоте 
     echo "<h3>Картинка загружена!</h3> ССЫЛКА: <a href='https://magismo.ru/hall/imgs/eda/".$apend."' target='_blank'><b>".$apend."</a></b>
     <br>В поле ниже не копируйте полную ссылку, а только название файла \"12345.png\".<br>
     "; 
     } else {
     echo "Загружаемое изображение превышает допустимые нормы (ширина не более - 2000; высота не более 2000)<br>"; 
     unlink($uploadfile); 
     // удаление файла 
     } 
   } else {
   echo "Файл не загружен, вернитеcь и попробуйте еще раз<br>";
   } 
} else { 
echo "";
} 

?>

<a onclick=expandit('create') href='javascript:void(0);' style='border-bottom: 1px dotted darkblue; color:darkblue; text-shadow: 2px white'>Добавить изображение для категории ЗАКУСКИ</a>
		<div id='create' style='display: none;'>
			<br>	<form name="upload" method="POST" ENCTYPE="multipart/form-data"> 
Выберите файл для загрузки: 
<input type="file" name="userfile"><br>
<button type="submit" name="upload" value="Загрузить" class="btn btn-primary">Загрузить</button>
</form>
</div>
<br /> 
<a onclick=expandit('create2') href='javascript:void(0);' style='border-bottom: 1px dotted darkgreen; color:darkgreen; text-shadow: 2px white'>Добавить изображение для категории НАПИТКИ</a>
		<div id='create2' style='display: none;'>
			<br>	<form name="upload" method="POST" ENCTYPE="multipart/form-data"> 
Выберите файл для загрузки: 
<input type="file" name="napitki"><br>
<button type="submit" name="upload" value="Загрузить" class="btn btn-primary">Загрузить</button>
</form>
</div>
<br /> 
<a onclick=expandit('create3') href='javascript:void(0);' style='border-bottom: 1px dotted darkviolet; color:darkviolet; text-shadow: 2px white'>Добавить изображение для категории БЛЮДА</a>
		<div id='create3' style='display: none;'>
			<br>	<form name="upload" method="POST" ENCTYPE="multipart/form-data"> 
Выберите файл для загрузки: 
<input type="file" name="eda"><br>
<button type="submit" name="upload" value="Загрузить" class="btn btn-primary">Загрузить</button>
</form>
</div>

			
<br /> <br />

                           <?php
	//добавляем товары 
if(@$_POST['cat']) {
    $nazwa = $_POST['name'];
    $url = $_POST['link'];
    $junit = $_POST['junit'];
    $drobna = $_POST['drobna'];
    $cat = strip_tags($_POST['type']);
    $status = (int)$_POST['status'];
    
    $gold = $_POST['gold'] ?? 0;
    $silver = $_POST['silver'] ?? 0;
    $bronze = $_POST['bronze'] ?? 0;
    
    // Convert the entered amount to bronze
    $naz_in_bronze = ($gold * 80 * 12) + ($silver * 12) + $bronze;
     
     	if($nazwa) {
			// И добавляем в базу
			$sql = "INSERT INTO `sell_chat` SET `title` = '$nazwa',  `url` = '$url', `reformed_price` = '$naz_in_bronze', `cat`='$cat', `status`='$status'";
			$res = mysqli_query($conn, $sql);
			echo "<br><br><font color='00FF33' size='4'>ГОТОВО!
			<br>Обновление данных...</font>
				<script language='javascript' type='text/javascript'>
    window.onLoad=poscrolim();
    
    function poscrolim(){
        location.href='a_chatmenu.php';
    }
</script>";	
} else  echo "<b><font color='#33FFCC' size='4'>Вы забыли указать название товара в форме!</font></b><br>";
}

// если нажато Скрыть
		if(@$_GET['hide']) {
		    $idsubj = (int)$_GET['hide'];
			$sql = "UPDATE `menu_header` SET `status`='0' WHERE id='$idsubj'";
			mysqli_query($conn, $sql);
			
		}
// если нажато Открыть
		if(@$_GET['view']) {
		    $idsubj = (int)$_GET['view'];
			$sql = "UPDATE `menu_header` SET `status`='1' WHERE id='$idsubj'";
			mysqli_query($conn, $sql);
			
		}
		
		// если нажато Удалить
		if(@$_GET['remove']) {
		    $idsubj = (int)$_GET['remove'];
			$sql = "DELETE FROM `menu_header` WHERE id='$idsubj'";
			mysqli_query($conn, $sql);
			
		}
		
?>
     
<form method='post' name='cat'>
    <h5>Название товара</h5>
	<input type='text' name='name' class="form-control" />
	
	<h5>Ссылка на изображение в PNG формате</h5>
	<small>Не должно быть белого фона сзади</small>
	<input type='text' name='link' class="form-control" />
	
	<h5>Цена</h5>
	<table style="width:40%;">
	    <tr>
	       	<div class="form-group">
        <label for="gold"><img src='https://magismo.ru/images/junit_new.png' height='20' title='Юнийт' style='vertical-align: middle'> Золотые:</label>
        <input name='gold' type="number" min="0" class="form-control" id="gold" style='width:15%' value="0">
    </div>
    <div class="form-group">
        <label for="silver"><img src='https://magismo.ru/images/drobna_new.png' height='18' title='Дробна' class='another' style='vertical-align: middle'> Серебряные:</label>
        <input name='silver' type="number" min="0" max="80" class="form-control" id="silver" style='width:15%' value="0">
    </div>
    <div class="form-group">
        <label for="bronze"><img src='https://magismo.ru/images/medolva2.png' height='15' title='Медолва' style='vertical-align: middle'> Бронзовые:</label>
        <input name='bronze' type="number" min="0" max="12" class="form-control" id="bronze" style='width:15%' value="0">
    </div>
	   
	    </tr>
	    <small>Обязательно сопровождать дробные с нулём. Если, стоимость 5 серебрянных, то вписываем 05. К юнитам не нужно добавлять 0. Если стоимость товара только в серебрянных, в юнийтах вписать 0.</small>
	    
	</table>
	
	  <br>
	
	<h5>Категория</h5>
    <select name='type' class="form-control">
	<option value=''></option>
	<option value='Закуски'> Закуски</option>
	<option value='Блюда'> Блюда</option>
	<option value='Напитки'> Напитки</option>
	</select>
	
	<h5>Статус</h5>
	<small>Да - Товар будет виден сразу в меню, Нет - Товар будет скрыт.</small>
    <select name='status' class="form-control">
	<option value=''></option>
	<option value='1'> Да</option>
	<option value='0'> Нет</option>
	</select><br><br>

	<input type='submit' name='cat' value='Добавить' class="btn btn-primary" />
	
</form>     
                                
                            </div>
                        </div>
                    <?
} else {
    // Show the restricted access message
    echo "<br><h2>У Вас нет доступа к этой странице!</h2>";
    echo "<i>Если Вы считаете, что должны иметь доступ к данной локации, пожалуйста, обратитесь в <a href='https://magismo.ru/feedback.php'>службу технической поддержки</a>.</i> ";
}
?>
                    </div>
                    <!-- END OF BLANK PAGE -->


                </div>
</div>


                <!-- /END OF CONTENT -->



                <!-- FOOTER -->
                <div class="footer-space"></div>
                <div id="footer">
                    <div class="devider-footer-left"></div>
                    <div class="time"> 
                        <p id="spanDate"></p>
                        <p id="clock"></p>
                    </div>
                    <div class="devider-footer-left"></div>
            
                    <div class="copyright">Мир магии и волшебства Магисмо &copy; 2011 - <? echo date('Y');?></div>
                    <div class="devider-footer"></div>

                </div>
                <!-- / END OF FOOTER -->


            </div>
        </div>
        <!--  END OF PAPER WRAP -->

        
    <?php
    include_once "rightbox.php";
    ?>

        <!-- MAIN EFFECT -->
        <script type="text/javascript" src="assets/js/preloader.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="assets/js/app.js"></script>
        <script type="text/javascript" src="assets/js/load.js"></script>
        <script type="text/javascript" src="assets/js/main.js"></script>
<script type="text/javascript">
    $(function() {
        startTime();
        $(".center").center();
        $(window).resize(function() {
            $(".center").center();
        });
    });

    /*  */

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();

        // add a zero in front of numbers<10
        m = checkTime(m);
        s = checkTime(s);

        //Check for PM and AM
        var day_or_night = (h > 11) ? "PM" : "AM";

        //Convert to 12 hours system
        if (h > 24)
            h -= 24;

        //Add time to the headline and update every 500 milliseconds
        $('#time').html(h + ":" + m + ":" + s + " ");
        setTimeout(function() {
            startTime()
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    /* CENTER ELEMENTS IN THE SCREEN */
    jQuery.fn.center = function() {
        this.css("position", "absolute");
        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) +
            $(window).scrollTop()) - 30 + "px");
        this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) +
            $(window).scrollLeft()) + "px");
        return this;
    }
    </script>
    <script>
function expandit(id){

  obj = document.getElementById(id);

  if (obj.style.display=='none') obj.style.display='';

  else obj.style.display='none';}
</script>	
</body>

</html>
