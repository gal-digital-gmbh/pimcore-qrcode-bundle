pimcore.registerNS('pimcore.plugin.galdigital.qrcode.panel');

pimcore.plugin.galdigital.qrcode.panel = Class.create({
  initialize: function initialize() {
    this.getTabPanel();
  },

  activate: function activate() {
    this.getTabsPanel().setActiveItem('qr_codes_panel');
  },

  getTabsPanel: function getTabsPanel() {
    return Ext.getCmp('pimcore_panel_tabs');
  },

  getTabPanel: function getTabPanel() {
    if (!this.panel) {
      this.panel = new Ext.Panel({
        id: 'qr_codes_panel',
        title: t('qr_code.title'),
        iconCls: 'pimcore_icon_qrcode',
        border: false,
        layout: 'border',
        closable: true,
        items: [this.getTree(), this.getEditPanel()]
      });

      this.getTabsPanel().add(this.panel);
      this.activate();

      this.panel.on('destroy', function onDestroy() {
        pimcore.globalmanager.remove('qr_codes');
      });

      pimcore.layout.refresh();
    }

    return this.panel;
  },

  getTree: function getTree() {
    if (!this.tree) {
      var store = Ext.create('Ext.data.TreeStore', {
        autoLoad: false,
        autoSync: true,
        proxy: {
          type: 'ajax',
          url: Routing.generate('galdigital_qrcode_admin_list'),
          reader: {
            type: 'json',
            rootProperty: 'codes'
          }
        },
        root: {
          iconCls: 'pimcore_icon_thumbnails'
        }
      });

      this.tree = Ext.create('Ext.tree.Panel', {
        id: 'qr_codes_panel_tree',
        store: store,
        region: 'west',
        autoScroll: true,
        animate: false,
        containerScroll: true,
        width: 250,
        split: true,
        root: {
          id: '0'
        },
        rootVisible: false,
        tbar: {
          cls: 'pimcore_toolbar_border_bottom',
          items: [{
            text: t('qr_code.add'),
            iconCls: 'pimcore_icon_add',
            handler: this.addField.bind(this),
            disabled: !pimcore.settings['qrcode-writeable']
          }]
        },
        listeners: {
          itemclick: function onTreeNodeClick(tree, record) {
            this.openItem(record.data.id);
          }.bind(this),

          itemcontextmenu: function onTreeNodeContextMenu(tree, record, item, index, event) {
            tree.select();

            var menu = new Ext.menu.Menu();

            menu.add(new Ext.menu.Item({
              text: t('qr_code.delete'),
              iconCls: 'pimcore_icon_delete',
              handler: this.deleteField.bind(this, record),
              disabled: !record.data.writeable
            }));

            event.stopEvent();
            menu.showAt(event.pageX, event.pageY);
          }.bind(this),

          render: function render() {
            this.getRootNode().expand();
          },

          beforeitemappend: function beforeitemappend(thisNode, newChildNode) {
            newChildNode.data.leaf = true;
            newChildNode.data.iconCls = 'pimcore_icon_qrcode';
          }
        }
      });
    }

    return this.tree;
  },

  getEditPanel: function getEditPanel() {
    if (!this.editPanel) {
      this.editPanel = new Ext.TabPanel({
        region: 'center',
        plugins: [
          Ext.create('Ext.ux.TabCloseMenu', {
            showCloseAll: true,
            showCloseOthers: true
          }),
          Ext.create('Ext.ux.TabReorderer', {})
        ]
      });
    }

    return this.editPanel;
  },

  openItem: function openItem(id) {
    var existingPanel = Ext.getCmp('qr_codes_item_' + id);

    if (existingPanel) {
      this.editPanel.setActiveItem(existingPanel);
    } else {
      this.fetchItem(id, function onRequestSuccess(data) {
        new pimcore.plugin.galdigital.qrcode.item(data, this);
        pimcore.layout.refresh();
      }.bind(this));
    }
  },

  fetchItem: function fetchItem(id, callback) {
    Ext.Ajax.request({
      url: Routing.generate('galdigital_qrcode_admin_get'),
      params: {
        name: id
      },
      success: function onSuccess(response) {
        try {
          var code = Ext.decode(response.responseText).code;

          if (!code) {
            throw new Error('Could not decode item');
          }

          callback(code);
        } catch (error) {
          this.tree.getStore().load();

          Ext.Msg.alert(' ', t('qr_code.load_error'));
        }
      }.bind(this)
    });
  },

  addField: function addField() {
    Ext.MessageBox.prompt(
      ' ',
      t('qr_code.enter_name') + ' (a-zA-Z-_)',
      this.onAddFieldConfirm.bind(this),
      null,
      null,
      ''
    );
  },

  onAddFieldConfirm: function onAddFieldConfirm(button, value) {
    if (button !== 'ok') {
      return;
    }

    if (!this.isValidItemName(value)) {
      Ext.Msg.alert(t('qr_code.title'), t('qr_code.invalid'));

      return;
    }

    if (!this.isItemNameUnused(value)) {
      Ext.MessageBox.alert(' ', t('qr_code.exists'));

      return;
    }

    Ext.Ajax.request({
      url: Routing.generate('galdigital_qrcode_admin_add'),
      method: 'POST',
      params: {
        name: value
      },
      success: function onSuccess(response) {
        var data = Ext.decode(response.responseText);

        this.tree.getStore().load();

        if (!data || !data.success) {
          Ext.Msg.alert(' ', t('qr_code.save_error'));
        } else {
          this.openItem(data.id);
        }
      }.bind(this)
    });
  },

  isValidItemName: function isValidItemName(value) {
    return value.length > 2 && value.match(/^[a-zA-Z0-9_-]+$/);
  },

  isItemNameUnused: function isItemNameUnused(value) {
    return this.tree.getRootNode().childNodes.every(function onChildNodeCheck(childNode) {
      return childNode.data.id !== value;
    });
  },

  deleteField: function deleteField(record) {
    this.sendDeleteRequest(record.data.id);
    this.getEditPanel().removeAll();
    record.remove();
  },

  sendDeleteRequest: function sendDeleteRequest(name) {
    Ext.Ajax.request({
      url: Routing.generate('galdigital_qrcode_admin_delete'),
      method: 'DELETE',
      params: {
        name: name
      }
    });
  }
});
