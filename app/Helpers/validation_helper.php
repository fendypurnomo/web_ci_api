<?php

function checkUsername(string $username): bool
{
  if (!preg_match('/^[a-z0-9_.]+$/', $username) && !preg_match_all('/[a-z]/', $username) < 5) { return false; }
  return true;
}

function checkPasswordStrength(string $password): bool
{
  $password = trim($password);

  if (!preg_match_all('/[a-z]/', $password)) { return false; }
  if (!preg_match_all('/[A-Z]/', $password)) { return false; }
  if (!preg_match_all('/[0-9]/', $password)) { return false; }
  return true;
}