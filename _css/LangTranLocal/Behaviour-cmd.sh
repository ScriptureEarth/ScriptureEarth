#! /usr/bin/env bash
    # Behaviour.sh
    # This is a control file for the LangTranUpdate script.
    #
    # (If you have just reinstalled this program, your previous file
    # is available in the file "BehaviourPrev.txt".)
    #
    # When you edit the current file with Notepad,
    # you can control the way LangTranUpdate behaves by adding or removing "rem"
    # at the beginning of a line.
    #
    # For example, the script compares the previous list of files on your computer
    # with the files as they are after an update,
    # and writes the differences into a file in the folder called "Diffs".
    # The next line tells the script to display the latest differences file:
    ShowDifferences=yes
    # If you don't want to do that, remove the "rem" from the next line:
# set ShowDifferences=no
    # (If you run LangTranUpdate as a scheduled task,
    #  you won't want it to show you the differences file.)
    #
    # In the file of differences, we show just one line of context above and below
    # each set of different lines. If you would like to see more context,
    # change the number on the next line.
    DiffContext=1
    #
    # The next variable tells the script how many files to keep
    # in the folders "Diffs" and "FileLists"
    # You can change the number on the next line if you want to.
    KeepNr=16
    #
    # In the differences file, we don't normally show the old and new file lists
    # and other files that change as the program works.
    PruneDiffs=yes
    # If you DO want to see these differences, remove the "rem" from the next line:
# set PruneDiffs=
    #
    # Some people like to keep an archive of files,
    # in case the latest version of a program doesn't work properly
    # and they want to remove it and reinstall the previous version.
    KeepArchive=no
    # If you want to keep old versions on your computer,
    # remove the "rem" from the next line:
# set KeepArchive=yes
    #
    # If you want to keep an archive of previous versions of installers,
    #    you will need to set ArchiveDir to the place you want the archive to be.
    ArchiveDir=../LangTranArchive
    # The previous line says that the archive folder should be beside LangTranLocal.
    # If you would like to put it somewhere else,
    #    remove the "rem" from one of the following "set" lines, or make your own:
# set ArchiveDir=C:\NoBackup\LangTranArchive
# set ArchiveDir=C:\LangTranArchive
# set ArchiveDir="%Docs%\LangTranArchive"
    # (The Docs variable refers to your usual Documents folder.)
    #
    # Tell me how many versions of installers to keep in the archive.
    # (The default is 4.)
    KeepArchNr=4
    #
    # The LangTranUpdate script is set up to communicate with you,
    # so there are places where it asks you to do something before it continues.
    Silent=no
    # If you want to run the updates unattended, such as at 2 AM every day,
    # you can tell the script not to ask you to do anything. To do that,
    # remove the "rem" from the next line:
# set Silent=yes
    #
    # When you have finished editing this file,
    # save the file and close the editor.
    # Then you can run the script to update your local LangTran repository.
    # End of control file.
