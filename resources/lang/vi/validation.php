<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute phải được chấp nhận.',
    'active_url'           => ':attribute không phải URL.',
    'after'                => ':attribute phải là một ngày sau :date.',
    'after_or_equal'       => ':attribute phải sau hoặc là ngày :date.',
    'alpha'                => ':attribute chỉ có thể chứa ký tự.',
    'alpha_dash'           => ':attribute chỉ có thể chứa ký tự, chữ số và dấu gạch ngang.',
    'alpha_num'            => ':attribute chỉ có thể chứa ký tự hoặc chữ số.',
    'array'                => ':attribute phải là một mảng.',
    'before'               => ':attribute phải là một ngày trước :date.',
    'before_or_equal'      => ':attribute phải trước hoặc là ngày :date.',
    'between'              => [
        'numeric' => ':attribute phải nằm trong khoảng :min và :max.',
        'file'    => ':attribute phải nằm trong khoảng :min và :max kg.',
        'string'  => ':attribute phải có trong khoảng :min và :max ký tự.',
        'array'   => ':attribute phải có khoảng :min đến :max phần tử.',
    ],
    'boolean'              => ':attribute phải là đúng hoặc sai (true hoặc false).',
    'confirmed'            => ':attribute xác thực không chính xác.',
    'date'                 => ':attribute không phải là ngày hợp lệ.',
    'date_format'          => ':attribute không đúng định dạng :format.',
    'different'            => ':attribute và :other phải khác nhau.',
    'digits'               => ':attribute phải có :digits chữ số.',
    'digits_between'       => ':attribute phải có từ :min đến :max chữ số.',
    'dimensions'           => ':attribute có kích cỡ ảnh không hợp lệ.',
    'distinct'             => ':attribute đã bị lặp.',
    'email'                => ':attribute phải là email.',
    'exists'               => ':attribute không tồn tại.',
    'file'                 => ':attribute phải là file.',
    'filled'               => ':attribute phải có giá trị.',
    'image'                => ':attribute phải là ảnh.',
    'in'                   => ':attribute đã chọn không hợp lệ.',
    'in_array'             => ':attribute không thuộc :other.',
    'integer'              => ':attribute phải là số nguyên.',
    'ip'                   => ':attribute phải là địa chỉ IP.',
    'ipv4'                 => ':attribute phải là địa chỉ IPV4.',
    'ipv6'                 => ':attribute phải là địa chỉ IPV6.',
    'json'                 => ':attribute phải là một đoạn JSON string.',
    'max'                  => [
        'numeric' => ':attribute không thể lớn hơn :max.',
        'file'    => ':attribute không thể lớn hơn :max kg.',
        'string'  => ':attribute không thể lớn hơn :max ký tự.',
        'array'   => ':attribute không thể có nhiều hơn :max phần tử.',
    ],
    'mimes'                => ':attribute phải là file có kiểu: :values.',
    'mimetypes'            => ':attribute phải là file có kiểu: :values.',
    'min'                  => [
        'numeric' => ':attribute phải lớn hơn :min.',
        'file'    => ':attribute phải lớn hơn :min kg.',
        'string'  => ':attribute phải lớn hơn :min ký tự.',
        'array'   => ':attribute phải có ít nhất :min phần tử.',
    ],
    'not_in'               => ':attribute đã chọn không hợp lệ.',
    'numeric'              => ':attribute phải là số.',
    'present'              => ':attribute phải là hiện tại.',
    'regex'                => ':attribute không đúng định dạng.',
    'required'             => ':attribute không được để trống.',
    'required_if'          => ':attribute không được để trống khi :other là :value.',
    'required_unless'      => ':attribute không được để trống cho đến khi :other thuộc :values.',
    'required_with'        => ':attribute không được để trống khi :values là hiện tại.',
    'required_with_all'    => ':attribute không được để trống khi :values là hiện tại.',
    'required_without'     => ':attribute không được để trống khi :values không phải hiện tại.',
    'required_without_all' => ':attribute không được để trống khi :values không có phần tử nào là hiện tại.',
    'same'                 => ':attribute và :other phải trùng khớp.',
    'size'                 => [
        'numeric' => ':attribute phải là :size.',
        'file'    => ':attribute phải là :size kg.',
        'string'  => ':attribute phải có :size ký tự.',
        'array'   => ':attribute phải có :size phần tử.',
    ],
    'string'               => ':attribute phải là dạng chuỗi.',
    'timezone'             => ':attribute phải là múi giờ đúng.',
    'unique'               => ':attribute đã bị sử dụng trước đó.',
    'uploaded'             => ':attribute đã tải lên thất bại.',
    'url'                  => ':attribute sai định dạng.',
    'gtemls'                  => ':attribute phải sau :origin ít nhất :extra giờ',
    'ltemls'                  => ':attribute phải trước :origin ít nhất :extra giờ',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'from_mls' => [
            'min' => ':attribute phải sau hiện tại'
        ],
        'to_mls' => [
            'min' => ':attribute phải sau hiện tại'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'situation' => 'Tình trạng',
        'name' => 'Tên',
        'price' => 'Giá',
        'description' => 'Mô tả',
        'brand_id' => 'Nhãn hiệu',
        'category_id' => 'Danh mục',
        'customer_type_id' => 'Phân loại',
        'size_ids' => 'Kích cỡ',
        'color_ids' => 'Màu sắc',
        'images' => 'Ảnh',
        'phone_number' => 'Số điện thoại',
        'province_id' => 'Tỉnh',
        'district_id' => 'Quận/Huyện',
        'address' => 'Địa chỉ',
        'expired_at' => 'Thời gian hết hạn',
        'start_at' => 'Thời gian bắt đầu',
        'event_type' => 'Loại sự kiện',
        'bank_name' => 'Tên ngân hàng',
        'bank_id' => 'Số tài khoản',
        'owner_name' => 'Tên chủ tài khoản',
        'bank_branch' => 'Chi nhánh ngân hàng',
        'from_mls' => 'Thời gian bắt đầu',
        'to_mls' => 'Thời gian kết thúc',
        'reason' => 'Lý do',
        'value_original' => 'Số tiền nạp'
    ],

];
