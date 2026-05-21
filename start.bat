@echo off
cd /d "%~dp0"

echo Building frontend assets...
call npm run build
if errorlevel 1 (
    echo npm build failed. Make sure Node.js is installed.
    pause
    exit /b 1
)

echo Starting Laravel server at http://127.0.0.1:8000
echo Open that URL in your browser.
php artisan serve
