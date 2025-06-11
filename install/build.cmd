@echo off
setlocal

set "PROJECT_ROOT=%~dp0.."
set "FRONTEND_PATH=%PROJECT_ROOT%\frontend"
set "DIST_PATH=%FRONTEND_PATH%\dist"

cd /d "%FRONTEND_PATH%" || exit /b 1

echo.
echo [INFO] Build en cours...
call npm run build || goto :error

xcopy /E /I /Y "%DIST_PATH%\*" "%PROJECT_ROOT%\" >nul

rmdir /S /Q "%DIST_PATH%"

echo.
echo Build terminé avec succès.
exit /b 0

:error
echo.
echo Le build a échoué.
exit /b 1
