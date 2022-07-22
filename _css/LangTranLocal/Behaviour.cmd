@echo off
    rem Behaviour.cmd
    rem
    rem This is a control file for the LangTranUpdate script.

    rem (If you have just reinstalled this program, your previous file
    rem is available in the file "BehaviourPrev.txt".)
    rem
    rem When you edit the current file with Notepad,
    rem you can control the way LangTranUpdate behaves by adding or removing "rem"
    rem at the beginning of a line.

    rem For example, the script compares the previous list of files on your computer
    rem with the files as they are after an update,
    rem and writes the differences into a file in the folder called "Diffs".
    rem The next line tells the script to display the latest differences file:
    set ShowDifferences=yes
    rem If you don't want to do that, remove the "rem" from the next line:
rem set ShowDifferences=no
    rem (If you run LangTranUpdate as a scheduled task,
    rem  you won't want it to show you the differences file.)

    rem In the file of differences, we show just one line of context above and below
    rem each set of different lines. If you would like to see more context,
    rem change the number on the next line.
set DiffContext=1

    rem The next variable tells the script how many files to keep
    rem in the folders "Diffs" and "FileLists"
    rem You can change the number on the next line if you want to.
set KeepNr=16

    rem In the differences file, we don't normally show the old and new file lists
    rem and other files that change as the program works.
    set PruneDiffs=yes
    rem If you DO want to see these differences, remove the "rem" from the next line:
rem set PruneDiffs=

    rem Some people like to keep an archive of files,
    rem in case the latest version of a program doesn't work properly
    rem and they want to remove it and reinstall the previous version.
    set KeepArchive=no
    rem If you want to keep old versions on your computer,
    rem remove the "rem" from the next line:
rem set KeepArchive=yes

    rem If you want to keep an archive of previous versions of installers,
    rem    you will need to set ArchiveDir to the place you want the archive to be.
set ArchiveDir=..\LangTranArchive
    rem The previous line says that the archive folder should be beside LangTranLocal.
    rem If you would like to put it somewhere else,
    rem    remove the "rem" from one of the following "set" lines, or make your own:
rem set ArchiveDir=C:\NoBackup\LangTranArchive
rem set ArchiveDir=C:\LangTranArchive
rem set ArchiveDir="%Docs%\LangTranArchive"
    rem (The Docs variable refers to your usual Documents folder.)

    rem Tell me how many versions of installers to keep in the archive.
    rem (The default is 4.)
set KeepArchNr=4

    rem The LangTranUpdate script is set up to communicate with you,
    rem so there are places where it asks you to do something before it continues.
    set Silent=no
    rem If you want to run the updates unattended, such as at 2 AM every day,
    rem you can tell the script not to ask you to do anything. To do that,
    rem remove the "rem" from the next line:
rem set Silent=yes

    rem When you have finished editing this file,
    rem save the file and close the editor.
    rem Then you can run the script to update your local LangTran repository.
    rem End of control file.
