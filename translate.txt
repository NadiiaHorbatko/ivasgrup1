<?php
require 'vendor/autoload.php';

use Google\Cloud\Translate\V2\TranslateClient;

function detectAndTranslate($text, $defaultLanguage = 'en') {
    // Создаем клиента Google Translate
    $translate = new TranslateClient(['key' => '397225048960-t9beqmqp297a1690hulqefboks0knn8g.apps.googleusercontent.com']);

    // Определяем язык исходного текста
    $detection = $translate->detectLanguage($text);
    $sourceLanguage = $detection['languageCode'];

    // Если язык текста совпадает с целевым языком, возвращаем исходный текст
    if ($sourceLanguage === $defaultLanguage) {
        return $text;
    }

    // Переводим текст
    $result = $translate->translate($text, [
        'source' => $sourceLanguage,
        'target' => $defaultLanguage
    ]);

    return $result['text'];
}

// Пример использования функции
$text = "Пример текста для перевода";
$translatedText = detectAndTranslate($text, 'en');
echo "Переведенный текст: " . $translatedText;
?>
