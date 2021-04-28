pimcore.registerNS('pimcore.layout.toolbar');
pimcore.registerNS('pimcore.plugin.galdigital.qrcode');

pimcore.plugin.galdigital.qrcode = Class.create(pimcore.plugin.admin, {
  initialize: function initialize() {
    pimcore.plugin.broker.registerPlugin(this);
  },

  pimcoreReady: function pimcoreReady() {
    var user = pimcore.globalmanager.get('user');

    if (user.isAllowed('qr_codes')) {
      var button = this.getQrCodeButton();

      layoutToolbar.marketingMenu.add(button);
    }
  },

  getQrCodeButton: function getQrCodeButton() {
    return new Ext.Action({
      id: 'qr_codes',
      text: t('qr_code.title'),
      iconCls: 'pimcore_nav_icon_qrcode',
      handler: this.openQrCodes.bind(this)
    });
  },

  openQrCodes: function openQrCodes() {
    var panel = pimcore.globalmanager.get('qr_codes');

    if (!panel) {
      panel = this.createQrCodePanel();
    }

    panel.activate();
  },

  createQrCodePanel: function createQrCodePanel() {
    var panel = new pimcore.plugin.galdigital.qrcode.panel();

    pimcore.globalmanager.add('qr_codes', panel);

    return panel;
  }
});

new pimcore.plugin.galdigital.qrcode();
