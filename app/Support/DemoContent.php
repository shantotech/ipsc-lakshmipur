<?php

namespace App\Support;

/**
 * Sample notices, events and gallery albums for the frontend build.
 *
 * TEMPORARY: these move to the database when the Notices, Events and
 * Gallery admin modules are built. Views read them through the same
 * shape, so switching over won't need a redesign.
 */
class DemoContent
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public static function notices(): array
    {
        return [
            [
                'slug' => 'admission-2027',
                'date' => '2026-09-20',
                'category' => 'admission',
                'pinned' => true,
                'title' => ['bn' => '২০২৭ শিক্ষাবর্ষে ভর্তি বিজ্ঞপ্তি', 'en' => 'Admission Notice for the 2027 Academic Year'],
                'excerpt' => [
                    'bn' => 'প্লে থেকে পঞ্চম শ্রেণি পর্যন্ত ভর্তি চলছে। আসন সংখ্যা সীমিত, আগে আসলে আগে পাবেন ভিত্তিতে ভর্তি নেওয়া হবে।',
                    'en' => 'Admission is open from Play to Class Five. Seats are limited and will be filled on a first-come, first-served basis.',
                ],
                'body' => [
                    'bn' => '<p>ইন্টারন্যাশনাল পিস স্কুল অ্যান্ড কলেজ, লক্ষ্মীপুর-এ ২০২৭ শিক্ষাবর্ষে প্লে, নার্সারি, কেজি এবং প্রথম থেকে পঞ্চম শ্রেণিতে ভর্তি চলছে।</p><p>ভর্তি ফরম স্কুল অফিস থেকে সংগ্রহ করা যাবে অথবা অনলাইনে আবেদন করা যাবে। বিস্তারিত জানতে স্কুল অফিসে যোগাযোগ করুন।</p>',
                    'en' => '<p>International Peace School & College, Lakshmipur is accepting admissions for the 2027 academic year for Play, Nursery, KG and Classes One to Five.</p><p>Application forms are available at the school office or online. Please contact the school office for details.</p>',
                ],
                'attachment' => null,
            ],
            [
                'slug' => 'teacher-recruitment',
                'date' => '2026-09-12',
                'category' => 'recruitment',
                'pinned' => false,
                'title' => ['bn' => 'শিক্ষক নিয়োগ বিজ্ঞপ্তি', 'en' => 'Teacher Recruitment Notice'],
                'excerpt' => [
                    'bn' => 'ইংরেজি, আরবি, গণিত ও বিজ্ঞান বিষয়ে যোগ্য ও অভিজ্ঞ শিক্ষক নিয়োগের জন্য দরখাস্ত আহ্বান করা হচ্ছে।',
                    'en' => 'Applications are invited from qualified and experienced teachers for English, Arabic, Mathematics and Science.',
                ],
                'body' => [
                    'bn' => '<p>জাতি গঠনে উজ্জীবিত ও শিক্ষায় নিবেদিত যোগ্য প্রার্থীদের নিকট থেকে নিম্নোক্ত পদে দরখাস্ত আহ্বান করা হচ্ছে:</p><ul><li>সহকারী শিক্ষক (ইংরেজি)</li><li>সহকারী শিক্ষক (আরবি)</li><li>সহকারী শিক্ষক (গণিত)</li><li>সহকারী শিক্ষক (বিজ্ঞান)</li></ul><p>আগ্রহী প্রার্থীদের জীবনবৃত্তান্তসহ স্কুল অফিসে আবেদন জমা দিতে বলা হলো।</p>',
                    'en' => '<p>Applications are invited from qualified candidates dedicated to education for the following posts:</p><ul><li>Assistant Teacher (English)</li><li>Assistant Teacher (Arabic)</li><li>Assistant Teacher (Mathematics)</li><li>Assistant Teacher (Science)</li></ul><p>Interested candidates should submit their CV at the school office.</p>',
                ],
                'attachment' => null,
            ],
            [
                'slug' => 'campus-opening',
                'date' => '2026-09-01',
                'category' => 'general',
                'pinned' => false,
                'title' => ['bn' => 'লক্ষ্মীপুর ক্যাম্পাসের যাত্রা শুরু', 'en' => 'Lakshmipur Campus Begins Its Journey'],
                'excerpt' => [
                    'bn' => 'ইন্টারন্যাশনাল পিস স্কুল অ্যান্ড কলেজ পরিবারের নতুন শাখা হিসেবে লক্ষ্মীপুর ক্যাম্পাসের কার্যক্রম শুরু হয়েছে।',
                    'en' => 'The Lakshmipur campus has started its activities as the newest branch of the International Peace School & College family.',
                ],
                'body' => [
                    'bn' => '<p>আলহামদুলিল্লাহ, ইন্টারন্যাশনাল পিস স্কুল অ্যান্ড কলেজ পরিবারের নতুন শাখা হিসেবে লক্ষ্মীপুর ক্যাম্পাসের কার্যক্রম শুরু হয়েছে। অভিভাবকদের ক্যাম্পাস পরিদর্শনের আমন্ত্রণ জানানো হচ্ছে।</p>',
                    'en' => '<p>Alhamdulillah, the Lakshmipur campus has started its activities as the newest branch of the International Peace School & College family. Parents are welcome to visit the campus.</p>',
                ],
                'attachment' => null,
            ],
            [
                'slug' => 'office-hours',
                'date' => '2026-08-25',
                'category' => 'general',
                'pinned' => false,
                'title' => ['bn' => 'অফিস সময়সূচি', 'en' => 'Office Hours'],
                'excerpt' => [
                    'bn' => 'ভর্তি সংক্রান্ত তথ্যের জন্য শনিবার থেকে বৃহস্পতিবার সকাল ৯টা থেকে বিকেল ৪টা পর্যন্ত অফিস খোলা থাকবে।',
                    'en' => 'For admission enquiries, the office is open Saturday to Thursday from 9 AM to 4 PM.',
                ],
                'body' => [
                    'bn' => '<p>ভর্তি সংক্রান্ত তথ্যের জন্য শনিবার থেকে বৃহস্পতিবার সকাল ৯টা থেকে বিকেল ৪টা পর্যন্ত স্কুল অফিস খোলা থাকবে। শুক্রবার সাপ্তাহিক ছুটি।</p>',
                    'en' => '<p>For admission enquiries, the school office is open Saturday to Thursday from 9 AM to 4 PM. Friday is the weekly holiday.</p>',
                ],
                'attachment' => null,
            ],
        ];
    }

    public static function notice(string $slug): ?array
    {
        return collect(self::notices())->firstWhere('slug', $slug);
    }

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
