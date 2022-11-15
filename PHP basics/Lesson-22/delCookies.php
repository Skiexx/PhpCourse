<?php

function delCookies(): void {
    setcookie('login', '', time() - 3600, '/');
    setcookie('password', '', time() - 3600, '/');
}

delCookies();
echo 'Cookie удалены';