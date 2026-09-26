<?php

namespace App\Support;

/**
 * Sample events for the frontend build.
 *
 * TEMPORARY: these move to the database when the Events module is built.
 * (Notices and the gallery already live in the database.) Views read them through the same
 * shape, so switching over won't need a redesign.
 */
class DemoContent
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function events(): array
    {
        return [
            [
                'date' => '2026-10-10',
                'time' => ['bn' => 'সকাল ১০টা', 'en' => '10:00 AM'],
                'title' => ['bn' => 'অভিভাবক পরিচিতি সভা', 'en' => 'Parents\' Orientation Meeting'],
                'place' => ['bn' => 'স্কুল মিলনায়তন', 'en' => 'School Auditorium'],
            ],
            [
                'date' => '2026-11-05',
                'time' => ['bn' => 'সকাল ৯টা', 'en' => '9:00 AM'],
                'title' => ['bn' => 'ভর্তি পরীক্ষা (প্রথম ধাপ)', 'en' => 'Admission Test (First Round)'],
                'place' => ['bn' => 'লক্ষ্মীপুর ক্যাম্পাস', 'en' => 'Lakshmipur Campus'],
            ],
            [
                'date' => '2027-01-01',
                'time' => ['bn' => 'সকাল ৮টা', 'en' => '8:00 AM'],
                'title' => ['bn' => 'নতুন শিক্ষাবর্ষের ক্লাস শুরু', 'en' => 'New Academic Year Begins'],
                'place' => ['bn' => 'লক্ষ্মীপুর ক্যাম্পাস', 'en' => 'Lakshmipur Campus'],
            ],
        ];
    }
}
