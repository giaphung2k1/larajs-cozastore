<?php

return [
    'actions' => 'Actions',
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
        'name' => 'Name',
	],
     'product' => [
        'id' => 'ID',
        'name' => 'Name',
        'image' => 'Image',
        'description' => 'Description',
        'stock_in' => 'Stock in',
        'stock_out' => 'Stock out',
        'inventory' => 'Inventory',
        'price' => 'Price',
        'discount' => 'Discount',
        'status' => 'Status',
        'code' => 'Code',
	],
     'color' => [
		'id' => 'ID',
        'name' => 'Name',
	],
    'size' => [
		'id' => 'ID',
        'name' => 'Name',
	],
    'product_payment' => [
		'id' => 'ID',
        'total' => 'Total',
        'price' => 'Price',
        'note' => 'Note',
	],
    'product_reject' => [
		'id' => 'ID',
        'total' => 'Total',
        'price' => 'Price',
        'note' => 'Note',
	],
    'member' => [
		'id' => 'ID',
        'code' => 'Code',
        'name' => 'Name',
        'sns_link' => 'Sns link',
        'is_block' => 'Is block',
	],
    //{{LANG_TABLE_NOT_DELETE_THIS_LINE}}
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
