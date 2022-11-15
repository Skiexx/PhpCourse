<?php

function setCookies(int $ttl): void {
    setcookie('login', 'admin', time() + $ttl, '/');
    setcookie('password', 'p@SsW0rd', time() + $ttl, '/');
}

setCookies(20);
echo 'Cookie установлены';