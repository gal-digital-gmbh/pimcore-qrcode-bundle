pimcore.registerNS("pimcore.plugin.galdigital.qrcode.startup");

pimcore.plugin.galdigital.qrcode.startup = Class.create({
  initialize: function () {
    document.addEventListener(pimcore.events.preMenuBuild, this.preMenuBuild.bind(this));
  },
  preMenuBuild: function (e) {
    var user = pimcore.globalmanager.get('user');

    if (!user.isAllowed('qr_codes')) {
      return;
    }

    var marketingMenu = e.detail.menu.marketing;

    if (!marketingMenu) {
      return;
    }

    marketingMenu.items.push({
      itemId: 'qr_codes',
      text: t('qr_code.title'),
      iconCls: 'pimcore_nav_icon_qrcode',
      handler: () => {
        var panel = pimcore.globalmanager.get('qr_codes');

        if (!panel) {
          panel = new pimcore.plugin.galdigital.qrcode.panel();

          pimcore.globalmanager.add('qr_codes', panel);
        }

        panel.activate();
      }
    });
  }
});

const qrcode = new pimcore.plugin.galdigital.qrcode.startup();
