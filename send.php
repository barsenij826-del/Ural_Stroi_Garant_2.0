<?php
error_reporting(0);
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) die("No data");

$token = "8684787247:AAEWyzBBwvGhaHwVZVosVuRY1IQg1eyglcM";
$chat_id = "760645228";
$text = $data['text'];

// 1. ОТПРАВКА В TELEGRAM
$url = "https://api.telegram.org/bot{$token}/sendMessage";
$params = ['chat_id' => $chat_id, 'text' => $text, 'parse_mode' => 'html'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$tg_result = curl_exec($ch);
curl_close($ch);

// 2. ОТПРАВКА НА ПОЧТУ (РЕЗЕРВ)
$to = "uralsg1@yandex.ru, uralsg1@yandex.ru"; // Твоя почта
$subject = "НОВАЯ ЗАЯВКА С САЙТА";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: info@уралстройгарант.рф" . "\r\n";

$mail_body = "<h3>Поступила новая заявка:</h3><pre>" . strip_tags($text) . "</pre>";
mail($to, $subject, $mail_body, $headers);

echo $tg_result; // Возвращаем ответ от ТГ для сайта
?>
