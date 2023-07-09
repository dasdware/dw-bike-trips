@echo off

echo --------------------------------------
echo  dasd.ware Bike Trips release builder
echo --------------------------------------

if [%1]==[] goto usage

set RELEASE_VERSION=%1
echo Building release version %RELEASE_VERSION%.
echo Release folder: release\%RELEASE_VERSION%

if not exist release mkdir release

if exist release\%RELEASE_VERSION% rmdir /s /q release\%RELEASE_VERSION%
mkdir release\%RELEASE_VERSION%

cd client
echo Building client for Android...
echo   - Creating APK...
@REM flutter build apk

echo   - Copying APK to release folder...
copy build\app\outputs\flutter-apk\app-release.apk ..\release\%RELEASE_VERSION%\dw-bike-trips-client-%RELEASE_VERSION%.android.apk >NUL

echo Building client for Windows...
echo   - Creating application...
rem flutter build windows

echo   - Copying APK to release folder...
7z a ..\release\%RELEASE_VERSION%\dw-bike-trips-client-%RELEASE_VERSION%.windows.zip .\build\windows\runner\Release\*


cd ..\api
7z a ..\release\%RELEASE_VERSION%\dw-bike-trips-api-%RELEASE_VERSION%.zip migrations src vendor .htaccess config.sample.php database.sql index.php 

goto :eof

:usage
echo Usage: %0 ^<release name^>
exit /B 1