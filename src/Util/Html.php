<?php

namespace Util;

use DateTime;
use DateTimeZone;
use Exception;

//?=== HTML & Formatting Utilities

function e(mixed $val): string {
    return htmlspecialchars((string)($val ?? ''), ENT_QUOTES, 'UTF-8');
}

function formatDate(string $datetime, string $tz = 'Indian/Antananarivo'): string {
    try {
        $dt = new DateTime($datetime, new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone($tz));
        return $dt->format('d/m/Y H:i');
    } catch (Exception) {
        return $datetime;
    }
}
