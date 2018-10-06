<?php

if ($envGravEnvironment = getenv('GRAV_ENV')) {
  $environment = strtolower($envGravEnvironment);
}
$environment = 'grav/environments/'.$environment;

return [
  'streams' => [
    'schemes' => [
      'user' => [
        'type' => 'ReadOnlyStream',
        'force' => true,
        'prefixes' => [
          ''           => ['app'],
          'config'     => ['app'.'/grav/config'],
          'accounts'   => ['app'.'/grav/accounts'],
          'plugins'    => ['app'.'/grav/plugins'],
          'pages'      => ['app'.'/content'],
          'blueprints' => ['app'.'/grav/blueprints'],
          'public'     => ['app'.'/dist/public'],
        ]
      ],
      'config' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['environment://config', 'user://grav/config', 'system/config'],
        ]
      ],
      'accounts' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['user://grav/accounts'],
        ]
      ],
      'account' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['user://grav/accounts'],
        ]
      ],
      'static' => [
        'type' => 'ReadOnlyStream',
        'force' => true,
        'prefixes' => [
          '' => ['user://static'],
        ]
      ],
      'pages' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['user://pages'],
        ]
      ],
      'page' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['user://pages'],
        ]
      ],
      'assets' => [
        'type' => 'Stream',
        'force' => true,
        'prefixes' => [
          '' => ['user://public/assets'],
        ]
      ],
      'asset' => [
        'type' => 'Stream',
        'force' => true,
        'prefixes' => [
          '' => ['user://public/assets'],
        ]
      ],
      'plugins' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['user://grav/plugins'],
         ]
      ],
      'plugin' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['user://grav/plugins'],
        ]
      ],
      'themes' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['user://grav/themes'],
        ]
      ],
      'theme' => [
        'type' => 'ReadOnlyStream',
        'prefixes' => [
          '' => ['user://grav/themes'],
        ]
      ],
      'cache' => [
        'type' => 'Stream',
        'force' => true,
        'prefixes' => [
          ''         => ['user://public/cache'],
          'images'   => ['user://public/images']
        ]
      ]
    ]
  ]
];
