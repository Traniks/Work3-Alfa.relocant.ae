<?php 

use \AmoCRM\AmoAPI;

require_once("vendor/autoload.php"); 

try {
    // Параметры авторизации по протоколу oAuth 2.0
    $clientId     = '04d9ae60-4bf1-40e9-9aef-226147b267b0';
    $clientSecret = 'yeVysrmvnqaPf4ASW0aVwmbk9ipQY5ddmMFCiJjfGlAoUddBbMbVjtzwCoZ8LPiy';
    $authCode     = 'def502001b5cddbbcf1f7df33b88c98a094dd990e53bb2ef1a4d1eafe184e12d8a814d57cb0c8174613c15e27d1dca3cc4993f6b7ab30e804ecc041c1e88ebecf3dc0e1da0577f3f0ac4a844b3c425de6c86e74714fc1c9cc354777b5e5b60ce13764c6cfdabb03ef0fa42244b73da510645643453d6e0397be37a80d654d14416520a8d0bad7ead8939d054584746f95206e05bdf6859003017b55a45604fedd72ed378d83f92ea3fd6df62a6d7e22b7edaf4a97cb35cb9ada0733a1805601e6eae66e9b50217c6e6701be55193967f9f4043eff63ec3743623079b58c7f660b787bcaa3d3ff66694e933aa8fbdef8f3c913abaa77e3efeab5092bfb0fe75ca37e32992e51820d764e77096ae09e205d69da1288ba9ef515a4bc610d12499bca4259bfedad0f8b009b34fd0d3b479af8fa68f97f10f10e24416f8ac2c5746328475f79302e142804e5aab84de2c584d1d1ecd1cbfe55fcf1fe40b50551dc8f1d461893fc3557842681e1712e5da9f4b6f6d061282ac501df6b5f461bfbb6874d76084cc825f949407b103bc68ef241dadba4c3761de3b70987be6060539d7720f06ea43d2434ecae3d85c6dcd5bf0e82b0f980fd370bba9445ecdf5c2c1fdc8bbe636fc95c87dfefcdef9e362fd00abef3fc111df671e73223fbe8da9d70f2e0702ef6aa0203461343a5e424adaca7b';
    $redirectUri  = 'https://test.sistemnik.online/';
    $subdomain    = 'relocant';

    // Авторизация
    AmoAPI::oAuth2($subdomain, $clientId, $clientSecret, $redirectUri, $authCode);

    // Получение информации об аккаунте
    print_r(AmoAPI::getAccount());

} catch (\AmoCRM\AmoAPIException $e) {
    printf('Ошибка авторизации (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
} catch (\AmoCRM\TokenStorage\TokenStorageException $e) {
    printf('Ошибка обработки токенов (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}