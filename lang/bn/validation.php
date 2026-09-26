<?php

// Bangla validation messages for the public forms (admission and contact).

return [
    'required' => ':attribute পূরণ করা আবশ্যক।',
    'string' => ':attribute অবশ্যই লেখা হতে হবে।',
    'email' => ':attribute একটি সঠিক ইমেইল ঠিকানা হতে হবে।',
    'date' => ':attribute একটি সঠিক তারিখ হতে হবে।',
    'before' => ':attribute অবশ্যই :date-এর আগের তারিখ হতে হবে।',
    'in' => 'নির্বাচিত :attribute সঠিক নয়।',
    'max' => [
        'string' => ':attribute :max অক্ষরের বেশি হতে পারবে না।',
        'numeric' => ':attribute :max-এর বেশি হতে পারবে না।',
    ],

    'attributes' => [
        'student_name' => 'শিক্ষার্থীর নাম',
        'date_of_birth' => 'জন্ম তারিখ',
        'gender' => 'লিঙ্গ',
        'class' => 'শ্রেণি',
        'guardian_name' => 'অভিভাবকের নাম',
        'phone' => 'মোবাইল নম্বর',
        'email' => 'ইমেইল',
        'address' => 'ঠিকানা',
        'previous_school' => 'পূর্ববর্তী স্কুল',
        'name' => 'নাম',
        'subject' => 'বিষয়',
        'message' => 'বার্তা',
    ],

    'values' => [
        'date_of_birth' => [
            'today' => 'আজ',
        ],
    ],
];
