$(function () {
    //define variables
    var activeNote = 0;
    //load notes on page load: Ajax call to loadnotes.php
    $.ajax({
        url: "loadnotes.php",
        success: function (data) {
            $('#notes').html(data);
        },
        error: function () {
            $('#alertContent').text("There was an error with the Ajax Call. Please try again!");
            $("#alert").fadeIn();
        }
    });

    //add a new note: Ajax call to createnotes.php
    $('#addNote').click(function () {
        $.ajax({
            url: "createnote.php",
            success: function (data) {
                if (data == 'error') {
                    $('#alertContent').text("There was an issue inserting the new note in the database!");
                    $("#alert").fadeIn();
                } else {
                    //update activeNote to the id of the new note
                    activeNote = data;
                    $("textarea").val("");
                    //show hide elements
                    showHide(["#notePad", "#allNotes"], ["#notes", "#addNote", "#edit", "#done"]);
                    $("textarea").focus();
                }
            },
            error: function () {
                $('#alertContent').text("There was an error with the Ajax Call. Please try again!");
                $("#alert").fadeIn();
            }
        });

    });
    //type note: Ajax call to updatenote.php

    //click on all notes button
    $("#allNotes").click(function () {
        $.ajax({
            url: "loadnotes.php",
            success: function (data) {
                $('#notes').html(data);
                showHide(["#addNote", "#edit", "#notes"], ["#allNotes", "#notePad"]);
            },
            error: function () {
                $('#alertContent').text("There was an error with the Ajax Call. Please try again!");
                $("#alert").fadeIn();
            }
        });
    });

    //click on done after editing: load notes again
    //click on edit: go to edit mode (show delete buttons, ...)

    //functions
    //click on a note
    //click on delete
    //show Hide function

    function showHide(array1, array2) {
        for (i = 0; i < array1.length; i++) {
            $(array1[i]).show();
        }
        for (i = 0; i < array2.length; i++) {
            $(array2[i]).hide();
        }
    };


});
