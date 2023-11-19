<?php

  $first= [

    [   
        'speaker' => 'You',
        'text' => '...'
    ],

    [
        'speaker' => 'You',
        'text' => 'Where am I?',

    ],

    [
        'speaker' => '',
        'text' => 'You look around, your vision is weak.',
    ],

    [
        'speaker' => 'You',
        'text' => 'Is that...?',
    ],

    [
        'speaker' => '',
        'text' => 'You see something, it appears to be a human',
    ],

    [
        'speaker' => '',
        'text' => 'But at the same time not a human, like a flash of colors blurring between forms',
    ],

    [
        'speaker' => 'You',
        'text' => 'What should I do?',
        'choices' => [
            [
                'text' => 'Try to hide.',
                'next' => 'explore',
            ],
            [
                'text' => 'Approach the figure.',
                'next' => 'talkToStranger',
            ],
        ],
    ],
];
    
$explore = [

        [   
            'speaker' => '',
            'text' => 'You attempt to flee...',
        ],

        [
            'speaker' => '',
            'text' => 'Whatever you were seeing grabs you',
            'choices' => [
                [
                    'text' => 'Try to break free',
                    'next' => 'struggle',
                ],
                [
                    'text' => 'Try talking to it',
                    'next' => 'talkToStranger',
                ],
            ]
        ],


];

$struggle = [
    [   
        'speaker' => '',
        'text' => 'You struggle, but your efforts are in vain',
    ],

    [   
        'speaker' => '???',
        'text' => '...',
    ],

    [   
        'speaker' => '',
        'text' => 'Two eyes form in front of you...',
    ],

    [   
        'speaker' => '',
        'text' => 'And then you see nothing...',
    ],

    [   
        'speaker' => 'You',
        'text' => '...'
    ],

    [   
        'speaker' => 'You',
        'text' => 'Am I dead?',
    ],

    [   
        'speaker' => '',
        'text' => 'You feel a sharp pain, and then a flash of light',
    ],

    [   
        'speaker' => '',
        'text' => 'You realize you are still in that things clutches, and feel yoursel get tossed aside',
        'choices' => [
            [
                'text' => 'Try reasoning',
                'next' => 'exit',
            ],
            [
                'text' => 'Try shouting',
                'next' => 'exit',
            ],
        ]
    ],

];

    $talkToStranger = [

        [
            
            'speaker' => '???',
            'text' => 'How did you get in here?',
        ],
    
        [
            'speaker' => '',
            'text' => 'You are at a loss for words, you can barely see, let alone speak',
        ],
    

        [
            'speaker' => '',
            'text' => 'Whatever you are seeing grabs you',
            'choices' => [
                [
                    'text' => 'Try to break free',
                    'next' => 'struggle',
                ],
                [
                    'text' => 'Plead for your life',
                    'next' => 'struggle',
                ],
            ]
        ],
];

$exit = [
    [
    'speaker' => '',
    'text' => 'You wake up in a different place',
    'moveto' => 'field-one',
    ]
];
?>