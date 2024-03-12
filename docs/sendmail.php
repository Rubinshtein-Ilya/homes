<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из тела запроса
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    // Проверяем наличие обязательных полей
    if (!isset($data['name']) || !isset($data['phone'])) {
        echo json_encode(['error' => 'Не указаны обязательные поля']);
        exit;
    }

    // Формируем сообщение для отправки на почту
    $name = $data['name'];
    $phone = $data['phone'];
    $message = "Имя: $name\nТелефон: $phone";

    // Адрес почты, на который отправляем сообщение
    $to = 'fahraziev-ilgiz@yandex.ru';

    // Тема письма
    $subject = 'Заявка с сайта';

    // Дополнительные заголовки
    $headers = 'From: fahraziev-ilgiz@yandex.ru' . "\r\n" .
        'Reply-To: fahraziev-ilgiz@yandex.ru' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Отправляем сообщение на почту
    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Ошибка при отправке сообщения']);
    }
} else {
    echo json_encode(['error' => 'Метод запроса должен быть POST']);
}
?>
