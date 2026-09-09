@ECHO OFF
REM Install_jrobot.bat
REM
CLS

ECHO empty folder 

Goto :EOF



REM Path for calling
set ExePath=e:\wamp64\bin\php\php8.4.5\
REM ECHO ExePath: "%ExePath%"

if exist "%ExePath%php.exe" (
    REM path known (WT)
    ECHO ExePath: "%ExePath%"
) else (
    REM Direct call
    ECHO PHP in path variable
    set ExePath=
)

"%ExePath%php.exe" --version

ECHO ----------------------------------------------
ECHO.

echo --- 


composer require --dev joomla-projects/jrobo
composer require --dev joomla-projects/jrobo



REM jRobo init 
