<?php

/**
 * Get cached results for a query
 */
function getCache($query)
{
    if (!isset($_SESSION['searchCache'])) {
        $_SESSION['searchCache'] = [];
    }

    // Exact match caching
    return $_SESSION['searchCache'][$query] ?? null;
}

/**
 * Set cache for a query
 */
function setCache($query, $results)
{
    if (!isset($_SESSION['searchCache'])) {
        $_SESSION['searchCache'] = [];
    }

    $_SESSION['searchCache'][$query] = $results;
}
