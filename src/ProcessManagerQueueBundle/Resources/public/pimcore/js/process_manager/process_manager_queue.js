/**
 */

$(document).on('processmanager.ready', function () {
    console.log("ADD QUEUE UI HERE");
    // processmanager.executable.types.importdefinition = Class.create(pimcore.plugin.processmanager.executable.abstractType, {
    //     getItems: function () {
    //         pimcore.globalmanager.get('importdefinitions_definitions').load();

    //         return [{
    //             xtype: 'combo',
    //             fieldLabel: t('importdefinitions_definition'),
    //             name: 'definition',
    //             displayField: 'name',
    //             valueField: 'id',
    //             store: pimcore.globalmanager.get('importdefinitions_definitions'),
    //             value: this.data.settings.definition,
    //             allowBlank: false
    //         }, {
    //             xtype: 'fieldcontainer',
    //             fieldLabel: t('importdefinitions_processmanager_params'),
    //             layout: 'hbox',
    //             width: 500,
    //             value: this.data.settings.filePath,
    //             items: [{
    //                 xtype: "textfield",
    //                 name: 'params',
    //                 id: 'importdefinitions_processmanager_params',
    //                 width: 450,
    //                 value: this.data.settings.params,
    //                 allowBlank: true
    //             }, {
    //                 xtype: "button",
    //                 text: t('find'),
    //                 iconCls: "pimcore_icon_search",
    //                 style: "margin-left: 5px",
    //                 handler: this.openSearchEditor.bind(this)
    //             },
    //             {
    //                 xtype: "button",
    //                 text: t('upload'),
    //                 cls: "pimcore_inline_upload",
    //                 iconCls: "pimcore_icon_upload",
    //                 style: "margin-left: 5px",
    //                 handler: function (item) {
    //                     this.uploadDialog();
    //                 }.bind(this)
    //             }]
    //         }];
    //     },

    //     uploadDialog: function () {
    //         pimcore.helpers.assetSingleUploadDialog("", "path", function (res) {
    //             try {
    //                 var data = Ext.decode(res.response.responseText);
    //                 if (data["id"]) {
    //                     this.setValue(data["fullpath"]);
    //                 }
    //             } catch (e) {
    //                 console.log(e);
    //             }
    //         }.bind(this));
    //     },

    //     openSearchEditor: function () {
    //         pimcore.helpers.itemselector(
    //             false,
    //             this.addDataFromSelector.bind(this),
    //             {
    //                 type: ["asset"],
    //                 subtype: {},
    //                 specific: {}
    //             }
    //         );
    //     },

    //     addDataFromSelector: function (data) {
    //         this.setValue(data.fullpath);
    //         console.log(data);
    //     },

    //     setValue: function (value) {
    //         var params = '{"file":"web/var/assets' + value + '"}';
    //         Ext.getCmp('importdefinitions_processmanager_params').setValue(params);
    //     }
    // });
});