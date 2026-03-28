<?php
error_reporting(0);
$data = json_decode(file_get_contents('php://input'), true);
if (!$data) die("No data");

// ТВОИ ДАННЫЕ (зашиты внутри сервера)
$token = "8684787247:AAEWyzBBwvGhaHwVZVosVuRY1IQg1eyglcM";
$chat_id = "760645228";
$text = $data['text'];

// 1. ОТПРАВКА В TELEGRAM
$url = "https://api.telegram.org/bot{$token}/sendMessage";
$params = [
    'chat_id' => $chat_id,
    'text' => $text,
    'parse_mode' => 'html'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$tg_result = curl_exec($ch);
curl_close($ch);

// 2. ОТПРАВКА НА ПОЧТУ
$to = "uralsg1@yandex.ru" , "barsenij826@gmail.com"; // Можно добавить через запятую вторую почту
$subject = "🔥 ЗАЯВКА С САЙТА: " . strip_tags($data['subject']);
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: info@уралстройгарант.рф" . "\r\n";

$mail_body = "<h2>Новая заявка</h2><div style='font-size:16px;'>" . str_replace("\n", "<br>", $text) . "</div>";
mail($to, $subject, $mail_body, $headers);

echo $tg_result; 
?>
