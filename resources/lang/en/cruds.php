<?php

return [
    'userManagement' => [
        'title'          => 'Manajemen',
        'title_singular' => 'Manajemen',
    ],
    'permission'     => [
        'title'          => 'Izin',
        'title_singular' => 'Izin',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Peran',
        'title_singular' => 'Peran',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Pengguna',
        'title_singular' => 'Pengguna',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Nama',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
            'class'                    => 'Class',
            'class_helper'             => '',
        ],
    ],
    'lesson'         => [
        'title'          => 'Pelajaran',
        'title_singular' => 'Pelajaran',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'teacher'           => 'Guru',
            'teacher_helper'    => '',
            'weekday'           => 'Hari',
            'weekday_helper'    => '',
            'start_time'        => 'Jam Mulai',
            'start_time_helper' => '',
            'end_time'          => 'Jam Berakhir',
            'end_time_helper'   => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
            'class'             => 'Kelas',
            'class_helper'      => '',
        ],
    ],
    'schoolClass'    => [
        'title'          => 'Kelas',
        'title_singular' => 'Kelas',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Kelas',
            'name_helper'       => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'konten'        => [
        'title'         => 'Konten Pembelajaran',
        'fields'        => [
            'id'        => 'ID',
            'desc'      => 'Deskripsi',
            'desc_helper' => '',
            

        ],

    ],

    'siswa'         => [
        'title'         => 'Siswa',
        'fields'        => [
            'id'            => 'ID',
            'nis'           => 'NIS',
            'named'          => 'Nama',
            'gender'        => 'Jenis Kelamin',
            'phone_number'  => 'Nomor WA Ortu',
            'address'       => 'Alamat',
            'class_id'      => 'Kelas',

        ],
    ],

    'manage_class'      =>[
        'title'         => 'Kelola Kelas',
        'fields'        => [
            'id'        => 'ID',
            'about'     => 'Catatan',
            'class_id'  => 'Kelas',
        ]
    ]
];
