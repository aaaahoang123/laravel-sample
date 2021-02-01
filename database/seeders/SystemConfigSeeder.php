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
                'id' => 'TESTIMONIAL',
                'data_type' => SystemConfigDataType::JSON,
                'value' => [
                    [
                        'content' => 'Chúng tôi đã sử dụng qua dịch vụ của các bạn, rất hài lòng và sẽ hợp tác tiếp',
                        'author' => 'Hoàng Sơn',
                        'job' => 'Giám đốc'
                    ],
                    [
                        'content' => 'Chúng tôi đã sử dụng qua dịch vụ của các bạn, rất hài lòng và sẽ hợp tác tiếp',
                        'author' => 'Hoàng Sơn',
                        'job' => 'Giám đốc'
                    ],
                    [
                        'content' => 'Chúng tôi đã sử dụng qua dịch vụ của các bạn, rất hài lòng và sẽ hợp tác tiếp',
                        'author' => 'Hoàng Sơn',
                        'job' => 'Giám đốc'
                    ]
                ]
            ],
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
            ],
            [
                'id' => 'COMPANY_STATUS',
                'data_type' => SystemConfigDataType::JSON,
                'value' => [
                    [
                        'title' => 'Khách hàng',
                        'value' => '1000',
                    ],
                    [
                        'title' => 'Kho mẫu',
                        'value' => '90',
                    ],
                    [
                        'title' => 'Nhân sự',
                        'value' => '100',
                    ],
                    [
                        'title' => 'Kinh nghiệm',
                        'value' => '1000',
                    ],
                ]
            ],
            [
                'id' => 'ABOUT_TWO',
                'data_type' => SystemConfigDataType::JSON,
                'value' => [
                    [
                        'title' => 'TÍNH SẴN CÓ',
                        'description' => 'Công ty T-Tech luôn đảm bảo sẵn sàng và kịp thời giao hàng cho khách hàng từ 4 – 20 tuần kể từ ngày mua hàng, tùy thuộc loại sản phẩm.',
                        'icon' => ''
                    ],
                    [
                        'title' => 'UY TÍN HÀNG ĐẦU',
                        'value' => 'Có mặt trên thị trường hơn 5 năm qua, Công ty T-Tech là đối tác chiến lược của các Bộ, Ban ngành và công ty trên khắp 64 tỉnh thành',
                        'icon' => ''
                    ],
                    [
                        'title' => 'ĐẢM BẢO CHẤT LƯỢNG',
                        'value' => 'Để đảm bảo chất lượng của các sản phẩm, T-Tech chú trọng từng bộ phận, chi tiết qua việc sử dụng các linh kiện nhập các nước G7.',
                        'icon' => ''
                    ],
                    [
                        'title' => 'GIÁ CẢ CẠNH TRANH',
                        'value' => 'Sản phẩm được nhập khẩu và lắp ráp trực tiếp tại T-Tech, vì vậy khách hàng luôn được hưởng giá cả cạnh tranh giảm thiểu 30-50% giá xe nhập khẩu nguyên chiếc mà chất lượng không đổi.',
                        'icon' => ''
                    ],
                    [
                        'title' => 'DỊCH VỤ HẬU MÃI TỐT NHẤT',
                        'value' => 'Với đội ngũ công nhân, kỹ sư lành nghề và giàu kinh nghiệm, các sản phẩm sau khi mua của khách hàng sẽ được bảo trì và sửa chữa hoàn toàn miễn phí.',
                        'icon' => ''
                    ],
                    [
                        'title' => 'TÍNH ĐA DẠNG',
                        'value' => 'Qua hơn 5 năm nghiên cứu và phát triển, T-Tech có một danh mục sản phẩm đa dạng, đáp ứng bất kỳ nhu cầu chuyên biệt nào của khách hàng.',
                        'icon' => ''
                    ],
                ]
            ],
        ];

        foreach ($config as $c) {
            $this->configRepository->createOrEdit($c['id'], SystemConfigRequest::create('', 'POST', $c));
        }
    }
}
