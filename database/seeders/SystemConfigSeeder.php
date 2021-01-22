<?php

namespace Database\Seeders;

use App\Enums\Type\SystemConfigDataType;
use App\Http\Requests\SystemConfigRequest;
use App\Services\Contract\SystemConfigService;
use Illuminate\Database\Seeder;

class SystemConfigSeeder extends Seeder
{
    private SystemConfigService $configRepository;

    public function __construct(SystemConfigService $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $config = [
            [
                'id' => 'CONTACT',
                'data_type' => SystemConfigDataType::JSON,
                'value' => [
                    'address' => 'Thái Nguyên',
                    'email' => 'hoangthuatk4b@gmail.com',
                    'phone_number' => '0987654321',
                    'facebook' => '',
                    'twitter' => '',
                    'instagram' => '',
                    'google' => ''
                ]
            ],
            [
                'id' => 'NOTIFY_EMAIL',
                'data_type' => SystemConfigDataType::TEXT,
                'value' => 'hoangminhk4b@gmail.com'
            ],
            [
                'id' => 'APP_NAME',
                'data_type' => SystemConfigDataType::TEXT,
                'value' => 'T-TechVN'
            ],
            [
                'id' => 'LOGO',
                'data_type' => SystemConfigDataType::TEXT,
                'value'  => '/logo.png'
            ],
            [
                'id' => 'FAVICON',
                'data_type' => SystemConfigDataType::TEXT,
                'value' => '/favicon.ico'
            ],
            [
                'id' => 'EXTRA_MENU_LINKS',
                'data_type' => SystemConfigDataType::JSON,
                'value' => [
                    [
                        'title' => 'Tin tức',
                        'path' => 'tin-tuc'
                    ],
                    [
                        'title' => 'Dịch vụ',
                        'path' => 'dich-vu'
                    ],
                    [
                        'title' => 'Tuyển dụng',
                        'path' => 'tuyen-dung'
                    ],
                    [
                        'title' => 'Liên hệ',
                        'path' => 'lien-he'
                    ]
                ]
            ],
            [
                'id' => 'ABOUT_US_HOME',
                'data_type' => SystemConfigDataType::JSON,
                'value' => [
                    'images' => '/imagesabc.png',
                    'info' => [
                        [
                            'title' => 'Nhân viên',
                            'value' => 1800
                        ],
                        [
                            'title' => 'Lãnh đạo',
                            'value' => 5
                        ]
                    ]
                ]
            ]
        ];

        foreach ($config as $c) {
            $this->configRepository->createOrEdit($c['id'], SystemConfigRequest::create('', 'POST', $c));
        }
    }
}
