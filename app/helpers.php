<?php

if (!function_exists('testHelperFunction')) {
    function testHelperFunction()
    {
        return "Hello, World!";
    }
}

if (!function_exists('detectPlatformFromUrl')) {
    function detectPlatformFromUrl($url)
    {
        try {
            $host = parse_url($url, PHP_URL_HOST);

            if (!$host) {
                return 'Website'; // fallback
            }

            $host = str_replace('www.', '', $host); // clean www.

            if (str_contains($host, 'instagram.com')) return 'Instagram';
            if (str_contains($host, 'facebook.com')) return 'Facebook';
            if (str_contains($host, 'linkedin.com')) return 'LinkedIn';
            if (str_contains($host, 'twitter.com')) return 'Twitter';
            if (str_contains($host, 'youtube.com')) return 'YouTube';
            if (str_contains($host, 'tiktok.com')) return 'TikTok';

            return 'Website'; // fallback for unknown
        } catch (\Exception $e) {
            return 'Website';
        }
    }
}
