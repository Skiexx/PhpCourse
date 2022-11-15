<?php
var_dump(!1); // bool  false
var_dump(!0); // bool true
var_dump(!true); // bool false
var_dump(2 && 3); // bool true
var_dump(5 && 0); // bool false
var_dump(3 || 0); // bool true
var_dump(5 / 1); // int 5
var_dump(1 / 5); // float 0.2
var_dump(5 + '5string'); // PHP Warning and int 10
var_dump('5' == 5); // bool true
var_dump('05' == 5); // bool true
var_dump('05' == '5'); // bool true