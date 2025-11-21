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
                               Управление рецептами зелий</h6>
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

    <style>
    .ingredient-row {
        padding: 10px;
        margin: 5px 0;
        background: #f5f5f5;
        border-radius: 4px;
    }
    .ingredient-select {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
    }
    .ingredient-image {
        width: 32px;
        height: 32px;
        object-fit: contain;
    }
    .btn-remove-ingredient {
        background: #d9534f;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 3px;
    }
    .total-cost-display {
        font-size: 18px;
        font-weight: bold;
        color: #5cb85c;
        padding: 10px;
        background: #f0f9f0;
        border-radius: 4px;
        margin: 10px 0;
    }
    .recipe-table {
        width: 100%;
        margin-top: 20px;
    }
    .recipe-table th {
        background: #337ab7;
        color: white;
        padding: 10px;
    }
    .recipe-table td {
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }
    .recipe-table img {
        max-height: 50px;
    }
    .action-btn {
        margin: 2px;
        padding: 5px 10px;
        font-size: 12px;
    }
    </style>                            
	<?php

	// ========== IMAGE UPLOAD FOR POTIONS ==========
	$uploaddir = 'images/';
	$uploaded_image_name = '';
	$upload_full_url = '';

	// Check if directory exists, create if not
	if (!file_exists($uploaddir)) {
		mkdir($uploaddir, 0755, true);
	}

	// Handle image upload
	if(isset($_FILES['potion_image']) && ($_FILES['potion_image']['type'] == 'image/gif' ||
	   $_FILES['potion_image']['type'] == 'image/jpeg' ||
	   $_FILES['potion_image']['type'] == 'image/png') &&
	   ($_FILES['potion_image']['size'] != 0 && $_FILES['potion_image']['size'] <= 15000000))
	{
		$apend = date('mdHis').rand(1,100).'.png';
		$uploadfile = $uploaddir . $apend;

		if (move_uploaded_file($_FILES['potion_image']['tmp_name'], $uploadfile)) {
			$size = getimagesize($uploadfile);
			if ($size[0] < 2000 && $size[1] < 2000) {
				$uploaded_image_name = $apend;
				$upload_full_url = "https://magismo.ru/potions/images/" . $apend;
				echo "<div class='alert alert-success'><h4>✓ Изображение загружено успешно!</h4>";
				echo "<p><b>Ссылка:</b> <a href='" . htmlspecialchars($upload_full_url) . "' target='_blank'>" . htmlspecialchars($upload_full_url) . "</a></p>";
				echo "<p><small>Ссылка автоматически вставлена в форму ниже</small></p></div>";
			} else {
				echo "<div class='alert alert-danger'>Изображение превышает допустимые размеры (макс. 2000x2000px)</div>";
				unlink($uploadfile);
			}
		} else {
			echo "<div class='alert alert-danger'>Ошибка загрузки файла</div>";
		}
	}

	// ========== HANDLE RECIPE ACTIONS ==========

	// Add new recipe
	if(isset($_POST['add_recipe'])) {
		$potion_key = mysqli_real_escape_string($conn, $_POST['potion_key']);
		$potion_number = mysqli_real_escape_string($conn, $_POST['potion_number']);
		$name = mysqli_real_escape_string($conn, $_POST['recipe_name']);
		$image_url = mysqli_real_escape_string($conn, $_POST['image_url']);
		$usage_keyword = mysqli_real_escape_string($conn, $_POST['usage_keyword']);
		$description = mysqli_real_escape_string($conn, $_POST['description']);
		$redirect_url = mysqli_real_escape_string($conn, $_POST['redirect_url']);
		$is_active = (int)$_POST['is_active'];
		$requires_tournament = (int)$_POST['requires_tournament'];
		$total_cost = (float)$_POST['total_cost'];

		if($name && $potion_key && $potion_number) {
			// Insert recipe
			$stmt = mysqli_prepare($conn, "INSERT INTO `recipes` SET `potion_key`=?, `potion_number`=?, `name`=?, `cost`=?, `image_url`=?, `usage_keyword`=?, `description`=?, `redirect_url`=?, `is_active`=?, `requires_tournament`=?");
			mysqli_stmt_bind_param($stmt, "sssdssssii", $potion_key, $potion_number, $name, $total_cost, $image_url, $usage_keyword, $description, $redirect_url, $is_active, $requires_tournament);

			if(mysqli_stmt_execute($stmt)) {
				$recipe_id = mysqli_insert_id($conn);

				// Insert ingredients
				if(isset($_POST['ingredients']) && is_array($_POST['ingredients'])) {
					$order = 1;
					foreach($_POST['ingredients'] as $ingredient_name) {
						if(!empty($ingredient_name)) {
							$stmt_ing = mysqli_prepare($conn, "INSERT INTO `recipe_ingredients` SET `recipe_id`=?, `ingredient_name`=?, `sort_order`=?");
							mysqli_stmt_bind_param($stmt_ing, "isi", $recipe_id, $ingredient_name, $order);
							mysqli_stmt_execute($stmt_ing);
							mysqli_stmt_close($stmt_ing);
							$order++;
						}
					}
				}

				echo "<div class='alert alert-success'><h4>✓ Рецепт успешно добавлен!</h4></div>";
				echo "<script>setTimeout(function(){ location.href='a_potions.php'; }, 2000);</script>";
			} else {
				echo "<div class='alert alert-danger'>Ошибка при добавлении рецепта</div>";
			}
			mysqli_stmt_close($stmt);
		} else {
			echo "<div class='alert alert-danger'>Заполните все обязательные поля</div>";
		}
	}

	// Toggle recipe visibility
	if(isset($_GET['toggle_active'])) {
		$recipe_id = (int)$_GET['toggle_active'];
		$stmt = mysqli_prepare($conn, "UPDATE `recipes` SET `is_active` = NOT `is_active` WHERE `id` = ?");
		mysqli_stmt_bind_param($stmt, "i", $recipe_id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		echo "<script>location.href='a_potions.php';</script>";
	}

	// Delete recipe
	if(isset($_GET['delete_recipe'])) {
		$recipe_id = (int)$_GET['delete_recipe'];
		// Ingredients will be deleted automatically due to CASCADE
		$stmt = mysqli_prepare($conn, "DELETE FROM `recipes` WHERE `id` = ?");
		mysqli_stmt_bind_param($stmt, "i", $recipe_id);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		echo "<script>location.href='a_potions.php';</script>";
	}

?>

<!-- IMAGE UPLOAD SECTION -->
<a onclick="expandit('upload_section')" href="javascript:void(0);" style="border-bottom: 1px dotted #5bc0de; color:#5bc0de; font-weight:bold">
	📤 Загрузить изображение готового зелья
</a>
<div id='upload_section' style='display: none; margin: 15px 0; padding: 15px; background: #f9f9f9; border-radius: 4px;'>
	<form method="POST" enctype="multipart/form-data">
		<label><b>Выберите изображение:</b></label>
		<input type="file" name="potion_image" accept="image/png,image/jpeg,image/gif" class="form-control" style="margin: 10px 0;">
		<button type="submit" class="btn btn-info">Загрузить изображение</button>
		<p><small>Изображение будет загружено в папку <code>/potions/images/</code> и ссылка автоматически вставится в форму</small></p>
	</form>
</div>

<hr style="margin: 20px 0;">

<!-- RECIPE CREATION FORM -->
<a onclick="expandit('recipe_form')" href="javascript:void(0);" style="border-bottom: 1px dotted #5cb85c; color:#5cb85c; font-weight:bold">
	➕ Добавить новый рецепт зелья
</a>
<div id='recipe_form' style='display: none;'>
<br>
<form method='post' id='recipeForm'>

	<div class="row">
		<div class="col-md-6">
			<h5>Potion Key <span style="color:red">*</span></h5>
			<small>Уникальный идентификатор (например: potion18, kmarst4)</small>
			<input type='text' name='potion_key' class="form-control" required />
		</div>

		<div class="col-md-6">
			<h5>Potion Number <span style="color:red">*</span></h5>
			<small>Номер для GET параметра (например: 18, kmarst4)</small>
			<input type='text' name='potion_number' class="form-control" required />
		</div>
	</div>

	<h5>Название зелья <span style="color:red">*</span></h5>
	<input type='text' name='recipe_name' class="form-control" required />

	<h5>Ссылка на изображение готового зелья <span style="color:red">*</span></h5>
	<small>Полная ссылка или загрузите изображение выше</small>
	<input type='text' name='image_url' id='image_url' class="form-control" value="<?php echo htmlspecialchars($upload_full_url); ?>" required />

	<h5>Описание эффектов зелья</h5>
	<textarea name='description' class="form-control" rows="3"></textarea>

	<h5>Usage Keyword</h5>
	<small>Текст, который появляется когда игрок использует зелье. Используйте {name} для имени игрока</small>
	<textarea name='usage_keyword' class="form-control" rows="2"></textarea>

	<h5>Redirect URL (необязательно)</h5>
	<small>Оставьте пустым для стандартного редиректа на /potions/</small>
	<input type='text' name='redirect_url' class="form-control" placeholder="https://magismo.ru/myroom/kmarst.php" />

	<br>
	<h5>Ингредиенты <span style="color:red">*</span></h5>
	<small>Выберите ингредиенты из магазина зелий</small>

	<div id="ingredients_container">
		<div class="ingredient-row">
			<div class="ingredient-select">
				<select name="ingredients[]" class="form-control ingredient-selector" style="flex: 1;" onchange="updateCost()">
					<option value="">-- Выберите ингредиент --</option>
					<?php
					// Load available ingredients from shop_goods
					$ing_query = "SELECT `goodname`, `picture`, `reformed_price` FROM `shop_goods`
								  WHERE `category` IN ('plants', 'fruits', 'liquids', 'animals', 'stones', 'powder')
								  AND `shop` = 'potions'
								  ORDER BY `goodname`";
					$ing_result = mysqli_query($conn, $ing_query);
					while($ing = mysqli_fetch_assoc($ing_result)) {
						$price = number_format($ing['reformed_price'] / (80 * 12), 2); // Convert to junit
						echo "<option value='" . htmlspecialchars($ing['goodname']) . "' data-price='" . $ing['reformed_price'] . "' data-image='" . htmlspecialchars($ing['picture']) . "'>";
						echo htmlspecialchars($ing['goodname']) . " (₽" . $price . ")";
						echo "</option>";
					}
					?>
				</select>
				<button type="button" class="btn-remove-ingredient" onclick="removeIngredient(this)" style="display:none;">Удалить</button>
			</div>
		</div>
	</div>

	<button type="button" class="btn btn-success" onclick="addIngredient()">+ Добавить ингредиент</button>

	<div class="total-cost-display">
		Общая стоимость: ₽<span id="total_cost_display">0.00</span>
		<input type="hidden" name="total_cost" id="total_cost" value="0">
	</div>

	<div class="row">
		<div class="col-md-6">
			<h5>Статус</h5>
			<select name='is_active' class="form-control">
				<option value='1'>Активен (виден игрокам)</option>
				<option value='0'>Скрыт</option>
			</select>
		</div>

		<div class="col-md-6">
			<h5>Требует турнир?</h5>
			<select name='requires_tournament' class="form-control">
				<option value='0'>Нет</option>
				<option value='1'>Да (только участникам)</option>
			</select>
		</div>
	</div>

	<br>
	<button type='submit' name='add_recipe' class="btn btn-primary btn-lg">Сохранить рецепт</button>

</form>
</div>

<script>
function addIngredient() {
	const container = document.getElementById('ingredients_container');
	const newRow = document.createElement('div');
	newRow.className = 'ingredient-row';
	newRow.innerHTML = container.querySelector('.ingredient-row').innerHTML;
	container.appendChild(newRow);

	// Show remove button on all rows except first
	document.querySelectorAll('.btn-remove-ingredient').forEach(btn => btn.style.display = 'inline-block');
	updateCost();
}

function removeIngredient(btn) {
	const rows = document.querySelectorAll('.ingredient-row');
	if(rows.length > 1) {
		btn.closest('.ingredient-row').remove();
		if(document.querySelectorAll('.ingredient-row').length === 1) {
			document.querySelector('.btn-remove-ingredient').style.display = 'none';
		}
		updateCost();
	}
}

function updateCost() {
	let total = 0;
	document.querySelectorAll('.ingredient-selector').forEach(select => {
		const option = select.options[select.selectedIndex];
		if(option && option.dataset.price) {
			total += parseFloat(option.dataset.price);
		}
	});

	// Convert from bronze to junit (1 junit = 80 silver = 960 bronze)
	const totalJunit = total / (80 * 12);
	document.getElementById('total_cost_display').textContent = totalJunit.toFixed(2);
	document.getElementById('total_cost').value = totalJunit.toFixed(2);
}

// Initialize cost calculation
document.addEventListener('DOMContentLoaded', function() {
	document.querySelectorAll('.ingredient-selector').forEach(select => {
		select.addEventListener('change', updateCost);
	});
});
</script>

<hr style="margin: 30px 0;">

<!-- EXISTING RECIPES TABLE -->
<h4>📚 Существующие рецепты</h4>
<table class="recipe-table table table-bordered">
	<thead>
		<tr>
			<th>ID</th>
			<th>Изображение</th>
			<th>Название</th>
			<th>Номер</th>
			<th>Стоимость</th>
			<th>Ингредиентов</th>
			<th>Статус</th>
			<th>Турнир</th>
			<th>Действия</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$recipes_query = "SELECT r.*, COUNT(ri.id) as ing_count
						  FROM recipes r
						  LEFT JOIN recipe_ingredients ri ON r.id = ri.recipe_id
						  GROUP BY r.id
						  ORDER BY CAST(r.potion_number AS UNSIGNED), r.potion_number";
		$recipes_result = mysqli_query($conn, $recipes_query);

		while($recipe = mysqli_fetch_assoc($recipes_result)) {
			echo "<tr>";
			echo "<td>" . $recipe['id'] . "</td>";
			echo "<td><img src='" . htmlspecialchars($recipe['image_url']) . "' alt='potion' /></td>";
			echo "<td><b>" . htmlspecialchars($recipe['name']) . "</b></td>";
			echo "<td>" . htmlspecialchars($recipe['potion_number']) . "</td>";
			echo "<td>₽" . number_format($recipe['cost'], 2) . "</td>";
			echo "<td>" . $recipe['ing_count'] . "</td>";
			echo "<td>" . ($recipe['is_active'] ? "<span style='color:green'>✓ Активен</span>" : "<span style='color:red'>✗ Скрыт</span>") . "</td>";
			echo "<td>" . ($recipe['requires_tournament'] ? "<span style='color:orange'>Да</span>" : "Нет") . "</td>";
			echo "<td>";

			// Toggle visibility button
			if($recipe['is_active']) {
				echo "<a href='?toggle_active=" . $recipe['id'] . "' class='btn btn-warning btn-sm action-btn' onclick='return confirm(\"Скрыть этот рецепт?\")'>Скрыть</a> ";
			} else {
				echo "<a href='?toggle_active=" . $recipe['id'] . "' class='btn btn-success btn-sm action-btn' onclick='return confirm(\"Показать этот рецепт?\")'>Показать</a> ";
			}

			// Delete button
			echo "<a href='?delete_recipe=" . $recipe['id'] . "' class='btn btn-danger btn-sm action-btn' onclick='return confirm(\"Удалить рецепт навсегда?\")'>Удалить</a>";

			echo "</td>";
			echo "</tr>";
		}
		?>
	</tbody>
</table>     
                                
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
