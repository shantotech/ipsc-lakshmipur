<?php

namespace App\Support;

/**
 * Sample events and gallery photos for the frontend build.
 *
 * TEMPORARY: these move to the database when the Events and Gallery
 * admin modules are built. (Notices already live in the database.) Views read them through the same
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

    /**
     * Gallery photos. `tone` picks the placeholder colour until real photos are uploaded.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function gallery(): array
    {
        $items = [
            ['album' => 'campus', 'tone' => 'brand', 'icon' => 'building', 'caption' => ['bn' => 'ক্যাম্পাস', 'en' => 'Campus']],
            ['album' => 'classroom', 'tone' => 'gold', 'icon' => 'monitor', 'caption' => ['bn' => 'স্মার্ট শ্রেণিকক্ষ', 'en' => 'Smart classroom']],
            ['album' => 'events', 'tone' => 'blue', 'icon' => 'users', 'caption' => ['bn' => 'অভিভাবক সভা', 'en' => 'Parents\' meeting']],
            ['album' => 'classroom', 'tone' => 'brand', 'icon' => 'book-open', 'caption' => ['bn' => 'লাইব্রেরি', 'en' => 'Library']],
            ['album' => 'campus', 'tone' => 'gold', 'icon' => 'trophy', 'caption' => ['bn' => 'খেলার মাঠ', 'en' => 'Playground']],
            ['album' => 'events', 'tone' => 'red', 'icon' => 'star', 'caption' => ['bn' => 'উদ্বোধনী অনুষ্ঠান', 'en' => 'Opening ceremony']],
            ['album' => 'classroom', 'tone' => 'blue', 'icon' => 'flask', 'caption' => ['bn' => 'বিজ্ঞান গবেষণাগার', 'en' => 'Science lab']],
            ['album' => 'campus', 'tone' => 'brand', 'icon' => 'moon-star', 'caption' => ['bn' => 'নামাজের স্থান', 'en' => 'Prayer room']],
        ];

        return $items;
    }
}
