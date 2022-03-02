<?php

return [

    'debt_type' => [

        'Car Loan/Lease' => [
            'name' => 'Car Loan/Lease',
            'swagger_api_category' => 'Liabilities',
            'swagger_api_type' => '36E84D63-6F95-4247-99E6-4E4EF50B106C',
            'required_fields' => [
                'creditor',
                'monthly_payment',
                'balance_owed',
                'value',
            ],
        ],

        'Mortgage' => [
            'name' => 'Mortgage',
            'swagger_api_category' => 'Liabilities',
            'swagger_api_type' => '94E0E04C-ABB2-4385-8014-74BEC8179D2A',
            'required_fields' => [
                'creditor',
                'monthly_payment',
                'balance_owed',
                'value',
            ],
        ],

        'Credit Cards' => [
            'name' => 'Credit Cards',
            'swagger_api_category' => 'Debts',
            'swagger_api_type' => 'Credit Card',
            'required_fields' => [
                'creditor',
                'monthly_payment',
                'balanced_owed',
                'interest_rate',
                'past_due',
            ],
        ],

        'Personal Loans' => [
            'name' => 'Personal Loans',
            'swagger_api_category' => 'Liabilities',
            'swagger_api_type' => '18370E00-9022-4A0A-93DE-98EF6BEA287A',
            'required_fields' => [
                'creditor',
                'monthly_payment',
                'balanced_owed',
                'interest_rate',
                'past_due',
            ],
        ],

        'Student Loans' => [
            'name' => 'Student Loans',
            'swagger_api_category' => 'Liabilities',
            'swagger_api_type' => '31EE2840-F534-442D-BB0E-BF8D85219E22',
            'required_fields' => [
                'creditor',
                'monthly_payment',
                'balanced_owed',
                'interest_rate',
                'past_due',
            ],
        ],

        'Collection Accounts' => [
            'name' => 'Collection Accounts',
            'swagger_api_category' => 'Debts',
            'swagger_api_type' => 'Collection Account',
            'required_fields' => [
                'creditor',
                'monthly_payment',
                'balance_owed',
                'original_creditor',
            ],
        ],

        'Medical Bills' => [
            'name' => 'Medical Bills',
            'swagger_api_category' => 'Debts',
            'swagger_api_type' => 'Medical',
            'required_fields' => [
                'creditor',
                'monthly_payment',
                'balance_owed',
                'original_creditor',
            ],
        ],

        'Taxes' => [
            'name' => 'Taxes',
            'swagger_api_category' => 'Liabilities',
            'swagger_api_type' => '18370E00-9022-4A0A-93DE-98EF6BEA287A',
            'swagger_api_detail' => 'Taxes',
            'required_fields' => [
                'monthly_payment',
                'balance_owed',
            ],
        ],
    ],
];
