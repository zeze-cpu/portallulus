<?php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "OPcache reset successfully.<br>";
} else {
    echo "OPcache is not enabled or function not available.<br>";
}

// Clear APCu cache if exists
if (function_exists('apcu_clear_cache')) {
    apcu_clear_cache();
    echo "APCu cache cleared.<br>";
}

echo "Cache clearance complete.";
