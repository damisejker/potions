-- Seed data for potions recipes
-- This script populates the recipes and recipe_ingredients tables with existing potion data

-- Insert recipes
INSERT INTO `recipes` (`potion_key`, `potion_number`, `name`, `cost`, `image_url`, `usage_keyword`, `description`, `redirect_url`, `requires_tournament`) VALUES
('potion1', '1', 'Противоаллергическое зелье', 0.67, 'https://magismo.ru/potions/images/allergypotion.png', 'выпивает собственно-приготовленное зелье от аллергии. Симптомы, доставляющие дискомфорт рассеиваются. {name} чувствует себя лучше.', 'Зелье против аллергии.', NULL, 0),
('potion2', '2', 'Эликсир бодрости', 2.32, 'https://magismo.ru/potions/images/bodro.png', 'выпивает собственно-приготовленный <b>эликсир бодрости</b>. Тело насыщается огромным потоком позитивной энергии и {name} ощущает как начинает чувствовать себя бодрее и рьянее.', 'Эликсир придающий эффект бодрости.', NULL, 0),
('potion3', '3', 'Бодряще-лечащая настойка', 2.85, 'https://magismo.ru/potions/images/nastojka.png', 'выпивает собственно-приготовленную <b>бодряще-лечащую настойку</b>. Тело излечивается от травм и/или имеющихся ранений. {name} ощущает исцеляющую силу настойки.', 'Помощь в случае травм и ранений.', NULL, 0),
('potion4', '4', 'Тонизирующее зелье', 2.15, 'https://magismo.ru/potions/images/tonikzel.png', 'выпивает собственно-приготовленное <b>тонизирующее зелье</b>. Тело мага наполняется приливом сил и энергии. Усталость отступает. {name} ощущает себя теперь бодро.', 'Зелье придаёт ощущение прилива сил и энергии, устранение усталости. При передозировке возможно усиление самомнения, беспокойство, тонус мышц, невозможность усидеть на месте.', NULL, 0),
('potion5', '5', 'Зелье саламандры', 2.63, 'https://magismo.ru/potions/images/salamanderpotion.png', 'достаёт собственно-приготовленное зелье саламандры', 'Огненное зелье, активируется резким встряхиванием и разбиванием колбочки, при применении сжигает все в пределах радиуса действия. Радиус действия, длительность и температура горения зависит от количества зелья, стандартная доза – 100 мл.', NULL, 0),
('potion6', '6', 'Зелье ночного зрения', 0.24, 'https://magismo.ru/potions/images/nightvision.png', 'достаёт собственно-приготовленное зелье ночного видения и выпивает его', 'Дает способность видеть в темноте (все предметы хорошо различимы, цвета различаются плохо, примерно как в сумерках).', NULL, 0),
('potion7', '7', 'Зелье "Щит ясного сознания"', 0.64, 'https://magismo.ru/potions/images/brightmind.png', 'выпивает собственно-приготовленное зелье "Щит ясного сознания"', 'Защищает сознание от ментальных воздействий – магии подчинения, легилименции, телепатии, чтения мыслей. Приготовить его может любой зельевар среднего уровня, но у ментального мага зелье получится сильнее.', NULL, 0),
('potion8', '8', 'Зелье "Хранитель от нечисти"', 0.36, 'https://magismo.ru/potions/images/evilspiritprotect.png', 'выпивает собственно-приготовленное зелье "Хранитель от нечисти"', 'Будет снято до 80% уже нанесенного нечистью вреда нефизического рода: морок, оцепенение, резкий упадок сил, наведенная тоска и прочее. При принятии зелья до встречи с нечистью, она не сможет причинить никакого вреда. Наступает действие в среднем через 1 минуту после употребления зелья, длится в зависимости от выпитого количества (в глотках): 1 глоток - 30 минут, каждый последующий глоток по 15 минут.', NULL, 0),
('potion9', '9', 'Зелье "Увеличитель силы"', 0.92, 'https://magismo.ru/potions/images/powersam.png', 'выпивает собственно-приготовленное зелье "Увеличитель силы"', 'Увеличивает физические возможности мага. Под действием Увеличителя силы человек становится сильнее, легко может поднимать, передвигать очень тяжелые предметы. Эффект зависит от того, к какой весовой категории относится волшебник (маг весом в 60 кг может поднять предмет до 150 кг, 65 - 200 кг, 70 - 250, 75- 300 кг, 80 и более - до 400 кг.) Действие длится 30 минут (один глоток).', NULL, 0),
('potion10', '10', 'Зелье "Приток сил"', 0.56, 'https://magismo.ru/potions/images/poweracquisition.png', 'выпивает собственно-приготовленное зелье "Приток сил"', 'Восстанавливает магический и физический резервы сил.', NULL, 0),
('potion11', '11', 'Быстрозаживляющая универсальная мазь', 3.48, 'https://magismo.ru/potions/images/healingointment.png', 'достаёт собственно-приготовленную быстрозаживляющую универсальную мазь', 'Мазь для способствования заживлению царапин, рубцов (если им до полугода), ожогов I степени (без волдырей), синяков и ушибов. Начинает действовать через 5 минут, для полного заживления необходимо лечить по схеме: на один-два пальца нанести немного мази, без горки, в два слоя помазать необходимое место, 2 раза в день 4 дня.', NULL, 0),
('potion12', '12', 'Согревающая настойка', 1.46, 'https://magismo.ru/potions/images/warmingup.png', 'выпивает собственно-приготовленную согревающую настойку', 'Обладает согревающим эффектом (полезен в длительных походах). Требуемая дозировка - 1 чайная ложка на один раз = 6 часам действия настойки.', NULL, 0),
('potion13', '13', 'Охлаждающая паста', 1.02, 'https://magismo.ru/potions/images/coolingpaste.png', 'достаёт собственно-приготовленную охлаждающую пасту', 'Паста обладает охлаждающим эффектом, который усиливается в ветреную погоду. Требуемая дозировка - 1 небольшой шарик для приема внутрь (для безопасного охлаждения в жаркую погоду, действует 3 часа) и 1 полоска длиной в фалангу указательного пальца для растирания определенного участка на теле с примерными характеристиками 30х30 (действует 2 часа). Начинает действовать через 5 минут. Хранить в прозрачной мягкой тубе, чтобы удобно было выдавливать. Разрешается хранить в стеклянной баночке с широким горлом и плотно закрытой крышкой. Срок годности 2 года.', NULL, 0),
('potion14', '14', 'Противоядие от самых сильных любовных зелий', 2.23, 'https://magismo.ru/potions/images/antilove.png', 'выпивает собственно-приготовленное противоядие от самых сильных любовных зелий', 'Зелье освобождает от приворота.', NULL, 0),
('potion15', '15', 'Зелье для первого тура турнира ЧВ', 0.02, 'https://magismo.ru/potions/images/lekvarprekmarst.png', 'достаёт собственно-приготовленное <b>зелье для первого тура Турнира Четырёх волшебников</b>. Кажется {name} замышляет шалость...', 'Описание зелья будет выслано в турнирной панели', 'https://magismo.ru/myroom/kmarst.php', 1),
('potion16', '16', 'Зелье ментального восстановления', 3.00, 'https://magismo.ru/potions/images/clearmindpo.png', 'достаёт собственно-приготовленное зелье ментального восстановления и выпивает его', 'Успокоение, ясное и чистое сознание, трезвая оценка себя и ситуации без эмоций, стереотипов, программ. Зелье поможет запустить в организме определенные процессы, помогающие ускорить успокоение и трезвый взгляд на мир. Использовать его можно при помутнении сознания, депрессии, просто при затяжном плохом настроении, при панических атаках, когда очень сильно волнуешься, боишься, то есть присутствует много страха.', NULL, 0),
('kmarst3', 'kmarst3', 'Зелье для третьего тура турнира ЧВ', 0.00, 'https://magismo.ru/potions/images/lekvarprekmarst.png', 'достаёт собственно-приготовленное <b>зелье для третьего тура Турнира Четырёх волшебников</b>. Кажется {name} замышляет шалость...', 'Описание зелья будет выслано в турнирной панели', 'https://magismo.ru/myroom/kmarst.php', 1);

-- Insert recipe ingredients
-- Potion 1: Противоаллергическое зелье
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion1'), 'Бутылёк с очищенной водой', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion1'), 'Лирный корень', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion1'), 'Крапива (сухие листья)', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion1'), 'Полынь (сухие листья)', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion1'), 'Мята (сухие листья)', 5),
((SELECT id FROM recipes WHERE potion_key = 'potion1'), 'Настойка валерианы', 6);

-- Potion 2: Эликсир бодрости
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion2'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion2'), 'Точеный корень женьшеня (сухой)', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion2'), 'Точеный корень родиолы розовой (сухой)', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion2'), 'Смола кедра сибирского (порошок)', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion2'), 'Сушеные листья клубники лесной', 5),
((SELECT id FROM recipes WHERE potion_key = 'potion2'), 'Мята перечная (сушеная)', 6),
((SELECT id FROM recipes WHERE potion_key = 'potion2'), 'Пыльца феи', 7);

-- Potion 3: Бодряще-лечащая настойка
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion3'), 'Бутылёк с очищенной водой', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion3'), 'Сушеная ромашка', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion3'), 'Сушеные цветки гвоздики', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion3'), 'Молоко единорога', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion3'), 'Черная смородина', 5),
((SELECT id FROM recipes WHERE potion_key = 'potion3'), 'Тертый грецкий орех', 6),
((SELECT id FROM recipes WHERE potion_key = 'potion3'), 'Сушеный розмарин', 7);

-- Potion 4: Тонизирующее зелье
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion4'), 'Розовая вода', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion4'), 'Лимонный сок', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion4'), 'Корень червоточника', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion4'), 'Ягоды гуми', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion4'), 'Мята (сухие листья)', 5);

-- Potion 5: Зелье саламандры
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion5'), 'Вода речная', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion5'), 'Чешуя саламандры', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion5'), 'Коготь саламандры', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion5'), 'Перо феникса', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion5'), 'Купальница (сухие листья)', 5);

-- Potion 6: Зелье ночного зрения
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion6'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion6'), 'Перо совы', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion6'), 'Ягоды черники', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion6'), 'Клевер красный', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion6'), 'Слёзы кота', 5);

-- Potion 7: Зелье "Щит ясного сознания"
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion7'), 'Вода речная', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion7'), 'Шалфей (сухие листья)', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion7'), 'Полынь (сухие листья)', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion7'), 'Бегония (сухие листья)', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion7'), 'Коралл белый (мелкий порошок)', 5),
((SELECT id FROM recipes WHERE potion_key = 'potion7'), 'Алоэ древовидное (сок)', 6),
((SELECT id FROM recipes WHERE potion_key = 'potion7'), 'Экстракт имбиря', 7);

-- Potion 8: Зелье "Хранитель от нечисти"
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion8'), 'Бутылёк с очищенной водой', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion8'), 'Зверобой', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion8'), 'Чертополох', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion8'), 'Полынь (сухие листья)', 4);

-- Potion 9: Зелье "Увеличитель силы"
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion9'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion9'), 'Кора дуба', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion9'), 'Кора баобаба', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion9'), 'Сок волшебных яблок', 4);

-- Potion 10: Зелье "Приток сил"
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion10'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion10'), 'Листья чёрной смородины', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion10'), 'Листья земляники', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion10'), 'Листья ежевики', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion10'), 'Мята (сухие листья)', 5),
((SELECT id FROM recipes WHERE potion_key = 'potion10'), 'Малина', 6),
((SELECT id FROM recipes WHERE potion_key = 'potion10'), 'Земляника', 7);

-- Potion 11: Быстрозаживляющая универсальная мазь
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Сок подснежника', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Сок шиповника', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Алоэ древовидное (сок)', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Сок чистотела', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Крапивная настойка', 5),
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Маковая роса', 6),
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Сухая ламинария', 7),
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Шверский мох', 8),
((SELECT id FROM recipes WHERE potion_key = 'potion11'), 'Ягоды облепихи', 9);

-- Potion 12: Согревающая настойка
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion12'), 'Медовая вода', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion12'), 'Сок облепихи', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion12'), 'Корень вьющегося рольда', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion12'), 'Красный перец', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion12'), 'Экстракт имбиря', 5);

-- Potion 13: Охлаждающая паста
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion13'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion13'), 'Миндальное масло', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion13'), 'Мята (сухие листья)', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion13'), 'Листочки щавеля', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion13'), 'Эфирное масло эвкалипта', 5);

-- Potion 14: Противоядие от самых сильных любовных зелий
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion14'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion14'), 'Ягоды бузины', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion14'), 'Цветок визгопёрки', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion14'), 'Волосы вейлы', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion14'), 'Розовый опал', 5);

-- Potion 15: Зелье для первого тура турнира ЧВ
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion15'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion15'), 'Корень лопуха', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion15'), 'Мухомор', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion15'), 'Осиновые листья', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion15'), 'Зверобой', 5),
((SELECT id FROM recipes WHERE potion_key = 'potion15'), 'Зуб дракона', 6);

-- Potion 16: Зелье ментального восстановления
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Розовая вода', 2),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Чертополох', 3),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Алоэ древовидное (сок)', 4),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Ягоды шиповника', 5),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Эфирное масло лаванды', 6),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Кипрей', 7),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Лирный корень', 8),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Душица (сухие листья)', 9),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Зверобой', 10),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Пустырник пятилопастный (сухие листья)', 11),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Лимонный сок', 12),
((SELECT id FROM recipes WHERE potion_key = 'potion16'), 'Руна Манназ', 13);

-- Potion kmarst3: Зелье для третьего тура турнира ЧВ
INSERT INTO `recipe_ingredients` (`recipe_id`, `ingredient_name`, `sort_order`) VALUES
((SELECT id FROM recipes WHERE potion_key = 'kmarst3'), 'Вода родниковая', 1),
((SELECT id FROM recipes WHERE potion_key = 'kmarst3'), 'Корень лопуха', 2),
((SELECT id FROM recipes WHERE potion_key = 'kmarst3'), 'Мухомор', 3),
((SELECT id FROM recipes WHERE potion_key = 'kmarst3'), 'Осиновые листья', 4),
((SELECT id FROM recipes WHERE potion_key = 'kmarst3'), 'Зверобой', 5),
((SELECT id FROM recipes WHERE potion_key = 'kmarst3'), 'Зуб дракона', 6);
