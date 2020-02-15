<?php

if (! function_exists('numver_format_short')) {
    // Converts a number into a short version, eg: 1000 -> 1k
    // Based on: http://stackoverflow.com/a/4371114
    function number_format_short( $n, $precision = 1 ) {
        if ($n < 9000) {
            // 0 - 9千
            $n_format = number_format($n, $precision, '.', '');
            $suffix = '';
        } else if ($n < 99990000) {
            // 9千-9999萬
            $n_format = number_format($n / 10000, $precision, '.', '');
            $suffix = '萬';
        } else {
            $n_format = number_format($n / 100000000, $precision, '.', '');
            $suffix = '億';
        }

        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }

        return $n_format . $suffix;
    }
}
