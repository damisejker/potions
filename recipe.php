<?php
/**
 * Dynamic Recipe Handler
 * Replaces all individual recipe files (r1.php, r2.php, etc.)
 * Loads recipe data from database for better maintainability
 */

// Security: Exit if accessed directly
if (!isset($conn) || !isset($login)) {
    die('Direct access not permitted');
}

// Get potion number from GET parameter
$potion_number = isset($_GET['potion']) ? $_GET['potion'] : null;

if ($potion_number === null) {
    // No potion selected, exit gracefully
    return;
}

// Load recipe from database using prepared statement (SQL injection protection)
$stmt = mysqli_prepare($conn, "SELECT * FROM `recipes` WHERE `potion_number` = ? AND `is_active` = 1 LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $potion_number);
mysqli_stmt_execute($stmt);
$recipe_result = mysqli_stmt_get_result($stmt);

if (!$recipe_result || mysqli_num_rows($recipe_result) === 0) {
    echo "<div class='content'><h3>Рецепт не найден</h3></div>";
    return;
}

$recipe = mysqli_fetch_assoc($recipe_result);
mysqli_stmt_close($stmt);

// Load ingredients for this recipe
$stmt = mysqli_prepare($conn, "SELECT `ingredient_name` FROM `recipe_ingredients` WHERE `recipe_id` = ? ORDER BY `sort_order` ASC");
mysqli_stmt_bind_param($stmt, "i", $recipe['id']);
mysqli_stmt_execute($stmt);
$ingredients_result = mysqli_stmt_get_result($stmt);

$ingredients = [];
while ($row = mysqli_fetch_assoc($ingredients_result)) {
    $ingredients[] = $row['ingredient_name'];
}
mysqli_stmt_close($stmt);

// Start output
echo "<div class='content'>";

// Navigation links
echo "<a href='https://magismo.ru/potions' style='color:#e0e0e0'>К списку рецептов</a> | ";
echo "<a href='https://magismo.ru/myroom/depo.php' style='color:#e0e0e0'>Депозитарий</a> | ";
echo "<a href='https://magismo.ru/' style='color:#e0e0e0'>В Магисмо</a>";

// Show ingredient shop link for non-tournament potions
if (!$recipe['requires_tournament']) {
    echo " | <a href='https://magismo.ru/shops/potions/ingredients.html' style='color:#e0e0e0' target='_blank'>Купить ингредиенты</a>";
}

// Recipe title
echo "<h3>" . htmlspecialchars($recipe['name']) . "</h3>";

// Recipe details (collapsible)
echo "<h3>Рецепт <a onclick=expandit('recipe') href='javascript:void(0);' style='text-size:10pt;color:#dbcea4'>[+ Посмотреть]</a></h3>";
echo "<div id='recipe' style='display: none;'>";

// Convert cost from bronze to ⋢gold.silver.bronze format
$total_bronze = (int)$recipe['cost'];
$gold = floor($total_bronze / (80 * 12));
$silver = floor(($total_bronze % (80 * 12)) / 12);
$bronze = $total_bronze % 12;
$cost_display = sprintf("⋢%02d.%02d.%02d", $gold, $silver, $bronze);

echo "<b>Стоимость ингредиентов за зелье:</b> " . $cost_display . "<br><br>";
echo "<b>Ингредиенты:</b><br>";
foreach ($ingredients as $ingredient) {
    echo htmlspecialchars($ingredient) . "<br>";
}

// Show preparation instructions if available
if (!empty($recipe['preparation_text'])) {
    echo "<br><b>Приготовление:</b><br>";
    echo nl2br(htmlspecialchars($recipe['preparation_text'])) . "<br>";
}

// Show ingredient sequence (order)
if (count($ingredients) > 0) {
    echo "<br><b>Последовательность добавления ингредиентов в котел:</b> ";
    echo implode(" => ", array_map('htmlspecialchars', $ingredients));
    echo "<br>";
}

// Show final characteristics if available
if (!empty($recipe['final_characteristics'])) {
    echo "<br><b>Итоговые характеристики зелья:</b> ";
    echo htmlspecialchars($recipe['final_characteristics']);
}

echo "<hr></div>";

// Handle brewing initiation
if (isset($_POST['begin'])) {
    $random = rand(0, 9999);
    $session_id = md5($random);
    $start_time = time();

    // Check if brewing session already exists
    $stmt = mysqli_prepare($conn, "SELECT * FROM `potions` WHERE `login` = ? AND `lekvar` = ?");
    $lekvar = $recipe['potion_key'];
    mysqli_stmt_bind_param($stmt, "ss", $login, $lekvar);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($check_result) === 0) {
        // Create new brewing session
        $stmt_insert = mysqli_prepare($conn, "INSERT INTO `potions` SET `login` = ?, `lekvar` = ?, `sessionid` = ?, `timestart` = ?, `timefinish` = '', `progress` = 1");
        mysqli_stmt_bind_param($stmt_insert, "sssi", $login, $lekvar, $session_id, $start_time);
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_stmt_close($stmt);
}

// Get current brewing session
$stmt = mysqli_prepare($conn, "SELECT * FROM `potions` WHERE `login` = ? AND `lekvar` = ?");
$lekvar = $recipe['potion_key'];
mysqli_stmt_bind_param($stmt, "ss", $login, $lekvar);
mysqli_stmt_execute($stmt);
$session_result = mysqli_stmt_get_result($stmt);
$session = mysqli_fetch_assoc($session_result);
$progress = $session['progress'] ?? 0;
$session_id = $session['sessionid'] ?? '';
mysqli_stmt_close($stmt);

// Count required ingredients
$required_count = count($ingredients);

// Count ingredients in cauldron
$stmt = mysqli_prepare($conn, "SELECT COUNT(DISTINCT `ingredient`) as count FROM `potionkotel` WHERE `login` = ? AND `sessionid` = ?");
mysqli_stmt_bind_param($stmt, "ss", $login, $session_id);
mysqli_stmt_execute($stmt);
$cauldron_result = mysqli_stmt_get_result($stmt);
$cauldron_data = mysqli_fetch_assoc($cauldron_result);
$cauldron_count = $cauldron_data['count'] ?? 0;
mysqli_stmt_close($stmt);

// Check if potion is complete
if ($required_count > 0 && $cauldron_count == $required_count) {
    $gotovo = 1;

    echo "Получилось! Всё готово.<br>";
    echo "<b>Пожалуйста, заберите зелье, кликнув на него.</b>";

    // Special message for tournament potions
    if ($recipe['requires_tournament']) {
        echo "<br>Вы будете переброшены к Турнирной Панели для описания Способа Приготовления и Магических Свойств данного зелья.";
    }

    echo "</div><br>";
    echo "<div id='raysDemoHolder'><div id='rays'></div><center>";
    echo "<a href='?potion=" . urlencode($potion_number) . "&takeaway=grant' id='myLink'>";
    echo "<img class='readypotion float' src='" . htmlspecialchars($recipe['image_url']) . "' height='89'>";
    echo "</a></center></div>";

    // Handle potion collection
    if (isset($_GET['takeaway']) && $_GET['takeaway'] === 'grant') {
        // Verify ingredients are in cauldron
        $stmt = mysqli_prepare($conn, "SELECT * FROM `potionkotel` WHERE `login` = ? AND `sessionid` = ?");
        mysqli_stmt_bind_param($stmt, "ss", $login, $session_id);
        mysqli_stmt_execute($stmt);
        $verify_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($verify_result) > 0) {
            $date = date("Y-m-d", time());

            // Prepare keyword with player name replacement
            $name_parts = explode(" ", $login);
            $first_name = $name_parts[0];
            $keyword = str_replace('{name}', $first_name, $recipe['usage_keyword']);

            $where_to_use = "chat";

            // Add to depositarium (inventory)
            $stmt_insert = mysqli_prepare($conn, "INSERT INTO `depositarium` SET `tid` = 0, `login` = ?, `date_add` = ?, `goodname` = ?, `spent` = ?, `keyword` = ?, `gooddescr` = ?, `picture` = ?, `category` = 'magismo', `usable` = 1, `wheretouse` = ?, `used` = 0, `shop` = 'lab'");
            mysqli_stmt_bind_param($stmt_insert, "sssdssss",
                $login,
                $date,
                $recipe['name'],
                $recipe['cost'],
                $keyword,
                $recipe['description'],
                $recipe['image_url'],
                $where_to_use
            );
            mysqli_stmt_execute($stmt_insert);
            mysqli_stmt_close($stmt_insert);

            // Clean up session
            $stmt_delete1 = mysqli_prepare($conn, "DELETE FROM `potions` WHERE `login` = ? AND `sessionid` = ?");
            mysqli_stmt_bind_param($stmt_delete1, "ss", $login, $session_id);
            mysqli_stmt_execute($stmt_delete1);
            mysqli_stmt_close($stmt_delete1);

            $stmt_delete2 = mysqli_prepare($conn, "DELETE FROM `potionkotel` WHERE `login` = ? AND `sessionid` = ?");
            mysqli_stmt_bind_param($stmt_delete2, "ss", $login, $session_id);
            mysqli_stmt_execute($stmt_delete2);
            mysqli_stmt_close($stmt_delete2);

            // Handle special tournament tracking for potion15
            if ($potion_number == '15') {
                // Tournament tracking handled separately if needed
            }

            // Redirect
            $redirect_url = $recipe['redirect_url'] ?? 'https://magismo.ru/potions/';
            echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='" . htmlspecialchars($redirect_url) . "'; }</script>";
            echo "<div id='mess' style='display:none;color:lightgreen'>Зелье было перемещено в Ваш депозитарий</div>";
        }
        mysqli_stmt_close($stmt);
    }
} else {
    // Potion not complete yet
    $gotovo = 0;

    // If brewing is in progress, show available ingredients
    if ($progress == 1) {
        echo "<h3>Доступные ингредиенты</h3>";

        // Get available ingredients from depositarium
        $stmt = mysqli_prepare($conn, "SELECT DISTINCT `id`, `goodname`, `picture` FROM `depositarium` WHERE `login` = ? AND `used` != 1 AND `goodname` != 'Опрыскиватель' AND `category` IN ('plants', 'fruits', 'liquids', 'stones', 'powder', 'animals') GROUP BY `goodname` ORDER BY `goodname` DESC");
        mysqli_stmt_bind_param($stmt, "s", $login);
        mysqli_stmt_execute($stmt);
        $available_result = mysqli_stmt_get_result($stmt);

        while ($item = mysqli_fetch_assoc($available_result)) {
            $item_name = $item['goodname'];
            $item_picture = $item['picture'];
            $item_id = $item['id'];

            // Check if ingredient is part of recipe
            $is_valid = in_array($item_name, $ingredients, true);

            if ($is_valid) {
                echo "<div id='mess' style='display:none'>Ингредиент добавлен в котёл!</div>";
            } else {
                echo "<div id='mess' style='display:none;color:pink'>Ингредиент не является частью рецепта!</div>";
            }

            echo "<br><div id='puff'></div>";
            echo "<a href='?potion=" . urlencode($potion_number) . "&n=" . urlencode($item_name) . "&t=" . $item_id . "&s=" . urlencode($session_id) . "' id='myLink'>";
            echo "<span style='color:#ffffff'><img src='" . htmlspecialchars($item_picture) . "' height='48'> <b>" . htmlspecialchars($item_name) . "</b></span>";
            echo "</a>";
        }
        mysqli_stmt_close($stmt);
    } else {
        // Show start button
        echo "<form method='post'>";
        echo "<input type='submit' name='begin' value='Начать варку'>";
        echo "</form>";
    }
}

echo "</div>";

// Handle adding ingredient to cauldron
if (isset($_GET['n']) && isset($_GET['t']) && isset($_GET['s']) && $_GET['potion'] == $potion_number) {
    $ingredient_name = $_GET['n'];
    $ingredient_id = intval($_GET['t']);
    $session_id_param = $_GET['s'];

    // Check if ingredient is valid for this recipe
    $is_valid = in_array($ingredient_name, $ingredients, true);

    if ($is_valid) {
        // Mark ingredient as used
        $stmt_update = mysqli_prepare($conn, "UPDATE `depositarium` SET `used` = 1 WHERE `id` = ?");
        mysqli_stmt_bind_param($stmt_update, "i", $ingredient_id);
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);

        // Add to cauldron
        $stmt_insert = mysqli_prepare($conn, "INSERT INTO `potionkotel` SET `login` = ?, `sessionid` = ?, `ingredient` = ?");
        mysqli_stmt_bind_param($stmt_insert, "sss", $login, $session_id_param, $ingredient_name);
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);

        // Handle special tournament tracking for potion15
        if ($potion_number == '15') {
            $time_added = time();
            $stmt_tournament = mysqli_prepare($conn, "INSERT INTO `firsttur` SET `contestant` = ?, `item` = ?, `wordpart` = 'varka', `timeadded` = ?");
            mysqli_stmt_bind_param($stmt_tournament, "ssi", $login, $ingredient_name, $time_added);
            mysqli_stmt_execute($stmt_tournament);
            mysqli_stmt_close($stmt_tournament);
        }
    }

    // Redirect back to recipe page
    echo "<script language='javascript' type='text/javascript'>window.onLoad=poscrolim(); function poscrolim() { location.href='https://magismo.ru/potions/index.php?potion=" . urlencode($potion_number) . "'; }</script>";
}
?>
