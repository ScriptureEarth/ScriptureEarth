#! /usr/bin
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

MYNAME=$0
LTserver=162.217.135.100
SyncFolder=Basis_win
LangTranList=LangTranList.txt
FolderCount=FoldersUpdated.txt
FirstRun=FirstRun.txt
PATHbak=$PATH
PATH=$PWD/Win_main/$SyncFolder/Sync:$PWD/Progs:~/.wine/drive_c/windows/system32
# echo path is now $PATH
echo HOMEPATH is $HOME.
echo and HOMEDRIVE is $HOME.
# if exist $HOME/Documents set Docs=$HOME/Documents
if [ -d $HOME/Documents ]; then Docs=$HOME/Documents
fi

# Make sure the folders FileLists and Diffs exist.
if [ -d ./FileLists ]; then echo "Making sure FileLists directory exists."; else mkdir ./FileLists
fi
if [ -d ./Diffs ]; then echo "Making sure Diffs directory exists."; else mkdir ./Diffs
fi

# Set the default values for variables to control behaviour.
DiffContext=1
PruneDiffs=yes
ShowDifferences=yes
KeepNr=31
KeepArchive=no
ArchiveDir=../LangTranArchive
KeepArchNr=4

# Get the control file, changing the values of some variables.
if [ -a ./Behaviour.sh ]; then source ./Behaviour.sh
fi

# fallthrough for AskRun function:
function NoInitialQ {
echo > Progs/$FirstRun
echo When you want to run this LangTran Update program another time, >> Progs/$FirstRun
echo Double-click the icon on the desktop or in the START menu, >> Progs/$FirstRun
echo "(All Programs then LangTranUpdate group)" >> Progs/$FirstRun
echo called 'Update LangTran into the local folder' >> Progs/$FirstRun
}

# fallthrough / End of script
function End {
	type Progs/$FirstRun
	PATH=$PATHbak
	# echo path is now %PATH%
	if [ $Silent=yes ]; then sleep
	fi
}

function RsyncConnection {
	echo
	echo "Updating folders into the folder:"
	cd
	echo
	FOLDERSUPDATED=0
	echo $FOLDERSUPDATED > Progs/$FolderCount

	echo on
	Win_main/Basis_wi/Sync/dash -c "Progs/RsyncFolder.sh Win_everything_en/$SyncFolder"
	echo off
	# echo back from dash script RsyncFolder.sh, errorlevel is %ERRORLEVEL%
	# Now get the other folders:
	FOLDERSUPDATED=0
	echo $FOLDERSUPDATED > Progs/$FolderCount
}

function NoRsyncConnection {
	echo
	echo "Error: it seems you don't have access to the LangTran server."
	echo
	echo "I'll try to see if I can find it."
	echo "Please note the results of this 'ping' command:"
	ping $LTserver
	echo
	echo "Please check that you are connected to the internet,"
	echo "then run this file"
	echo "("$0")"
	echo "again."
	End
}

function RunBefore {
	# Trying to connect to LangTran server to get a listing of modules.
	#
	# echo
	# echo I am running as the user "$username".
	echo
	echo "Please wait while I check for a connection to the LangTran server . . ."
	rsync $LTserver:: | find "LangTran Rsync Server"

	if ERRORLEVEL 1 goto NoRsyncConnection
	echo "That's what I wanted to see."
	goto RsyncConnection

function AskRun {
    # First thing after installation, when the installer runs this script,
    # give the user an opportunity not to proceed.
    #
    if [ -a ./Progs/$FolderCount ]; then RunBefore
    fi
    echo "I'm running because the software installer started me."
    echo "If you want to do your first update now, type y otherwise type n."
#    Answer=1
    if [ $Silent=yes ]; then NoInitialQ
    fi
#    choice /D y /T 300 /M "Do you want to do the first update now?"
#    Answer=$ERRORLEVEL
	Answer=
	until [ "$Answer" !~ "[nyNY]" ]; do
		echo -n "Do you want to do the first update now? "
		read Answer
		echo ""
		case $Answer in
		    [^nyNY] ) "You didn't type y or n." ;;
		esac
	done
}

AskRun

function BlankLine {
	echo
}

if [ $Answer=2 ]; then BlankLine
fi

# Make a list of the files here before we download any.
./Win_main/$SyncFolder/Sync/date +%%Y%%m%%d_%%H%%M > Progs/FirstTime.txt
set /p FirstTime=<Progs\FirstTime.txt
echo FirstTime is $FirstTime
rm Progs/FirstTime.txt

echo Listing made at $FirstTime > FileLists/LTF_$FirstTime.txt
# echo "@@" markers show line numbers where the files are different.>> FileLists\LTF_%FirstTime%.txt
# echo "-" at start of line shows old version of file, or file removed.>> FileLists\LTF_%FirstTime%.txt
# echo "+" at start of line shows new version of file.>> FileLists\LTF_%FirstTime%.txt
dir /s| sed -e '/\.$/d' -e '/File.s.[ ,0-9]*bytes/d' -e '/Dir.s.[ ,0-9]*bytes free/d' -e 's/$/\r/' >> FileLists/LTF_$FirstTime.txt

# fallthrough

# Now process the folders selected in the control file
#
# for /F "eol=#" %%d in ('type LangTranList.txt') do call Progs\RsyncFolder.cmd %%d
for /F "eol=#" %%d in ('type LangTranList.txt') do Win_main/Basis_win/Sync/dash -c "Progs/RsyncFolder.sh %%d"
echo

function Report {
	echo "I have updated your computer from the LangTran server."
	type Progs/$FolderCount
	echo
	echo off
}

# fallthrough
function NoReport {
	# Make a list of the files here now.
	#
	./Win_main/$SyncFolder/Sync/date +%%Y%%m%%d_%%H%%M > %TEMP%/TimeNow.txt
	set /p TimeNow=<$TEMP/TimeNow.txt
	echo TimeNow is $TimeNow
	rm $TEMP/TimeNow.txt

	echo Listing made at $TimeNow > FileLists\LTF_%TimeNow%.txt
	dir /s| sed -e '/\.$/d' -e '/File.s.[ ,0-9]*bytes/d' -e '/Dir.s.[ ,0-9]*bytes free/d' -e 's/$/\r/' >> FileLists\LTF_$TimeNow.txt

	# Get the newest listing.
	ls -1r FileLists/LTF*.txt | sed -n 1p > $TEMP/NewList.txt
	set /p NewList=<$TEMP/NewList.txt
	# del $TEMP/NewList.txt

	# and the one just before that.
	ls -1r FileLists/LTF*.txt | sed -n 2p > $TEMP/PrevList.txt
	set /p PrevList=<$TEMP/PrevList.txt
	# del $TEMP/PrevList.txt

	# dir Progs/$FolderCount
	if [ -a Progs/$FolderCount ]; then Report
	fi
}
NoReport

# Now to compare the two lists
#
echo "I'm preparing a list of the changes made on this update -- please be patient :-)"
echo "'@@' markers show line numbers where the files are different.">> Diffs/diff_$TimeNow.txt
echo "'-' at start of line shows old version of file, or file removed.">> Diffs/diff_$TimeNow.txt
echo "'+' at start of line shows new version of file.">> Diffs/diff_$TimeNow.txt
echo "Unmarked lines are the context of changes.">> Diffs/diff_$TimeNow.txt

# Check for pruning internal system files from diff file.
#
function DoDiff {
	diff -U %DiffContext% -I "\<DIR\>" %PrevList% %NewList% | sed 's/$/\r/' >> Diffs\diff_%TimeNow%.txt
	if exist Progs\Prev.txt del Progs\Prev.txt
	if exist Progs\NewList.txt del Progs\NewList.txt

	if not %ShowDifferences% == yes goto PruneFileLists
	echo "I'm opening Diffs\diff_%TimeNow%.txt in notepad"
	echo "so you can see the changes that happened this time."
	echo "When you have finished looking through the file,"
	echo "please close notepad, and then I can continue."
	if [ $ShowDifferences=yes ]; then gedit Diffs/diff_$TimeNow.txt
	fi
}
DoDiff

# Remove FileLists files older than the latest KeepNr
function PruneFileLists {
	dir /a-d /b /O-D FileLists > %TEMP%\LTU-lists.txt 2>>&1
	for /F "skip=%KeepNr% delims=" %%f in (%TEMP%\LTU-lists.txt) do (
	    del "FileLists\%%f"
	)

	dir /a-d /b /O-D Diffs > %TEMP%\LTU-diffs.txt 2>>&1
	for /F "skip=%KeepNr% delims=" %%d in (%TEMP%\LTU-diffs.txt) do (
	    del "Diffs\%%d"
	)
}
PruneFileLists

if $PruneDiffs= DoDiff
fi
sed -e "/diff_[_0-9]*\.txt/d" -e "/LTF_[_0-9]*\.txt/d" -e "/FoldersUpdated.txt/d" -e 's/$/\r/' %PrevList% > Progs\Prev.txt
set PrevList=Progs/Prev.txt
sed -e "/diff_[0-9_]*\.txt/d" -e "/LTF_[_0-9]*\.txt/d" -e "/FoldersUpdated.txt/d" -e 's/$/\r/' %NewList% > Progs\NewList.txt
set NewList=Progs/NewList.txt
DoDiff

# fallthrough

function SaveArchive {
	# echo User Documents are in %Docs%
	CYGWIN=nodosfilewarning
}

function CheckForArchiving {
	if [ $KeepArchive=yes ]; then SaveArchive
	fi
	End
}
CheckForArchiving

# Now save the file and close the editor program.

function CopyArchiveNow {
	echo
	echo "Updating your local repository to your continuously-growing archive at"
	echo  $ArchiveDir
	echo
	rsync.exe -bvrLtP --perms --chmod=a=rwx --timeout=300 --partial-dir=.rsync-bit -f "-! */***" -f "- /Diffs/*" -f "- /FileLists/*" ./ "%ArchiveDir%/"
	if [ -a "$ArchiveDir/NewArchive.txt" ]; then rm "$ArchiveDir/NewArchive.txt"
	fi
	echo
}

function ArchiveDirExists {
	if [ "$ArchiveDir/NewArchive.txt" ]; then echo; else CopyArchiveNow
	fi
	echo "Don't panic -- I'm about to copy lots of files from your LangTranLocal folder"
	echo "to your continuously-growing archive:"
	echo  $ArchiveDir
	if $Silent!=yes sleep
	fi
}

if [ -d "$ArchiveDir" ]; then ArchiveDirExists
fi
mkdir "$ArchiveDir"
if [ -d "$ArchiveDir" ]; then echo "Made Archive directory '$ArchiveDir'" > "$ArchiveDir/NewArchive.txt"
fi
if [ -d "$ArchiveDir"]; then ArchiveDirExists
fi
echo "Sorry, I wasn't able to make the folder '$ArchiveDir'."
echo "I can't keep an expanding archive of your LangTran files."
End

# Ideas for pruning the archive
# sed 's/[0-9][0-9\._-]*/*/g' -- pipe to -- uniq -cd
echo "Finished updating your LangTran files to '$ArchiveDir/'"
echo "Now I am going to prune the archive to keep $KeepArchNr versions of each"
echo "installer that has numbered versions."
echo "It can take a while, so please be patient :-) . . ."

# For each folder in the tree of archived files
#   call PruneArchive.cmd with ArchKeepNr and the folder name
# This will prune numbered files to that number of versions.
#
for /F "delims=" %%d in ('dir /ad /b /s "%ArchiveDir%"') do call PruneArchive.cmd "%KeepArchNr%" "%%d"

End
