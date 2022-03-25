<?php

function seoTitle(string $title): string
{
  $char  = ['-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']', '{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+', '<', '>', ',', '_'];
  $title = str_replace($char, '', $title);
  $title = strtolower(str_replace([' '], '-', $title));

  return (string) $title;
}