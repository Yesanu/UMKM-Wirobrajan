<?php

// Ensure Vercel environment variables are available to Laravel's env() function.
// Vercel PHP runtime passes env vars via $_SERVER, but Laravel's env() reads from $_ENV/getenv().
foreach ($_SERVER as $key => $value) {
    if (is_string($value) && !isset($_ENV[$key])) {
        $_ENV[$key] = $value;
        putenv("$key=$value");
    }
}

require __DIR__ . '/../public/index.php';