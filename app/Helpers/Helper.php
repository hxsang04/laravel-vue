<?php

if (!function_exists('convertToNumber')) {
    function convertToNumber($param)
    {
        return filter_var($param, FILTER_SANITIZE_NUMBER_INT);
    }
  }