<?php
include_once 'PasswordHash.php';
$hasher = new PasswordHash(8, TRUE);
$password = "Test123";
$pass_hash = $hasher->HashPassword($password);
echo "\n".$pass_hash;

if($hasher->CheckPassword($password, $pass_hash))
  echo "\n"."Same password";
else
  echo "\n"."Different!!!";

