TYPO3.Fluid ViewRenderer for Yii2
=================================

Installation
------------

Via Composer

``` bash
$ composer require amylian/yii2-amylian-t3fluid
```

Register ViewHelper in Yii
--------------------------

``` php
$config = [
     /* ... */
    'components' => [
         /* ... */
        'view' => [
            'renderers' => [
                //
                // Register the Fluid ViewRenderer and make templates
                // as renderer for .html files
                //
                'html' => [  
                    'class' => 'amylian\yii\t3fluid\ViewRenderer',
                ],
            ]
        ],
         /* ... */
    ],
    'params' => $params,
];
```





