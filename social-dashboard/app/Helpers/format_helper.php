<?php

if (!function_exists('format_number')) {
    function format_number(int|float $number): string
    {
        if ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        }
        if ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }
        return (string) $number;
    }
}

if (!function_exists('format_date')) {
    function format_date($date, string $format = 'M d, Y'): string
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('engagement_color')) {
    function engagement_color(int $score): string
    {
        if ($score > 5000) return 'text-red-600';
        if ($score > 1000) return 'text-orange-500';
        return 'text-gray-600';
    }
}
