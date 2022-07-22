#!/usr/bin
#
# LangTranUpdate-linux.sh
#
# This is a comment, because it begins with "#".
#
# This script will find the folders you want to update
# from the LangTran system,
# and for each one
#     if there is no folder for that folder
#         it will make it.
#     It will then update that folder from the LangTran server.

echo
echo "Don't let the black-background window startle you."
echo "I'm using it to report my progress."
echo
echo "This program is part of the LangTran system,"
echo "and its full path and the script name here is"
echo $0
echo
echo "This program copies the files in the folders that you have selected"
echo "from the LangTran server onto your computer, in the current folder."

MYNAME="$0"
LTserver="162.217.135.100"
SyncFolder="Basis_win"
LangTranList="LangTranList.txt"
FolderCount="FoldersUpdated.txt"
FirstRun="FirstRun.txt"
#PATHbak="$PATH"
#PATH=$PWD/Win_main/$SyncFolder/Sync:$PWD/Progs:~/.wine/drive_c/windows/system32
echo "HOMEPATH is $HOME"
echo "and HOMEDRIVE is $HOME"

[ -d "$HOME/Documents" ] && Docs="$HOME/Documents"

# Make sure the folders FileLists and Diffs exist.
[ -d "./FileLists" ] && echo "Making sure FileLists directory exists." || $(mkdir "./FileLists")
[ -d "./Diffs" ] && echo "Making sure Diffs directory exists." || $(mkdir "./Diffs")

# Set the default values for variables to control behaviour.
DiffContext=1
PruneDiffs="yes"
ShowDifferences="yes"
KeepNr=31
KeepArchive="no"
ArchiveDir="../LangTranArchive"
KeepArchNr=4

# Get the control file, changing the values of some variables.
[ -f "./Behaviour.sh" ] && $(source "./Behaviour.sh")

# First thing after installation, when the installer runs this script,
# give the user an opportunity not to proceed.
#
if [ ! -f "./Progs/$FolderCount" ]; then
	echo "I'm running because the software installer started me."
	echo "If you want to do your first update now, type y otherwise type n."
	#    Answer=1
	if [ "$Silent" != "yes" ]; then
	#    choice /D y /T 300 /M "Do you want to do the first update now?"
	#    Answer=$ERRORLEVEL
		Answer=
		until [ "$Answer" !~ "[nyNY]" ]; do
			echo -n "Do you want to do the first update now? "
			read Answer
			echo ""
			case "$Answer" in
				"[^nyNY]" ) "You didn't type y or n." ;;
			esac
		done
	fi

	echo > "Progs/$FirstRun"
	echo "When you want to run this LangTran Update program another time," >> "Progs/$FirstRun"
	echo "Double-click the icon on the desktop or in the START menu," >> "Progs/$FirstRun"
	echo "(All Programs then LangTranUpdate group)" >> "Progs/$FirstRun"
	echo "called 'Update LangTran into the local folder'" >> "Progs/$FirstRun"

	if [ "$Answer" !~ "[nN]" ]; then
		# Make a list of the files here before we download any.
		#$(date +"%Y%m%d_%H%M") > Progs/FirstTime.txt
		# set /p reads the first line of Progs/FirstTime.txt and sets it to FirstTime. Note: It is important not to add a space before or even after "=" !
		#set /p FirstTime=<Progs/FirstTime.txt
		#$(read -r FirstTime < Progs/FirstTime.txt)
		FirstTime = $(date +"%Y%m%d_%H%M")
		echo "FirstTime is $FirstTime"
		#$(rm Progs/FirstTime.txt)

		echo "Listing made at $FirstTime > FileLists/LTF_$FirstTime.txt"
		# echo "@@" markers show line numbers where the files are different.>> FileLists\LTF_$FirstTime.txt
		# echo "-" at start of line shows old version of file, or file removed.>> FileLists\LTF_$FirstTime.txt
		# echo "+" at start of line shows new version of file.>> FileLists\LTF_$FirstTime.txt
		$(ls -R | sed -e '/\.$/d' -e '/File.s.[ ,0-9]*bytes/d' -e '/Dir.s.[ ,0-9]*bytes free/d' -e 's/$/\r/') >> "FileLists\LTF_$FirstTime.txt"
	fi
fi

if [ "$Answer" !~ "[nN]" ]; then
	# Trying to connect to LangTran server to get a listing of modules.
	#
	# echo
	# echo I am running as the user "$username".
	echo
	echo "Please wait while I check for a connection to the LangTran server . . ."
####$(rsync $LTserver:: | find "LangTran Rsync Server")
$(read -n1 -r -p "rsync $LTserver:: | find LangTran Rsync Server: Press any key to end this script...")
	# $? equals Check the exit status
	if [ "$?" == "0" ]; then	
		echo "That's what I wanted to see."
	else
		echo
		echo "Error: it seems you don't have access to the LangTran server."
		echo
		echo "I'll try to see if I can find it."
		echo "Please note the results of this 'ping' command:"
		$(ping $LTserver)
		echo
		echo "Please check that you are connected to the internet,"
		echo "then run this file"
		echo $0
		echo "again."
		$(cat "Progs/$FirstRun")
		#PATH=$PATHbak
		[ "$Silent" != "yes" ] && $(read -n1 -r -p "Press any key to end this script...")
		exit 0
	fi
fi

echo
echo "Updating folders into the folder: $PDW"
echo
FOLDERSUPDATED=0
echo "$FOLDERSUPDATED > Progs/$FolderCount"

#@echo on
#$(dash -c "Progs/RsyncFolder.sh Win_everything_en/$SyncFolder")
#@echo off
################$(source "Progs/RsyncFolder.sh Win_everything_en/$SyncFolder")
##############################################################################
$(read -n1 -r -p "source Progs/RsyncFolder.sh Win_everything_en/SyncFolder: Press any key to end this script...")
# echo back from dash script RsyncFolder.sh, errorlevel is %ERRORLEVEL%
# Now get the other folders:
FOLDERSUPDATED=0
echo "$FOLDERSUPDATED > Progs/$FolderCount"

# Now process the folders selected in the control file
#
# for /F "eol=#" %%d in ('cat LangTranList.txt') do call Progs/RsyncFolder.sh %%d
#for /F "eol=#" %%d in ('cat LangTranList.txt') do $(dash -c "Progs/RsyncFolder.sh %%d")
IFS="#"
##################################for count in $(cat "LangTranList.txt")
##################################do
##################################$(source "Progs/RsyncFolder.sh $count")
	$(read -n1 -r -p "source Progs/RsyncFolder.sh count: Press any key to end this script...")
##################################done
unset IFS
echo

# ls Progs/$FolderCount
if [ -f "Progs/$FolderCount" ]; then
	echo "Updated this computer from the LangTran server."
	$(cat "Progs/$FolderCount")
	echo
fi

# Make a list of the files here now.
#
#$(date +"%Y%m%d_%H%M") > "$TEMP/TimeNow.txt"
# set /p reads the first line of Progs/FirstTime.txt and sets it to FirstTime. Note: It is important not to add a space before or even after "=" !
#set /p TimeNow= < "$TEMP/TimeNow.txt"
TimeNow = $(date +"%Y%m%d_%H%M")
echo "TimeNow is $TimeNow"
#$(rm "$TEMP/TimeNow.txt")

echo "Listing made at $TimeNow > FileLists/LTF_$TimeNow.txt"
$(ls -R | sed -e '/\.$/d' -e '/File.s.[ ,0-9]*bytes/d' -e '/Dir.s.[ ,0-9]*bytes free/d' -e 's/$/\r/') >> "FileLists/LTF_$TimeNow.txt"

# Get the newest listing.
#$(ls -1r FileLists/LTF*.txt | sed -n 1p) > "$TEMP/NewList.txt"
#set /p NewList=<"$TEMP/NewList.txt"
# The first line of text file
NewList=$(ls -1r "FileLists/LTF*.txt" | sed -n 1p)
# $(rm $TEMP/NewList.txt)

# and the one just before that.
#$(ls -1r FileLists/LTF*.txt | sed -n 2p) > "$TEMP/PrevList.txt"
#set /p PrevList=<"$TEMP/PrevList.txt"
# The second line of the text file
PrevList=$(ls -1r "FileLists/LTF*.txt" | sed -n 2p)
# $(rm $TEMP/PrevList.txt)

# Now to compare the two lists
#
echo "Preparing a list of the changes made on this update, so please be patient . . ."
echo "'@@' markers show line numbers where the files are different." >> "Diffs/diff_$TimeNow.txt"
echo "'-' at start of line shows old version of file, or file removed." >> "Diff/diff_$TimeNow.txt"
echo "'+' at start of line shows new version of file." >> "Diffs/diff_$TimeNow.txt"
echo "Unmarked lines are the context of changes." >> "Diffs/diff_$TimeNow.txt"

# Check for pruning internal system files from diff file.
#
if [ "$PruneDiffs" != "" ]; then
	#$(sed -e "/diff_[_0-9]*\.txt/d" -e "/LTF_[_0-9]*\.txt/d" -e "/FoldersUpdated.txt/d" -e 's/$/\r/' "$PrevList") > "Progs/Prev.txt"
	#PrevList="Progs/Prev.txt"
	PrevList=$(sed -e "/diff_[_0-9]*\.txt/d" -e "/LTF_[_0-9]*\.txt/d" -e "/FoldersUpdated.txt/d" -e 's/$/\r/' "$PrevList")
	#$(sed -e "/diff_[0-9_]*\.txt/d" -e "/LTF_[_0-9]*\.txt/d" -e "/FoldersUpdated.txt/d" -e 's/$/\r/' "$NewList") > "Progs/NewList.txt"
	#NewList="Progs/NewList.txt"
	NewList=$(sed -e "/diff_[0-9_]*\.txt/d" -e "/LTF_[_0-9]*\.txt/d" -e "/FoldersUpdated.txt/d" -e 's/$/\r/' "$NewList")
fi

#$(diff -U $DiffContext -I "\<DIR\>" $PrevList $NewList | sed 's/$/\r/') >> "Diffs/diff_$TimeNow.txt"
$(diff -U $DiffContext $PrevList $NewList | sed 's/$/\r/') >> "Diffs/diff_$TimeNow.txt"

#[ -f "Progs/Prev.txt" ] && $(rm Progs/Prev.txt)
#[ -f "Progs/NewList.txt" ] && $(rm Progs/NewList.txt)

if [ "$ShowDifferences" == "yes" ]; then
	echo "Opening Diffs/diff_$TimeNow.txt in gedit"
	echo "so you can see the changes that happened this time."
	echo "When you have finished looking through the file,"
	echo "please close gedit, and then I will continue with this script."
	$(gedit "Diffs/diff_$TimeNow.txt")
fi

# Remove FileLists files older than the latest KeepNr
#$(dir /a-d /b /O-D FileLists/*) > "$TEMP/LTU-lists.txt" 2 >> &1
#$(cd FileLists)
#$(find -maxdepth 1 -type f -exec ls -l {} \; | sort -nk5) > "$TEMP/LTU-lists.txt" 2 >> &1
#$(cd ..)
#$(ls -l FileLists/* | grep ^- | sort -nk5) > "$TEMP/LTU-lists.txt" 2 >> &1
#for /F "skip=$KeepNr delims=" FName in ("$TEMP/LTU-lists.txt")
for FName in ($(sed $KeepNr,$ ls -ptr "FileLists/*" | grep -v /))
do
    $(rm "FileLists/$FName")
done

#dir /a-d /b /O-D Diffs > "$TEMP/LTU-diffs.txt" 2 >> &1
#$(cd Diffs)
#$(find -maxdepth 1 -type f -exec ls -l {} \; | sort -nk5) > "$TEMP/LTU-diffs.txt" 2 >> &1
#$(cd ..)
#$(ls -l Diffs/* | grep ^- | sort -nk5) > "$TEMP/LTU-diffs.txt" 2 >> &1
#for /F "skip=$KeepNr delims=" FName in ("$TEMP/LTU-diffs.txt")
for FName in ($(sed $KeepNr,$ ls -ptr "Diffs/*" | grep -v /))
do
    $(rm "Diffs/$FName")
done

if [ "$KeepArchive" == "yes" ]; then
	# echo User Documents are in $Docs
#	CYGWIN="nodosfilewarning"

	# Now save the file and close the editor program.
	if [ ! $(mkdir "$ArchiveDir") ]; then
		echo "Sorry. Wasn't able to make the $ArchiveDir folder."
		echo "Can't keep the expanding archive folders with LangTran files."
	else
		echo "Created Archive directory $ArchiveDir > $ArchiveDir/NewArchive.txt"
		if [ -f "$ArchiveDir/NewArchive.txt" ]; then
			echo "Copying lots of files from the LangTranLocal folder"
			echo "to the continuously-growing archive:"
			echo "$ArchiveDir"
			[ "$Silent" != "yes" ] && $(read -n1 -r -p "Press any key to continue...")
		fi

		echo
		echo "Updating local repository to continuously-growing archive at"
		echo "$ArchiveDir"
		echo

########$(rsync -bvrLtP --perms --chmod=a=rwx --timeout=300 --partial-dir=.rsync-bit -f "-! */***" -f "- /Diffs/*" -f "- /FileLists/*" ./ "$ArchiveDir/")
$(read -n1 -r -p "(rsync -bvrLtP --perms --chmod=a=rwx --timeout=300 --partial-dir=.rsync-bit -f...: Press any key to continue...")
		[ -f "$ArchiveDir/NewArchive.txt" ] && $(rm "$ArchiveDir/NewArchive.txt")
		echo
		
		# Ideas for pruning the archive
		# sed 's/[0-9][0-9\._-]*/*/g' -- pipe to -- uniq -cd
		echo "Finished updating LangTran files to $ArchiveDir."
		echo "Going to prune the archive to keep $KeepArchNr versions of each"
		echo "installer that has numbered versions."
		echo "It can take a while, so please be patient . . ."

		# For each folder in the tree of archived files
		#   call PruneArchive.cmd with ArchKeepNr and the folder name
		# This will prune numbered files to that number of versions.
		#
		#for /F "delims=" DName in ('dir /ad /b /s "$ArchiveDir"')
#########for DName in ($(ls -dR1 "$ArchiveDir")) 
#########do 
############$(source "PruneArchive.sh $KeepArchNr $DName")
$(read -n1 -r -p "(source PruneArchive.sh KeepArchNr DName: Press any key to continue...")
#########done
	fi
	echo
fi

$(cat "Progs/$FirstRun")
#PATH=$PATHbak
[ "$Silent" != "yes" ] && $(read -n1 -r -p "Press any key to end this script...")

