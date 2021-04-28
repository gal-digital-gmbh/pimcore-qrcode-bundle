pimcore.registerNS('pimcore.plugin.galdigital.qrcode.item');

pimcore.plugin.galdigital.qrcode.item = Class.create({
  initialize: function initialize(data, parentPanel) {
    this.data = data;
    this.parentPanel = parentPanel;

    this.addLayout();
  },

  addLayout: function addLayout() {
    this.form = new Ext.form.FormPanel({
      region: 'center',
      bodyStyle: 'padding: 10px',
      labelWidth: 150,
      autoScroll: true,
      border: false,
      items: [{
        xtype: 'fieldset',
        title: t('qr_code.details'),
        collapsible: false,
        items: [{
          xtype: 'textfield',
          name: 'name',
          value: this.data.name,
          fieldLabel: t('qr_code.name'),
          width: 450,
          disabled: true
        }, {
          xtype: 'textarea',
          name: 'description',
          value: this.data.description,
          fieldLabel: t('qr_code.description'),
          width: 450,
          height: 50
        }, {
          xtype: 'textfield',
          name: 'url',
          value: this.data.url,
          fieldLabel: t('qr_code.url'),
          width: 450,
          fieldCls: 'input_drop_target',
          enableKeyEvents: true,
          listeners: {
            render: this.handleDropzone.bind(this)
          }
        }]
      }]
    });

    this.codePanel = new Ext.Panel({
      html: '',
      border: true,
      height: 250
    });

    var downloadButton = {
      border: false,
      buttons: [{
        width: '100%',
        text: t('qr_code.download'),
        iconCls: 'pimcore_icon_png',
        handler: this.download.bind(this)
      }]
    };

    var preview = new Ext.Panel({
      region: 'east',
      width: 270,
      border: false,
      autoScroll: true,
      bodyStyle: 'padding: 10px;',
      items: [this.codePanel, downloadButton]
    });

    this.panel = new Ext.Panel({
      border: false,
      layout: 'border',
      closable: true,
      bodyStyle: 'padding: 20px;',
      title: this.data.name,
      id: 'qr_codes_item_' + this.data.name,
      items: [
        this.form,
        preview
      ],
      buttons: [{
        text: t('qr_code.save'),
        iconCls: 'pimcore_icon_apply',
        handler: this.save.bind(this)
      }]
    });

    this.parentPanel.getEditPanel().add(this.panel);
    this.parentPanel.getEditPanel().setActiveTab(this.panel);

    pimcore.layout.refresh();

    this.generateCode();
  },

  handleDropzone: function handleDropzone(el) {
    new Ext.dd.DropZone(el.getEl(), {
      reference: el,
      ddGroup: 'element',
      getTargetFromEvent: function getTargetFromEvent() {
        return this.getEl();
      }.bind(el),

      onNodeOver: function onNodeOver(target, dd, e, data) {
        if (data.records.length === 1 && data.records[0].data.elementType === 'document') {
          return Ext.dd.DropZone.prototype.dropAllowed;
        }

        return undefined;
      },

      onNodeDrop: function onNodeDrop(element, target, dd, e, data) {
        if (pimcore.helpers.dragAndDropValidateSingleItem(data)) {
          var record = data.records[0].data;

          if (record.elementType === 'document') {
            element.setValue(record.path);

            return true;
          }
        }

        return false;
      }.bind(this, el)
    });
  },

  generateCode: function generateCode() {
    if (!this.data.name) {
      return;
    }

    this.codePanel.update('<img src="' + this.getImageUrl() + '" style="padding: 10px; width: 100%;"/>');
  },

  save: function save() {
    Ext.Ajax.request({
      url: Routing.generate('galdigital_qrcode_admin_update'),
      method: 'PUT',
      params: {
        configuration: Ext.encode(this.form.getForm().getFieldValues()),
        name: this.data.name
      },
      success: this.onSaved.bind(this)
    });
  },

  onSaved: function onSaved() {
    this.parentPanel.tree.getStore().load();
    pimcore.helpers.showNotification(t('qr_code.success'), t('qr_code.saved_successfully'), 'success');
  },

  download: function download() {
    if (!this.data.name) {
      return;
    }

    pimcore.helpers.download(this.getImageUrl(true));
  },

  getImageUrl: function getImageUrl(download) {
    var params = {
      name: this.data.name,
      _dc: (new Date()).getTime()
    };

    if (download) {
      params.download = 1;
    }

    return Routing.generate('galdigital_qrcode_admin_code', params);
  }
});
