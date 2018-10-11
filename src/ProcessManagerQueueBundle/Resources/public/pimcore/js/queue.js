/**
 */

pimcore.registerNS('pimcore.plugin.processmanagerqueue.queue');

pimcore.plugin.processmanagerqueue.queue = Class.create({
    storeId : 'processmanagerqueue_queue',
    task : null,

    url : {
        list : '/admin/process_manager_queue/jobs/list'
    },

    initialize: function () {
        this.createStore();
    },

    reloadProcesses: function() {
        pimcore.globalmanager.get(this.storeId).load(function () {
            this.createInterval();
        }.bind(this));
    },

    createInterval : function() {
        this.task = setTimeout(function () {
            this.reloadProcesses();
        }.bind(this), 5000);
    },

    stop : function() {
        clearTimeout(this.task);
    },

    createStore : function () {
        var proxy = new Ext.data.HttpProxy({
            url : this.url.list
        });

        var reader = new Ext.data.JsonReader({}, [
            { name: 'id' },
            { name: 'name' },
            { name: 'status' },
            { name: 'scheduledDate' }
        ]);

        var store = new Ext.data.Store({
            restful:    false,
            proxy:      proxy,
            reader:     reader,
            autoload:   true
        });

        pimcore.globalmanager.add(this.storeId, store);
        this.reloadProcesses();
    },

    activate: function () {
        var tabPanel = Ext.getCmp('pimcore_panel_tabs');
        tabPanel.setActiveItem(this.layoutId);
    },

    getLayout: function () {
        if (!this.layout) {
            this.layout = new Ext.Panel({
                title: t('processmanagerqueue_queue'),
                iconCls: this.iconCls,
                border: false,
                layout: 'fit',
                items: [this.getGrid()]
            });
        }

        return this.layout;
    },
    // showReportWindow: function(data) {
    //     var raportWin = new Ext.Window({
    //         title: data.report.title,
    //         modal: true,
    //         iconCls: "pimcore_icon_reports",
    //         width: 700,
    //         height: 400,
    //         html: data.report,
    //         autoScroll: true,
    //         bodyStyle: "padding: 10px; background:#fff;",
    //         buttonAlign: "center",
    //         shadow: false,
    //         closable: true
    //     });
    //     raportWin.show();
    // },

    showErrorWindow: function(message) {
        var errWin = new Ext.Window({
            title: "ERROR",
            modal: true,
            iconCls: "pimcore_icon_error",
            width: 600,
            height: 300,
            html: message,
            autoScroll: true,
            bodyStyle: "padding: 10px; background:#fff;",
            buttonAlign: "center",
            shadow: false,
            closable: true
        });
        errWin.show();
    },

    getGrid: function () {
        return {
            xtype: 'grid',
            store: pimcore.globalmanager.get(this.storeId),
            columns: [
                {
                    text : t('id'),
                    dataIndex : 'id',
                    width : 100
                },
                {
                    text: t('name'),
                    dataIndex: 'name',
                    flex: 1
                },
                {
                    text: t('status'),
                    dataIndex: 'status',
                    renderer: function (value) {
                        switch(value){
                            case 1:
                                return t('processmanagerqueue_status_scheduled');
                            case 2:
                                return t('processmanagerqueue_status_running');
                            case 3:
                                return t('processmanagerqueue_status_completed');
                            default:
                                return t('processmanagerqueue_status__unknown');
                        }                        
                    },
                    width: 200
                },
                {
                    text: t('processmanagerqueue_scheduled_date'),
                    dataIndex: 'scheduledDate',
                    renderer: function (value) {
                        var dt = Ext.Date.parse(value, "U");
                        var dt = Ext.Date.format(dt, "Y-m-d H:i:s");
                        return dt;
                    },
                    width: 300
                }
            ],
            useArrows: true,
            autoScroll: true,
            animate: true,
            containerScroll: true,
            viewConfig: {
                loadMask: false
            }
        };
    }
});
