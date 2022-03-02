<?php

return [

    'expense_type' => [

        'Housing' => [
            'image' => '/images/svg/expense-housing.svg',
            'types' => [
                'Rent' => [
                    'name' => 'Rent',
                    'type' => '459C544A-6823-4E81-9F1C-B15B6F529B48',
                ],
                'Property Taxes' => [
                    'name' => 'Property Taxes',
                    'type' => '44263138-8EB3-4DB3-A4AB-50E21ED903F6',
                ],
                'HOA' => [
                    'name' => 'HOA',
                    'type' => '2A7A2E9F-426B-4956-BD35-FF045BFD93A4',
                    'detail' => 'HOA',
                ],
                'Lot Fees' => [
                    'name' => 'Lot Fees',
                    'type' => '2A7A2E9F-426B-4956-BD35-FF045BFD93A4',
                ],
            ],
        ],

        'Insurance' => [
            'image' => '/images/svg/expense-insurance.svg',
            'types' => [
                'Homeowners' => [
                    'name' => 'Homeowners',
                    'type' => 'AF4DE14B-5E72-4B9C-A300-59146E444CAC',
                ],
                'Renters' => [
                    'name' => 'Renters',
                    'type' => 'F8B12EAB-B234-4BDA-8AF9-71998C7E0537',
                ],
                'Life' => [
                    'name' => 'Life',
                    'type' => '0EDC48C5-7DF3-4B11-B79F-E0718430BB2F',
                ],
                'Car' => [
                    'name' => 'Car',
                    'type' => '8ACD11BD-0CBC-4F33-926B-4D853FE17C92',
                ],
                'Medical Insurance Premiums' => [
                    'name' => 'Medical Insurance Premiums',
                    'type' => 'B0AEC501-2EC5-4AC1-97A8-D89F967D708C',
                ],
            ],
        ],

        'Food/Household Supplies' => [
            'image' => '/images/svg/expense-food.svg',
            'types' => [
                'Groceries' => [
                    'name' => 'Groceries',
                    'type' => 'B8CD8FEB-51AF-4F86-B6E2-68F69224503C',
                ],
                'Dining Out' => [
                    'name' => 'Dining Out',
                    'type' => '24823640-3736-43C4-B171-3210A39EA16F',
                ],
                'Cleaning Supplies/Toiletries' => [
                    'name' => 'Cleaning Supplies/Toiletries',
                    'type' => '70417039-6126-49DA-891E-9AB7D43616C8',
                ],
                'Alcohol/Tobacco' => [
                    'name' => 'Alcohol/Tobacco',
                    'type' => '1ADAEB9B-F9E8-4F49-87B4-B27A1DE9F64F',
                    'detail' => 'Alcohol-Tobacco',
                ],
            ],
        ],

        'Medical' => [
            'image' => '/images/svg/expense-medical.svg',
            'types' => [
                'Provider visits' => [
                    'name' => 'Provider visits',
                    'type' => '4DD5C8FB-47BE-49A2-8AB0-DA4595AD83E4',
                ],
                'Prescriptions' => [
                    'name' => 'Prescriptions',
                    'type' => 'F7C3737C-A861-469E-A3E7-8E146FADC134',
                ],
            ],
        ],

        'Transportation' => [
            'image' => '/images/svg/expense-transportation.svg',
            'types' => [
                'License & Taxes' => [
                    'name' => 'License & Taxes',
                    'type' => 'BA37C09E-B77A-4DF6-B2DE-4042FA0F0FD8',
                ],
                'Car Repairs' => [
                    'name' => 'Car Repairs',
                    'type' => '52111CC2-DC17-40EF-A6FA-68C46C233790',
                ],
                'Gasoline' => [
                    'name' => 'Gasoline',
                    'type' => 'B98C299A-0070-4094-B97C-FEEA0045BAB9',
                ],
            ],
        ],

        'Utilities' => [
            'image' => '/images/svg/expense-utilities.svg',
            'types' => [
                'Cable' => [
                    'name' => 'Cable',
                    'type' => 'A617F433-04FB-4CFF-AA29-D67F96B41567',
                ],
                'Internet' => [
                    'name' => 'Internet',
                    'type' => '1ADAEB9B-F9E8-4F49-87B4-B27A1DE9F64F',
                    'detail' => 'Internet',
                ],
                'Electric' => [
                    'name' => 'Electric',
                    'type' => '67EC522E-7A27-42CC-875E-4C4D5D9411F5',
                ],
                'Gas/oil/propane' => [
                    'name' => 'Gas/oil/propane',
                    'type' => 'CA6001CE-5F5B-42ED-B3A6-347529B82988',
                ],
                'Telephone' => [
                    'name' => 'Telephone',
                    'type' => 'A1983DCF-9886-44DA-9A5D-05C1C915C0BC',
                ],
                'Mobile Phone' => [
                    'name' => 'Mobile Phone',
                    'type' => '42A719A3-DA95-46AD-8839-0B5FF26F2165',
                ],
                'Security System' => [
                    'name' => 'Security System',
                    'type' => 'A5DA1935-0883-4D1C-831D-8E58C70F0169',
                ],
                'Trash/Recycling' => [
                    'name' => 'Trash/Recycling',
                    'type' => 'BB59956E-F86B-42CA-AC12-24E07FC47E96',
                ],
                'Water/Sewer' => [
                    'name' => 'Water/Sewer',
                    'type' => '59AD73F1-9E94-4456-AFF2-72439168B3B4',
                ],
            ],
        ],

        'Miscellaneous' => [
            'image' => '/images/svg/expense-misc.svg',
            'types' => [
                'Alimony' => [
                    'name' => 'Alimony',
                    'type' => 'F9A29B19-D300-4C06-A0AB-F67FD8B7702A',
                ],
                'Child Care' => [
                    'name' => 'Child Care',
                    'type' => '73F988FC-3368-4F1D-8FBF-1A8B70BBDBE8',
                ],
                'Child Support' => [
                    'name' => 'Child Support',
                    'type' => '51A2D8F8-5018-4220-A79F-BD0B2FCFA2A0',
                ],
                'School Expenses/Tuition' => [
                    'name' => 'School Expenses/Tuition',
                    'type' => '880E2959-49B2-423D-9213-A19D81544453',
                ],
                'Barber/Beauty' => [
                    'name' => 'Barber/Beauty',
                    'type' => '831225C9-9E00-4F5E-9A9E-E5B1BDB33099',
                ],
                'Savings' => [
                    'name' => 'Savings',
                    'type' => '52EF3ADB-B5BE-421A-A39F-15884CEC5268',
                ],
                'Retirement Plan' => [
                    'name' => 'Retirement Plan',
                    'type' => '1ADAEB9B-F9E8-4F49-87B4-B27A1DE9F64F',
                    'detail' => 'Retirement Savings',
                ],
                'Clothing' => [
                    'name' => 'Clothing',
                    'type' => 'A512661E-8742-47A8-9847-51FD607B3E01',
                ],
                'Dry Cleaning' => [
                    'name' => 'Dry Cleaning',
                    'type' => '008E44C1-4F3A-4273-A509-149D513FD058',
                ],
            ],
        ],

        'Subscriptions' => [
            'image' => '/images/svg/expense-subscriptions.svg',
            'types' => [
                'Streaming Services' => [
                    'name' => 'Streaming Services',
                    'type' => '1ADAEB9B-F9E8-4F49-87B4-B27A1DE9F64F',
                    'detail' => 'Streaming Services',
                ],
                'Apps' => [
                    'name' => 'Apps',
                    'type' => '1ADAEB9B-F9E8-4F49-87B4-B27A1DE9F64F',
                    'detail' => 'Apps',
                ],
                'Gym' => [
                    'name' => 'Gym',
                    'type' => '1ADAEB9B-F9E8-4F49-87B4-B27A1DE9F64F',
                    'detail' => 'Gym',
                ],
                'Clothing' => [
                    'name' => 'Clothing',
                    'type' => '1ADAEB9B-F9E8-4F49-87B4-B27A1DE9F64F',
                    'detail' => 'Clothing Subscription',
                ],
            ],
        ],
    ],
];
