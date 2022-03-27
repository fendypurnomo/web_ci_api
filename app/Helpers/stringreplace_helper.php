<?php

function characters(): array
{
  return ['-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']', '{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+', '<', '>', ',', '_'];
}

function charReplace($string): string
{
  $string = str_replace(characters(), '', $string);
  return $string;
}

function seoTitle(string $title): string
{
  $title = charReplace($title);
  $title = strtolower(str_replace([' '], '-', $title));
  return $title;
}

function username(string $username): string
{
  $username = charReplace($username);
  $username = strtolower(str_replace([' '], '', $username));
  return $username;
}