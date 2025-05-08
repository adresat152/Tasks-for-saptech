
<?php
$conn = new mysqli("localhost", "x95317ww_suptech", "GlobalForvard11_", "x95317ww_suptech");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
$page = isset($_GET['tickets']) ? intval($_GET['tickets']) : 0;; //1-ссылка по-умолчанию
$sql = "SELECT * FROM `tickets` WHERE `ticket_id`=$page";
if($result = $conn->query($sql)){
    $data = mysql_fetch_assoc($result);
    $result->free();
} else{
    echo "Ошибка: " . $conn->error;
};

$query = "SELECT tickets.ticket_client FROM tickets WHERE tickets.ticket_id = $page";

$result = $conn->query($query);

/* fetch object array */
while ($row = $result->fetch_row()) {
    printf("%s (%s)\n", $row[0], $row[1]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тестовое задание для ТехСап</title>
    <link rel="stylesheet" href="css-style-main/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="row">
        <div class="col-4 colomns" id="left">
            <!-- Создал одну сетку внутри рапределил по 12 колонок. На поле ввода (которое будет плавать) 
            и на сами всплывающии окошки из чата-->
            <div class="row">
                <!-- Здесь создал сообщения которые будем генерить -->
                <div class="col-12">
                    <div class="operator-message">
                        <span id="random_name">Имя оператора: @random_name</span>
                        <span class="message">Добрый день! <br> Извините за долгий ответ! ыфвфывфвыф</span>
                    </div>
                    <div class="operator-message">
                        <span id="random_name">Имя оператора: @random_name</span>
                        <span class="message">Добрый день! <br> Извините за долгий ответ! ыфвфывфвыф</span>
                    </div>
                    <div class="user-message">
                        <span id="random_name">Имя пользователя: @username в бд</span>
                        <span class="message">Добрый день! <br> 12312312313212313123</span>
                    </div>
                    <div class="user-message">
                        <span id="random_name">Имя пользователя: @username в бд</span>
                        <span class="message">Добрый день! <br> 12312312313212313123</span>
                    </div>
                    <div class="operator-message">
                        <span id="random_name">Имя оператора: @random_name</span>
                        <span class="message">Добрый день! <br> Извините за долгий ответ! ыфвфывфвыф</span>
                    </div>
                    <!-- Пустой блок для возможности скролла ниже поля с сообещнием -->
                    <div class="empty-block">
                    </div>
                </div>
                <!-- Тут создал кнопки, привязал в низу -->
                <div class="col-12">
                    <div id="input_field">
                        <div class="input-group">
                            <textarea class="form-control" aria-label="С текстовым полем"></textarea>
                        </div>
                        <div class="btn-group" role="group" aria-label="Группа кнопок с вложенным раскрывающимся списком">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Статус: В сети
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Перерыв</a></li>
                                    <li><a class="dropdown-item" href="#">Не в сети</a></li>
                                </ul>
                            </div>
                            <button type="button" class="btn btn-outline-secondary">Макрос</button>
                            <button type="button" class="btn btn-outline-success">Отправить</button>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-4 colomns" id="center">
            <!-- Создал 3 блока для каждой базы данных. -->
            <div class="row">
                <div class="col-12 centerStyle" id="database-user">
                    <h6>database client</h3>
                    <?php
                    $sql = "SELECT * FROM clients WHERE client_id=$page";
                    if($result = $conn->query($sql)){
                        $rowsCount = $result->num_rows; // количество полученных строк
                        foreach($result as $row){
                            echo "<span>client_id: " . $row["client_id"] . "</span><br>";
                            echo "<span>username: " . $row["username"] . "</span><br>";
                            echo "<span>name: " . $row["name"] . "</span><br>";
                            echo "<span>age: " . $row["age"] . "</span><br>";
                            echo "<span>city: " . $row["city"] . "</span>";
                        }
                        $result->free();
                    } else{
                        echo "Ошибка: " . $conn->error;
                    }
                    
                    ?>
                </div>
                <div class="col-12 centerStyle" id="database-order">
                    <h6>database order</h6>
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" class="form-control" placeholder="Привязать заказ к пользователю по ID">
                        <button class="btn btn-outline-secondary" type="button">Привязать</button>
                        <button class="btn btn-outline-secondary" type="button">Отвязать</button>
                    </div>
                    <span>order_client_id: 
                    <?php

                    $sql = "SELECT client_id FROM clients INNER JOIN orders ON  orders.order_client_id = clients.client_id WHERE client_id = 20";
                    if($result = $conn->query($sql)){
                        $rowsCount = $result->num_rows; // количество полученных строк
                        foreach($result as $row){
                            echo $row["client_id"]. ",";
                        }
                        $result->free();
                    } else{
                        echo "Ошибка: " . $conn->error;
                    }
                    $sql = "SELECT * FROM orders WHERE order_id=$page";
                    if($result = $conn->query($sql)){
                        $rowsCount = $result->num_rows; // количество полученных строк
                        foreach($result as $row){
                            echo "<br><span>order_id: " . $row["order_id"] . "</span><br>";
                            echo "<span>price: " . $row["price"] . "</span><br>";
                            echo "<span>place: " . $row["place"] . "</span>";
                        }
                        $result->free();
                    } else{
                        echo "Ошибка: " . $conn->error;
                    }
                    ?>
                    </span>
                </div>
                <div class="col-12 centerStyle" id="database-ticket">
                    <h6>database ticket</h6>
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" class="form-control" placeholder="Привязать тикет к заказу по ID">
                        <button class="btn btn-outline-secondary" type="button">Привязать</button>
                        <button class="btn btn-outline-secondary" type="button">Отвязать</button>
                    </div>
                    <?php
                    $sql = "SELECT * FROM tickets WHERE ticket_id=$page";
                    if($result = $conn->query($sql)){
                        $rowsCount = $result->num_rows; // количество полученных строк
                        $randomNumber = rand(1, 20);
                        foreach($result as $row){
                            echo "<span>ticket_id: " . $row["ticket_id"] . "</span><br>";
                            echo "<span>ticket_client: " . $row["ticket_client"] . "</span><br>";
                            echo "<span>csat: " . $row["csat"] . "</span><br>";
                            echo "<span>date: " . $row["date"] . "</span><br>";
                            echo "<span>client_order_id: " . $row["client_order_id"] . "</span>";
                        }
                        $result->free();
                    } else{
                        echo "Ошибка: " . $conn->error;
                    }
                    
                    ?>
                    <!-- <span>text: не отобр.</span><br> -->
                </div>
            </div>
        </div>
        <div class="col-4 colomns" id="right">
            <div class="row">
                <div class="col-12 leftStyle">
                <h6>Tickets base</h3>
                <?php
                $sql = "SELECT * FROM tickets";
                if($result = $conn->query($sql)){
                    $rowsCount = $result->num_rows; // количество полученных строк
                    foreach($result as $row){
                        echo "<span><a href=\"index.php?tickets=" . $row["ticket_id"]. "\">ticket_id: " . $row["ticket_id"] . "</a> </span>";
                        echo "<span>client_order_id: " . $row["client_order_id"] . "</span><br>";
                    }
                    $result->free();
                } else{
                    echo "Ошибка: " . $conn->error;
                }
                
                ?>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>