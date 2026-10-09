# ZebChat live chat for Magento 2

Add the [ZebChat](https://www.zebchat.com) live chat widget to your Magento 2 / Adobe Commerce
store. Sign in (or create a free account) from the Magento admin, pick your store's website and
turn the chat on. No code to paste.

- Magento 2.4.6 or newer, PHP 8.1+
- License: GPL-2.0-or-later

## Install with Composer (recommended)

```bash
composer config repositories.zebchat vcs https://github.com/techavenuelabs/zebchat-magento
composer require techavenuelabs/module-zebchat-widget:^1.1
bin/magento module:enable Zebchat_Widget
bin/magento setup:upgrade
bin/magento cache:flush
```

## Install from the zip

1. Download `zebchat-magento.zip` from the
   [latest release](https://github.com/techavenuelabs/zebchat-magento/releases/latest).
2. Extract it into `app/code/` so the files end up in `app/code/Zebchat/Widget/`.
3. Run `bin/magento setup:upgrade` and `bin/magento cache:flush`.

## Set up

1. In the admin, open **ZebChat** in the menu.
2. Sign in to ZebChat or create an account.
3. Pick this store's website and turn the chat on.

The storefront block is cached with the tag `zebchat_widget`, which is cleaned whenever the
setting is saved.

## Support

hello@zebchat.com · https://www.zebchat.com · Docs: https://www.zebchat.com/integrations/
