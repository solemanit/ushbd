<?php

if (! function_exists('isActiveRoute')) {
    /**
     * Check if current route matches any route pattern in the array.
     *
     * @param array $routes
     * @return bool
     */
    function isActiveRoute(array $routes): bool
    {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }
        return false;
    }
}
