<?php

if (!function_exists('convertToNumber')) {
    function convertToNumber($param)
    {
        filter_var($param, FILTER_SANITIZE_NUMBER_INT);
    }
  }