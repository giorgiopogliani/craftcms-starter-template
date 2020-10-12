<?php

return [
  'imageStyles' => [

    // since the 'thumb' style has no sources, it will generate
    // an img element, not a picture element
    'thumb' => [
      'img' => [
        'aspectRatio' => 1,
        'sizes' => '75px',
        'widths' => [75, 150]
      ]
    ],

    // since the 'thumb' style has no sources, it will generate
    // an img element, not a picture element
    'card' => [
      'sources' => [
        [
          'media' => implode(' ', [
            '( -webkit-min-device-pixel-ratio: 2),',
            '( min--moz-device-pixel-ratio: 2),',
            '( -o-min-device-pixel-ratio: 2/1),',
            '( min-device-pixel-ratio: 2),',
            '( min-resolution: 192dpi),',
            '( min-resolution: 2dppx)',
          ]),
          'widths' => [600]
        ],
      ],
      'img' => [
        'widths' => [300]
      ],
      'transform' => [
        'format' => 'png'
      ]
    ],

    // since the 'thumb' style has no sources, it will generate
    // an img element, not a picture element
    'banner' => [
      'sources' => [
        [
          'media' => implode(' ', [
            '(min-width: 36em)',
          ]),
          "sizes" => "33.3vw",
          'widths' => [1920, 1024, 640, 320]
        ],
      ],
    ],

    // the 'lazyLoaded' style for elements that use lazysizes for lazyloading.
    // See also lazysizesTrigger config value
    // <img
    //   class="lazyload"
    //   data-srcset="transform500pxUrl 500w, transform1000pxUrl 1000w"
    //   data-sizes="25vw"
    //   data-src="transform500pxUrl"
    // />
    'lazyLoaded' => [
      // optional lazysizes. Can be boolean (true = lazysizes, false = no lazysizes) or
      // string (uses string value for src attribute value)
      'lazysizes' => true,
      'img' => [
        'sizes' => '25vw',
        'widths' => [500, 1000]
      ]
    ],

    // the default style will be used when none is specified.
    'default' => [
      'img' => [
        'widths' => [500],
      ]
    ]
  ],

  // the urlTransforms are used to specify individual urls for
  // craft.picture.url
  'urlTransforms' => [
    // the 'hero' transform - these image will be 7:3, and 1000px wide
    'hero' => [
      'aspectRatio' => 7/3,
      'width' => 1000
    ]
  ],

  // lazysizesTrigger is an optional override for elements loaded with
  // lazysizes. It changes the class value from 'lazyload'
  'lazysizesTrigger' => 'js-lazyload'
];
