@echo off
rem PruneArchive.cmd
rem
set MYNAME=%0
rem Prune archive in named folder to N items
rem
if x%1x == xx goto BadArgs
if x%2x == xx goto BadArgs
goto ArgsOK

:BadArgs
echo %MYNAME%: Incorrect arguments in call.
echo Usage: %MYNAME% NumberOfItemsToKeep FolderToProcess
exit /b 1

:ArgsOK
set KeepArchNr=%~1
set Folder=%~2

rem Change to the Folder
rem
rem For each plain file in the folder
rem     make a search pattern where digits are replaced with *
rem     List files that match that pattern, oldest last

pushd "%Folder%"
if not errorlevel 1 goto CDOK
echo %MYNAME%: Unable to change directory to "%Folder%"
popd
exit /b 1

:CDOK
dir /a-d /b *.* > %TEMP%\LTU-files.txt 2>>&1

for %%A in (%TEMP%\LTU-files.txt) do if %%~zA==0 (
    popd
    exit /b 0
)

ls *[0-9]* > %TEMP%\LTU-numhits.txt 2>>&1
if ERRORLEVEL 1 goto DirDisplayed

dir /a-d /b *.* > %TEMP%\LTU-plain-files.txt 2>>&1
rem Now to get the patterns for the plain files in this folder.
type %TEMP%\LTU-plain-files.txt|sed "/^\.Sync/d"|sed -n "/[0-9]/p"|sed -n "s/[\._-]*[0-9][0-9\._-]\{1,999\}/\*/gp"|sort|uniq > %TEMP%\patterns.txt

rem Return if no patterns found
for %%x in (%TEMP%\patterns.txt) do if %%~zx==0 (
    rem echo For patterns, size is %%~z
    rem pause
    popd
    exit /b 0
)

rem for each pattern in %TEMP%\patterns.txt
rem     remove installers older than number %KeepArchNr%
rem
for /F "delims=" %%p in (%TEMP%\patterns.txt) do (
    dir /a-d /b /O-D "%%p" > %TEMP%\LTU-hits.txt 2>>&1
    for /F "skip=%KeepArchNr% delims=" %%h in (%TEMP%\LTU-hits.txt) do (
        echo %%h deleted
        echo     from "%Folder%" . . .
        del "%%h"
    )
)

rem fallthrough

:DirDisplayed
popd
exit /b 0
