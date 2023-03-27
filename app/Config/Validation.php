<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $createUser = [
        'user_name'          => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'User name is required',
            ],
        ],
        'user_email'         => [
            'rules'    => 'required|valid_email|is_unique[va_users.user_email,login_id,{login_id}]',
            'errors'   => [
                'required' => 'Email is required',
                'valid_email' => 'Please enter valid email',
                'is_unique' => 'Email already existed'
            ]
        ],
        'user_password'          => [
            'rules'     => 'required|min_length[6]|max_length[15]',
            'errors'    => [
                'required' => 'Password is required',
                'min_length'    => 'Your password is too short',
                'max_length'    => 'Your password should be 6 to 15 character long'
            ]
        ],
        'confirm_password'  => [
            'rules' => 'required|matches[user_password]',
            'errors' => [
                'required' => 'Confirm password is required',
                'matches' => 'Passwords entered should be same'
            ]
        ],
        'login_id'          => [
            'rules'    => 'required|is_unique[va_users.login_id,login_id,{login_id}]',
            'errors'   => [
                'required' => 'Login Id is required',
                'is_unique' => 'Login Id already existed'
            ]
        ],
        'phone_number'      => [
            'rules'    => 'required|max_length[10]|numeric',
            'errors'   => [
                'required' => 'Phone Number is required',
                'max_length' => 'Phone Number should be 10 character long',
                'numeric' => 'Phone Number accepts only numeric character'
            ]
        ],
    ];
    public $userLogin = [
        'user_password'          => [
            'rules'     => 'required',
            'errors'    => [
                'required' => 'Password is required'
            ]
        ],
        'login_id'          => [
            'rules'    => 'required',
            'errors'   => [
                'required' => 'Login Id is required'
            ]
        ]
    ];
    public $clientRegistration = [
        'customer_name'          => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'Customer name is required',
            ],
        ],
        'address'          => [
            'rules'     => 'required',
            'errors'    => [
                'required' => 'Address is required',
            ]
        ],
        'aadhar_number'      => [
            'rules'    => 'required|min_length[12]|max_length[16]|numeric',
            'errors'   => [
                'required' => 'Aadhar Number is required',
                'max_length' => 'Aadhar Number should not exceed 16 character',
                'min_length' => 'Aadhar Number must be minimum 12 character long',
                'numeric' => 'Aadhar Number accepts only numeric character'
            ]
        ],
        'type_of_project'      => [
            'rules'    => 'required',
            'errors'   => [
                'required' => 'Type of Project is required',
            ]
        ],
        'login_id'          => [
            'rules'    => 'required',
            'errors'   => [
                'required' => 'Login Id is required',
            ]
        ],
        'customer_id'          => [
            'rules'    => 'required|is_unique[va_clients.customer_id,customer_id,{customer_id}]',
            'errors'   => [
                'required' => 'Customer Id is required',
                'is_unique' => 'Customer Id already existed'
            ]
        ],
        'contact_number'      => [
            'rules'    => 'required|max_length[10]|numeric',
            'errors'   => [
                'required' => 'Contact Number is required',
                'max_length' => 'Contact Number should be 10 character long',
                'numeric' => 'Contact Number accepts only numeric character'
            ]
        ],
    ];
}
