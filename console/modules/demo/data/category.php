<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
return [
    [
        'id' => 1,
        'parent_id' => null,
        'url' => 'clothing',
        'category_description' => [
            [
                'id' => 1,
                'category_id' => 1,
                'language_id' => 1,
                'name' => 'Clothing'
            ],
            [
                'id' => 2,
                'category_id' => 1,
                'language_id' => 2,
                'name' => 'Одежда'
            ],
        ]
    ],
    [
        'id' => 2,
        'parent_id' => null,
        'url' => 'shoes',
        'category_description' => [
            [
                'id' => 3,
                'category_id' => 2,
                'language_id' => 1,
                'name' => 'Shoes'
            ],
            [
                'id' => 4,
                'category_id' => 2,
                'language_id' => 2,
                'name' => 'Обувь'
            ]
        ]
    ]
];