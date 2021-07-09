<?php
  function randomstring($n)
  {
      $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $str = '';
      for ($i = 0; $i < $n; $i++) {
          $index = rand(0, strlen($char) - 1);
          $str .= $char[$index];
      }
      return $str;
  }
