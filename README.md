Monsoon Test (magento module)
===========================

Magento module to enable|disable clickable category menu item on front.
Instruction:

1. Download the latest version of Magento Community Edition (ver 1.9.2.0  https://www.magentocommerce.com/download)
2. Install it.
3. Go to Admin Panel-> Catalog -> Manage Categories. Add Subcategories (for testing).
4. Copy Monsoon Test module into project directory according to its structure.
5. Clear cache on  Admin Panel-> Cache Management.
6. Go to Admin Panel-> Catalog -> Categories. Choose category you want to make unclickable, click on "General Information" tab.
   On the bottom of config fields find label "Clickable on navigation". Click to "No" and save category.
7. Refresh page on frontend and this category should have href="#" and be unclickable.


Module Version: v0.1.0
------

Depends
------

- Mage Catalog

Structure
------

```sh
├── README.md
└── app
    ├── etc
    │   └── modules
    │       └── Monsoon_Test.xml
    └── code
        └── local
            └── Monsoon
                └── Test
                    ├── etc
                    │   └── config.xml
                    ├── Helper
                    │   └── Data.php
                    ├── Model
                    │   └── Observer.php
                    └── sql
                        └── monsoon_test_setup
                            └── install-0.1.0.php

```

Authors
------
 - Sergii Zheleznytskyi
