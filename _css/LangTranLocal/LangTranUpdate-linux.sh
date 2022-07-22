#! /usr/bin/env bash
#
# LangTranUpdate-linux.cmd
#
# This is a comment, because it begins with "#".
#
# This script will find the folders you want to update
# from the LangTran system,
# and for each one
#     if there is no folder for that folder
#         it will make it.
#     It will then update that folder from the LangTran server.
#
    echo
    echo "Don't let the black-background window startle you."
    echo "I'm using it to report my progress."
    echo
    echo "This program is part of the LangTran system,"
    echo "and its full path and name is"
    echo $0
    echo
    echo "This program copies the files in the folders that you have selected"
    echo "from the LangTran server onto your computer, in the current folder."
#
set MYNAME=$0
set LTserver=162.217.135.100
set SyncFolder=Basis_win
set LangTranList=LangTranList.txt
set FolderCount=FoldersUpdated.txt
set FirstRun=FirstRun.txt
set PATHbak=%PATH%
set PATH=%cd%\Win_main\%SyncFolder%\Sync;%cd%\Progs;%SystemRoot%\system32
# echo path is now %PATH%
echo HOMEPATH is %HOMEPATH%.
echo and HOMEDRIVE is %HOMEDRIVE%.
if exist "%HOMEDRIVE%%HOMEPATH%\My Documents" set Docs=%HOMEDRIVE%%HOMEPATH%\My Documents
if exist "%HOMEDRIVE%%HOMEPATH%\Documents" set Docs=%HOMEDRIVE%%HOMEPATH%\Documents
echo

# Make sure the folders FileLists and Diffs exist.
if not exist FileLists\. mkdir FileLists
if not exist Diffs\. mkdir Diffs

# Set the default values for variables to control behaviour.
#
set DiffContext=1
set PruneDiffs=yes
set ShowDifferences=yes
set KeepNr=31
set KeepArchive=no
set ArchiveDir=..\LangTranArchive
set KeepArchNr=4

# Get the control file, changing the values of some variables.
if exist .\Behaviour.cmd call .\Behaviour.cmd

AskRun
# First thing after installation, when the installer runs this script,
# give the user an opportunity not to proceed.
#
if exist Progs\%FolderCount% goto RunBefore
echo "I'm running because the software installer started me."
echo "If you want to do your first update now, type y otherwise type n"
set Answer=1
if x%Silent%x==xyesx goto NoInitialQ
choice /D y /T 300 /M "Do you want to do the first update now? "
set Answer=%ERRORLEVEL%

# fallthrough

NoInitialQ

echo > Progs\%FirstRun%
echo When you want to run this LangTran Update program another time, >> Progs\%FirstRun%
echo Double-click the icon on the desktop or in the START menu, >> Progs\%FirstRun%
echo (All Programs then LangTranUpdate group) >> Progs\%FirstRun%
echo called 'Update LangTran into the local folder' >> Progs\%FirstRun%

if %Answer%==2 goto BlankLine

# Make a list of the files here before we download any.
.\Win_main\%SyncFolder%\Sync\date +%%Y%%m%%d_%%H%%M > Progs\FirstTime.txt
set /p FirstTime=<Progs\FirstTime.txt
echo FirstTime is %FirstTime%
del Progs\FirstTime.txt

echo Listing made at %FirstTime% > FileLists\LTF_%FirstTime%.txt
# echo "@@" markers show line numbers where the files are different.>> FileLists\LTF_%FirstTime%.txt
# echo "-" at start of line shows old version of file, or file removed.>> FileLists\LTF_%FirstTime%.txt
# echo "+" at start of line shows new version of file.>> FileLists\LTF_%FirstTime%.txt
dir /s| sed -e '/\.$/d' -e '/File.s.[ ,0-9]*bytes/d' -e '/Dir.s.[ ,0-9]*bytes free/d' -e 's/$/\r/' >> FileLists\LTF_%FirstTime%.txt

# fallthrough

:RunBefore

# Trying to connect to LangTran server to get a listing of modules.
#
# echo.
# echo I am running as the user "%username%".
echo.
echo Please wait while I check for a connection to the LangTran server . . .
rsync %LTserver%:: | find "LangTran Rsync Server"

if ERRORLEVEL 1 goto NoRsyncConnection
echo That's what I wanted to see.
goto RsyncConnection

:NoRsyncConnection
echo.
echo Error: it seems you don't have access to the LangTran server.
echo.
echo I'll try to see if I can find it.
echo Please note the results of this "ping" command:
ping %LTserver%
echo.
echo Please check that you are connected to the internet,
echo then run this file
echo (%0)
echo again.
goto end

:RsyncConnection
echo.
echo Updating folders into the folder:
cd
echo.
set FOLDERSUPDATED=0
echo %FOLDERSUPDATED% > Progs\%FolderCount%

@echo on
Win_main\Basis_win\Sync\dash -c "Progs/RsyncFolder.sh Win_everything_en/%SyncFolder%"
@echo off
# echo back from dash script RsyncFolder.sh, errorlevel is %ERRORLEVEL%
# Now get the other folders:
set FOLDERSUPDATED=0
echo %FOLDERSUPDATED% > Progs\%FolderCount%

# Now process the folders selected in the control file
#
# for /F "eol=#" %%d in ('type LangTranList.txt') do call Progs\RsyncFolder.cmd %%d
for /F "eol=#" %%d in ('type LangTranList.txt') do Win_main\Basis_win\Sync\dash -c "Progs/RsyncFolder.sh %%d"
echo.

# dir Progs\%FolderCount%
if exist Progs\%FolderCount% goto Report
goto NoReport

:Report
echo I have updated your computer from the LangTran server.
type Progs\%FolderCount%
echo.
@echo off
# fallthrough
:NoReport

# Make a list of the files here now.
#
.\Win_main\%SyncFolder%\Sync\date +%%Y%%m%%d_%%H%%M > %TEMP%\TimeNow.txt
set /p TimeNow=<%TEMP%\TimeNow.txt
echo TimeNow is %TimeNow%
del %TEMP%\TimeNow.txt

echo Listing made at %TimeNow% > FileLists\LTF_%TimeNow%.txt
dir /s| sed -e '/\.$/d' -e '/File.s.[ ,0-9]*bytes/d' -e '/Dir.s.[ ,0-9]*bytes free/d' -e 's/$/\r/' >> FileLists\LTF_%TimeNow%.txt

# Get the newest listing.
ls -1r FileLists/LTF*.txt | sed -n 1p > %TEMP%\NewList.txt
set /p NewList=<%TEMP%\NewList.txt
# del %TEMP%\NewList.txt

# and the one just before that.
ls -1r FileLists/LTF*.txt | sed -n 2p > %TEMP%\PrevList.txt
set /p PrevList=<%TEMP%\PrevList.txt
# del %TEMP%\PrevList.txt

# Now to compare the two lists
#
echo I'm preparing a list of the changes made on this update -- please be patient :-)
echo "@@" markers show line numbers where the files are different.>> Diffs\diff_%TimeNow%.txt
echo "-" at start of line shows old version of file, or file removed.>> Diffs\diff_%TimeNow%.txt
echo "+" at start of line shows new version of file.>> Diffs\diff_%TimeNow%.txt
echo Unmarked lines are the context of changes.>> Diffs\diff_%TimeNow%.txt

# Check for pruning internal system files from diff file.
#
if x%PruneDiffs%x==xx goto DoDiff
sed -e "/diff_[_0-9]*\.txt/d" -e "/LTF_[_0-9]*\.txt/d" -e "/FoldersUpdated.txt/d" -e 's/$/\r/' %PrevList% > Progs\Prev.txt
set PrevList=Progs/Prev.txt
sed -e "/diff_[0-9_]*\.txt/d" -e "/LTF_[_0-9]*\.txt/d" -e "/FoldersUpdated.txt/d" -e 's/$/\r/' %NewList% > Progs\NewList.txt
set NewList=Progs/NewList.txt
goto DoDiff

:DoDiff
diff -U %DiffContext% -I "\<DIR\>" %PrevList% %NewList% | sed 's/$/\r/' >> Diffs\diff_%TimeNow%.txt
if exist Progs\Prev.txt del Progs\Prev.txt
if exist Progs\NewList.txt del Progs\NewList.txt

if not %ShowDifferences% == yes goto PruneFileLists
echo I'm opening Diffs\diff_%TimeNow%.txt in notepad
echo so you can see the changes that happened this time.
echo When you have finished looking through the file,
echo please close notepad, and then I can continue.
if %ShowDifferences% == yes notepad Diffs\diff_%TimeNow%.txt

# Remove FileLists files older than the latest KeepNr
:PruneFileLists
dir /a-d /b /O-D FileLists > %TEMP%\LTU-lists.txt 2>>&1
for /F "skip=%KeepNr% delims=" %%f in (%TEMP%\LTU-lists.txt) do (
    del "FileLists\%%f"
)

dir /a-d /b /O-D Diffs > %TEMP%\LTU-diffs.txt 2>>&1
for /F "skip=%KeepNr% delims=" %%d in (%TEMP%\LTU-diffs.txt) do (
    del "Diffs\%%d"
)

# fallthrough

:CheckForArchiving
if %KeepArchive% == yes goto SaveArchive
goto end

:SaveArchive
# echo User Documents are in %Docs%
set CYGWIN=nodosfilewarning

# Now save the file and close the editor program.

if exist "%ArchiveDir%" goto ArchiveDirExists
mkdir "%ArchiveDir%"
if exist "%ArchiveDir%" echo Made Archive directory "%ArchiveDir%" > "%ArchiveDir%\NewArchive.txt"
if exist "%ArchiveDir%" goto ArchiveDirExists
echo Sorry, I wasn't able to make the folder "%ArchiveDir%".
echo I can't keep an expanding archive of your LangTran files.
goto end

:ArchiveDirExists

if not exist "%ArchiveDir%\NewArchive.txt" goto CopyArchiveNow
 echo Don't panic -- I'm about to copy lots of files from your LangTranLocal folder
 echo to your continuously-growing archive:
echo  %ArchiveDir%
if not x%Silent%x==xyesx pause

:CopyArchiveNow
echo.
echo Updating your local repository to your continuously-growing archive at
echo  %ArchiveDir%
echo.
rsync.exe -bvrLtP --perms --chmod=a=rwx --timeout=300 --partial-dir=.rsync-bit -f "-! */***" -f "- /Diffs/*" -f "- /FileLists/*" ./ "%ArchiveDir%/"
if exist "%ArchiveDir%\NewArchive.txt" del "%ArchiveDir%\NewArchive.txt"
echo.
# Ideas for pruning the archive
# sed 's/[0-9][0-9\._-]*/*/g' -- pipe to -- uniq -cd
echo Finished updating your LangTran files to "%ArchiveDir%/"
echo Now I am going to prune the archive to keep %KeepArchNr% versions of each
echo installer that has numbered versions.
echo It can take a while, so please be patient :-) . . .

# For each folder in the tree of archived files
#   call PruneArchive.cmd with ArchKeepNr and the folder name
# This will prune numbered files to that number of versions.
#
for /F "delims=" %%d in ('dir /ad /b /s "%ArchiveDir%"') do call PruneArchive.cmd "%KeepArchNr%" "%%d"

goto end

:BlankLine
echo.

# fallthrough
:end
type Progs\%FirstRun%
set PATH=%PATHbak%
# echo path is now %PATH%
if not x%Silent%x==xyesx pause
