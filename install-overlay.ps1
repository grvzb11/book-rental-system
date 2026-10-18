param(
    [Parameter(Mandatory=$true)]
    [string]$LaravelProjectPath
)

$ErrorActionPreference = 'Stop'
$Source = Split-Path -Parent $MyInvocation.MyCommand.Path

if (-not (Test-Path $LaravelProjectPath)) {
    throw "Laravel project path does not exist: $LaravelProjectPath"
}

$folders = @('app', 'database', 'routes', 'resources', 'public')
foreach ($folder in $folders) {
    $src = Join-Path $Source $folder
    $dst = Join-Path $LaravelProjectPath $folder
    Copy-Item -Path (Join-Path $src '*') -Destination $dst -Recurse -Force
}

Write-Host "Book Rental System professional overlay copied successfully." -ForegroundColor Green
Write-Host "Next commands:" -ForegroundColor Cyan
Write-Host "  php artisan migrate"
Write-Host "  php artisan optimize:clear"
Write-Host "  php artisan serve"
