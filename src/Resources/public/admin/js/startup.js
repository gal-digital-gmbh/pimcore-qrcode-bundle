document.addEventListener(pimcore.events.pimcoreReady, () => {
  var user = pimcore.globalmanager.get('user');

  if (!user.isAllowed('qr_codes')) {
    return;
  }

  var marketingMenu = pimcore.globalmanager.get('layout_toolbar').marketingMenu;

  if (!marketingMenu) {
    return;
  }

  var button = new Ext.Action({
    id: 'qr_codes',
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

  marketingMenu.add(button);
});
