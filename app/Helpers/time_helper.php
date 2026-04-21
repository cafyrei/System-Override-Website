<?php

function time_ago($datetime)
{
    $createdAt = new DateTime($datetime);
    $now = new DateTime();

    $interval = $now->diff($createdAt);

    if ($interval->y > 0) {
        return $interval->y . ' year' . ($interval->y > 1 ? 's' : '');
    }
    if ($interval->m > 0) {
        return $interval->m . ' month' . ($interval->m > 1 ? 's' : '');
    }
    if ($interval->d > 0) {
        return $interval->d . ' day' . ($interval->d > 1 ? 's' : '');
    }
    if ($interval->h > 0) {
        return $interval->h . ' hour' . ($interval->h > 1 ? 's' : '');
    }
    if ($interval->i > 0) {
        return $interval->i . ' minute' . ($interval->i > 1 ? 's' : '');
    }

    return 'just now';
}