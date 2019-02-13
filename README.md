# eMagicOne Core for Magento 2

## How to install & upgrade Emagicone_Core

- Download [the latest version here](https://github.com/eMagicOne/Magento2Core/archive/master.zip)
- Extract zip file to `app/code/Emagicone/Core` (If you don't have folder `app/code/Emagicone/Core`, you should create it)
- Go to Magento root folder and run upgrade command line to install eMagicOne Core module:
```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```