/*
 * This file launches the application by asking Ext JS to create
 * and launch() the Application class.
 */
Ext.application({
    extend: 'sketchApp.Application',

    name: 'sketchApp',

    requires: [
        // This will automatically load all classes in the sketchApp namespace
        // so that application classes do not need to require each other.
        'sketchApp.*'
    ],

    // The name of the initial view to create.
//    mainView: 'sketchApp.view.main.Main'
});
