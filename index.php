<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <h1>Гра "Екстрасенс"</h1>
        <?php
            $submit = 0; // считаем отправки с помощью переменной $submit
            $win = 0;
            if (isset($_POST["ansvers"])) { // если выбраны варианты ответов создается массив $ansvers в который они записываются
                $ansvers = json_decode($_POST['ansvers']);
            } else {
                $ansvers = [];
            }
            if (isset($_POST["submit"])) { // если были отправки распаковывается количество отправок
                $submit = $_POST["submit"];
            }
        ?>
        <form method="post" action="index.php">
            <p><h2>Комп'ютер згенерував число від 1 до 10.</h2></p>
            <p><h2>Вгадайте це число:</h2></p>
            <?php
            if ($_POST) {
                if (isset($_POST["password"])) { // если был rand распаковываем его в $password и сохраняем
                    $password = $_POST["password"];
                    echo ("<input type='hidden' name='password' value='$password'>");
                    echo ("$password");
                }
                if (isset($_POST["choise"])) { // если выбран вариант ответа записываем его в переменную $choise
                    $choise = $_POST["choise"];
                    $submit++; // при каждой отправке в переменную $submit добавляется +1
                    if ($submit == 1) { // при первой отправке создаем случайное число от 1 до 10 добавляем в переменную $password и сохраняем
                        $password = rand(1,10);
                        echo ("<input type='hidden' name='password' value='$password'>");
                        echo ("$password");
                    }
                    echo ("<h3>Спроба $submit:</h3>"); // выводим количество попыток
                    echo ("<h4 class='displayOfSelected'>Ви вибрали число <span>$choise</span>.</h4>"); // выводим выбранное число
                    array_push($ansvers, $choise); // добавляем выбранные варианты в массив $ansvers
                    if ($choise == $password) { // если выбранный вариант совпал с загаданным числом удаляем все выбранные варианты из массива $ansvers и выводим кнокну Начать сначала
                        $ansvers = []; 
                        $win = 1;
                        echo ("<p><h2>Ви вгадали!</h2></p>");
                        echo ("<p><a class='button' href='index.php'>Почати спочатку</a></p>");
                    } else if ($submit == 3) { // после трех неудачных попыток можно только начать сначала
                        echo ("<p><h4>Ви не вгадали, спроби закінчились. Поразка. :(</h4></p>");
                        echo ("<p><a class='button' href='index.php'>Почати спочатку</a></p>");
                    } else { // при выборе неверного варианта, но когда еще остались попытки можно играть дальше
                        echo ("<p><h4>Ви не вгадали, спробуйте ще:</h4></p>");
                    }
                }
            }
            echo ("<input type='hidden' name='submit' value='$submit'>"); // сохряняем количество отправок
            if ($submit < 3 && $win < 1) { // выводим список вариантов выбора в начале игры, до 3 неудачных попыток или до победы
                echo ("<select name='choise' name='choise' required placeholder=''>");
                    echo ("<option value='' selected disabled>Виберіть число</option>");
                    for ($i = 1; $i <= 10; $i++) { // создаем 10 вариантов выбора
                        echo ("<option ");
                        for ($previous = 0; $previous < count($ansvers); $previous++) { // делаем недоступным для выбора предыдущий выбранный вариант
                            if (isset($_POST["choise"])) {
                                if ($ansvers[$previous] == $i) {
                                    echo ("disabled ");
                                }
                            }
                        }
                        echo ("value='". $i ."'>". $i ."</option>");
                    }
                echo ("</select>");
                echo ("<input type='hidden' name='ansvers' value='" .json_encode($ansvers). "'>"); // сохраняем массив с выбранными вариантами
                echo ("<p><button class='button' type='submit'>Вибрати</button></p>");
            }
            var_dump($_POST);
            ?>
        </form>
    </div>
</body>
</html>