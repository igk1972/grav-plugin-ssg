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
          '' => ['build'],
          'config' => ['build/grav/config'],
          'accounts' => ['build/grav/accounts'],
          'plugins' => ['build/grav/plugins'],
          'pages' => ['build/content'],
          'static' => ['build/static'],
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
          '' => ['user://static/assets'],
        ]
      ],
      'asset' => [
        'type' => 'Stream',
        'force' => true,
        'prefixes' => [
          '' => ['user://static/assets'],
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
          '' => ['cache'],
          'images' => ['static://images'],
        ]
      ]
    ]
  ]
];
