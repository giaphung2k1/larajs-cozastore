<?php

return [
    'actions' => 'Hành động',
    'user' => [
        'id' => 'STT',
        'name' => 'Tên',
        'email' => 'Email',
        'avatar' => 'Ảnh đại diện',
        'role' => 'Quyền',
        'password' => 'Mật khẩu',
        'password_confirmation' => 'Xác nhận mật khẩu',
    ],
    'rolePermission' => [
        'id' => 'No.',
        'name' => 'Tên',
        'description' => 'Miêu tả',
    ],
    'category' => [
		'id' => 'ID',
        'name' => 'Tên',
	],
     'product' => [
        'id' => 'ID',
        'name' => 'Tên',
        'image' => 'Hình ảnh',
        'description' => 'Mô tả',
        'stock_in' => 'Hàng vào',
        'stock_out' => 'Hàng ra',
        'inventory' => 'Tồn kho',
        'price' => 'Giá',
        'discount' => 'Giảm giá',
        'status' => 'Trạng thái',
        'code' => 'Mã',
	],
     'color' => [
		'id' => 'ID',
        'name' => 'Tên',
	],
    'size' => [
		'id' => 'ID',
        'name' => 'Tên',
	],
    'product_payment' => [
		'id' => 'ID',
        'total' => 'Số lượng',
        'price' => 'Giá',
        'note' => 'Ghi chú',
        'total_sold' => 'Tổng tiền',
        'reason' => 'Lý do'
	],
    'product_reject' => [
		'id' => 'ID',
        'total' => 'Số lượng',
        'price' => 'Giá',
        'note' => 'Ghi chú',
	],
      'member' => [
        'id' => 'ID',
        'code' => 'Mã',
        'name' => 'Tên',
        'sns_link' => 'MXH(link)',
        'is_block' => 'Khóa',
        'phone' => 'SĐT',
        'amount' => 'Số lượng mua',
	],
    'product_detail' => [
        'id'=>"ID",
        'price' => 'Giá',
        'amount' => 'Số lượng'
    ],
    'texts' => [
        'count' => 'Hiển thị {from} đến {to} trong số {count} dữ liệu|{count} dữ liệu|Một dữ liệu',
        'first' => 'Đầu',
        'last' => 'Cuối',
        'filter' => 'Bộ lọc:',
        'filterPlaceholder' => 'Tìm kiếm...',
        'limit' => 'Giới hạn:',
        'page' => 'Trang:',
        'noResults' => 'Không có dữ liệu phù hợp',
        'filterBy' => 'Lọc bởi {column}',
        'loading' => 'Chờ đợi...',
        'defaultOption' => 'Chọn {column}',
        'columns' => 'Cột',
    ],
];
