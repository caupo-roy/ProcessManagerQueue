/**
 */

pimcore.registerNS('pimcore.plugin.processmanager.panel');
console.log("PUFFY");
/* Override panel class from ProcessmanagerBundle */
pimcore.plugin.processmanager.panel = Class.create(pimcore.plugin.processmanager.panel,{
    getLayout: function () {
        if (!this.layout) {

            var processPanel = new pimcore.plugin.processmanager.processes();
            var executablesPanel = new pimcore.plugin.processmanager.executables(this.types);
            /* Create queue panel - start */
            var queuePanel = new pimcore.plugin.processmanagerqueue.queue();
            /* Create queue panel - end */

            var tabPanel = new Ext.tab.Panel({
                items: [
                    executablesPanel.getLayout(),
                    {
                        layout: 'fit',
                        title: t('processmanager_processes'),
                        iconCls: this.iconCls,
                        items: [
                            processPanel.getGrid()
                        ]
                    },
                    /* Add queue panel - start */
                    queuePanel.getLayout()
                    /* Add queue panel - end */
                ]
            });

            // create new panel
            this.layout = new Ext.Panel({
                id: this.layoutId,
                title: t('processmanager'),
                iconCls: this.iconCls,
                border: false,
                closable: true,
                layout: 'fit',
                items: [tabPanel]
            });

            // add event listener
            var layoutId = this.layoutId;
            this.layout.on('destroy', function () {
                pimcore.globalmanager.remove(layoutId);

                processPanel.stop();
            }.bind(this));

            // add panel to pimcore panel tabs
            var tabPanel = Ext.getCmp('pimcore_panel_tabs');
            tabPanel.add(this.layout);
            tabPanel.setActiveItem(this.layoutId);

            // update layout
            pimcore.layout.refresh();
        }

        return this.layout;
    },
});
