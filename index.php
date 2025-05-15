
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

// Здесь я ищу по тикету какой тикет мы открыли и вывожу значение ID клиента тикета. Тафтология? Да.
$queryTicketClient = "SELECT tickets.ticket_client FROM tickets WHERE tickets.ticket_id = $page";
$result = $conn->query($queryTicketClient);
$row = $result->fetch_array(MYSQLI_NUM);
$ticketClientID = $row[0];
$result->free();
// Тут я ищу по тикету заказ который привязан к нему
$queryTicketOrderId = "SELECT tickets.ticket_order_id FROM tickets WHERE tickets.ticket_id = $page";
$result = $conn->query($queryTicketOrderId);
$row = $result->fetch_array(MYSQLI_NUM);
$ticketOrderId = $row[0];
$result->free();
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
                    <?php
                    $queryMessages = "SELECT * FROM messages WHERE messages.message_ticket_id = $page";
                    if($result = $conn->query($queryMessages)){
                        $rowsCount = $result->num_rows; // количество полученных строк
                        foreach($result as $row){
                            if($row["message_client_id"] == 0) {
                                echo "<div class=\"operator-message\"><span id=\"random_name\">Имя Оператора: " . $row["message_operator_id"] . "</span></br>";
                                echo "<span class=\"message\">" . $row["message_text"] . "</span></div>";
                            } else {
                                echo "<div class=\"user-message\"><span id=\"random_name\">Имя пользователя: " . $row["message_client_id"] . "</span></br>";
                                echo "<span class=\"message\">" . $row["message_text"] . "</span></div>";
                            };
                        }
                        $result->free();
                    } else{
                        echo "Ошибка: " . $conn->error;
                    }
                    
                    ?>
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
                            <button type="button" class="btn btn-outline-success">Отправить</button>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="col-4 colomns" id="center">
            <!-- Создал 3 блока для каждой базы данных. -->
            <div class="row">
                <div class="col-12 centerStyle" id="database-ticket">
                    <h6>database ticket</h6>
                    <form action="" method="POST">
                        <div class="input-group input-group-sm mb-3">
                            <button aria-label="проверить заказ" class="btn btn-outline-warning" name="check" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">check</button>
                            <input class="form-control" type="text" name="setTickerOrder" placeholder="Привязать тикет к заказу по ID">
                            <button class="btn btn-outline-success" name="replace" type="submit">add</button>
                            <button class="btn btn-outline-danger" name="delete" type="submit">del</button>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['replace'])) {
                        $setTickerOrder = $_POST['setTickerOrder'];
                        $conn->query("UPDATE `tickets` SET `ticket_order_id` = $setTickerOrder WHERE `tickets`.`ticket_id` = $page");
                        echo "<meta http-equiv='refresh' content='0'>";
                    };
                    if (isset($_POST['delete'])) {
                        $conn->query("UPDATE `tickets` SET `ticket_order_id` = 0 WHERE `tickets`.`ticket_id` = $page");
                        echo "<meta http-equiv='refresh' content='0'>";
                    };
                        
                    ?>
                    <?php
                    $sql = "SELECT * FROM tickets WHERE ticket_id=$page";
                    if($result = $conn->query($sql)){
                        $rowsCount = $result->num_rows; // количество полученных строк
                        $randomNumber = rand(1, 20);
                        foreach($result as $row){
                            echo "<span>ticket_id: " . $row["ticket_id"] . "</span><br>";
                            echo "<span>ticket_client: " . $ticketClientID . "</span><br>";
                            echo "<span>csat: " . $row["csat"] . "</span><br>";
                            echo "<span>date: " . $row["date"] . "</span><br>";
                            echo "<span>ticket_order_id: " . $row["ticket_order_id"] . "</span>";
                        }
                        $result->free();
                    } else{
                        echo "Ошибка: " . $conn->error;
                    }
                    
                    ?>
                    <!-- <span>text: не отобр.</span><br> -->
                </div>
                <div class="col-12 centerStyle" id="database-user">
                    <h6>database client</h3>
                    <?php
                    $sql = "SELECT * FROM clients WHERE client_id=$ticketClientID";
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
                    <span>order_client_id: 
                    <?php

                    $sql = "SELECT orders.order_id FROM orders INNER JOIN clients ON  orders.order_client_id = clients.client_id WHERE client_id = $ticketClientID";
                    if($result = $conn->query($sql)){
                        $rowsCount = $result->num_rows; // количество полученных строк
                        foreach($result as $row){
                            echo $row["order_id"]. ",";
                        }
                        $result->free();
                    } else{
                        echo "Ошибка: " . $conn->error;
                    }
                    $sql = "SELECT * FROM orders WHERE order_id=$ticketOrderId";
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
                        echo "<span>ticket_order_id: " . $row["ticket_order_id"] . "</span><br>";
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