<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из тела запроса
    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);

    Проверяем наличие обязательных полей
    if (!isset($data['selectedCheckboxes']) || empty($data['selectedCheckboxes'])) {
        echo json_encode(['error' => 'Не выбраны чекбоксы']);
        exit;
    }

    // Формируем сообщение для отправки на почту
    $selectedCheckboxes = json_decode($data['selectedCheckboxes']);
    $message = "Выбранные чекбоксы: " . implode(", ", $selectedCheckboxes) . "\n";

    // Добавляем остальные поля из формы
    foreach ($data as $key => $value) {
        if ($key !== 'selectedCheckboxes') {
            $message .= "$key: $value\n";
        }
    }

    // Адрес почты, на который отправляем сообщение
    $to = 'some@yandex.ru';

    // Тема письма
    $subject = 'Заявка с сайта';

    // Дополнительные заголовки
    $headers = 'From: some@yandex.ru' . "\r\n" .
        'Reply-To: some@yandex.ru' . "\r\n" .
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
