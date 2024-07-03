<?php 

use \AmoCRM\AmoAPI;

require_once("vendor/autoload.php"); 

try {
    // Параметры авторизации по протоколу oAuth 2.0
    $clientId     = '04d9ae60-4bf1-40e9-9aef-226147b267b0';
    $clientSecret = 'H0oH7PCDAdOn4etxMwwqcwjqbLzUFgt9hbZE5y53tYR1fh2BHIwr1nLRtIRyTSuN';
    $authCode     = 'def50200903119c1705d50d07928d0e1cda7001b1e92f4f38570c32821c6744a8e7b0106f27b261d8ccad44242721296435accb7968a6d46feee4a2fbfc936007d59daaa9953cfddce67e52c3682c8d00702526e12bd7dcb877f9d0835732acca846f62d90e765d8f198a2bb39c45014c9e0d58371d8437f41eda8b413d03fcda455fc478498ab6faf2baef67e8ae23b314ed147a02ca336d3e51b6565c66d78f468765b1353d99dd666f1e4cebc8bc0d3aeb9a7ff353f0b6eec918a664a60d535d565b468ba6f9c6f1aa73675d7e775a13566a8d982cbf855db200d5f9a1a1ac31dad71cba80de05c7c4f37bb788e102c3eaecdc7116f620e61c8d29e9ccce035f22a6f06c44d4f3927a416f692e992464cc3f5110eb1f8415c16a7cc07024bbec15a524bdfeb8cf7addbd1aaa4ffcfba9a4684824be17ad467fe19c456973a8a75834de97a5a19fef7660b9122eb02b7c599b390f9f307c8fe8a6439c5c45c4dd50c90a0c930f680ba0c85a8a1e4f6c2cbe7d69f3d069ed94ebc10f4f5ce4388777010eb6c4a12b3d0940d5ea37fafd663ff346d7734103a02300fc9a66625fd635b1e8300962c259c8ae430f3fb37911a4c9c3854c04d2fff0a84ee5df955f93a92b6181b9eda1b960c996746fe0d8b616fcb5283770ab813784dea451f847e962a1d1ec5871b73937567909542e7';
    $redirectUri  = 'https://test.sistemnik.online/';
    $subdomain    = 'relocantae';

    // Авторизация
    AmoAPI::oAuth2($subdomain, $clientId, $clientSecret, $redirectUri, $authCode);

    // Получение информации об аккаунте
    print_r(AmoAPI::getAccount());

} catch (\AmoCRM\AmoAPIException $e) {
    printf('Ошибка авторизации (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
} catch (\AmoCRM\TokenStorage\TokenStorageException $e) {
    printf('Ошибка обработки токенов (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}