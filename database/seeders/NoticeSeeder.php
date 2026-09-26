<?php

namespace Database\Seeders;

use App\Models\Notice;
use Illuminate\Database\Seeder;

/**
 * Example notices for local testing: php artisan db:seed --class=NoticeSeeder
 * Not run on the live site.
 */
class NoticeSeeder extends Seeder
{
    public function run(): void
    {
        $notices = array (
  0 => 
  array (
    'slug' => 'admission-2027',
    'category' => 'admission',
    'published_on' => '2026-09-20',
    'is_pinned' => true,
    'title_en' => 'Admission Notice for the 2027 Academic Year',
    'title_bn' => '২০২৭ শিক্ষাবর্ষে ভর্তি বিজ্ঞপ্তি',
    'excerpt_en' => 'Admission is open from Play to Class Five. Seats are limited and will be filled on a first-come, first-served basis.',
    'excerpt_bn' => 'প্লে থেকে পঞ্চম শ্রেণি পর্যন্ত ভর্তি চলছে। আসন সংখ্যা সীমিত, আগে আসলে আগে পাবেন ভিত্তিতে ভর্তি নেওয়া হবে।',
    'body_en' => '<p>International Peace School & College, Lakshmipur is accepting admissions for the 2027 academic year for Play, Nursery, KG and Classes One to Five.</p><p>Application forms are available at the school office or online. Please contact the school office for details.</p>',
    'body_bn' => '<p>ইন্টারন্যাশনাল পিস স্কুল অ্যান্ড কলেজ, লক্ষ্মীপুর-এ ২০২৭ শিক্ষাবর্ষে প্লে, নার্সারি, কেজি এবং প্রথম থেকে পঞ্চম শ্রেণিতে ভর্তি চলছে।</p><p>ভর্তি ফরম স্কুল অফিস থেকে সংগ্রহ করা যাবে অথবা অনলাইনে আবেদন করা যাবে। বিস্তারিত জানতে স্কুল অফিসে যোগাযোগ করুন।</p>',
  ),
  1 => 
  array (
    'slug' => 'teacher-recruitment',
    'category' => 'recruitment',
    'published_on' => '2026-09-12',
    'is_pinned' => false,
    'title_en' => 'Teacher Recruitment Notice',
    'title_bn' => 'শিক্ষক নিয়োগ বিজ্ঞপ্তি',
    'excerpt_en' => 'Applications are invited from qualified and experienced teachers for English, Arabic, Mathematics and Science.',
    'excerpt_bn' => 'ইংরেজি, আরবি, গণিত ও বিজ্ঞান বিষয়ে যোগ্য ও অভিজ্ঞ শিক্ষক নিয়োগের জন্য দরখাস্ত আহ্বান করা হচ্ছে।',
    'body_en' => '<p>Applications are invited from qualified candidates dedicated to education for the following posts:</p><ul><li>Assistant Teacher (English)</li><li>Assistant Teacher (Arabic)</li><li>Assistant Teacher (Mathematics)</li><li>Assistant Teacher (Science)</li></ul><p>Interested candidates should submit their CV at the school office.</p>',
    'body_bn' => '<p>জাতি গঠনে উজ্জীবিত ও শিক্ষায় নিবেদিত যোগ্য প্রার্থীদের নিকট থেকে নিম্নোক্ত পদে দরখাস্ত আহ্বান করা হচ্ছে:</p><ul><li>সহকারী শিক্ষক (ইংরেজি)</li><li>সহকারী শিক্ষক (আরবি)</li><li>সহকারী শিক্ষক (গণিত)</li><li>সহকারী শিক্ষক (বিজ্ঞান)</li></ul><p>আগ্রহী প্রার্থীদের জীবনবৃত্তান্তসহ স্কুল অফিসে আবেদন জমা দিতে বলা হলো।</p>',
  ),
  2 => 
  array (
    'slug' => 'campus-opening',
    'category' => 'general',
    'published_on' => '2026-09-01',
    'is_pinned' => false,
    'title_en' => 'Lakshmipur Campus Begins Its Journey',
    'title_bn' => 'লক্ষ্মীপুর ক্যাম্পাসের যাত্রা শুরু',
    'excerpt_en' => 'The Lakshmipur campus has started its activities as the newest branch of the International Peace School & College family.',
    'excerpt_bn' => 'ইন্টারন্যাশনাল পিস স্কুল অ্যান্ড কলেজ পরিবারের নতুন শাখা হিসেবে লক্ষ্মীপুর ক্যাম্পাসের কার্যক্রম শুরু হয়েছে।',
    'body_en' => '<p>Alhamdulillah, the Lakshmipur campus has started its activities as the newest branch of the International Peace School & College family. Parents are welcome to visit the campus.</p>',
    'body_bn' => '<p>আলহামদুলিল্লাহ, ইন্টারন্যাশনাল পিস স্কুল অ্যান্ড কলেজ পরিবারের নতুন শাখা হিসেবে লক্ষ্মীপুর ক্যাম্পাসের কার্যক্রম শুরু হয়েছে। অভিভাবকদের ক্যাম্পাস পরিদর্শনের আমন্ত্রণ জানানো হচ্ছে।</p>',
  ),
  3 => 
  array (
    'slug' => 'office-hours',
    'category' => 'general',
    'published_on' => '2026-08-25',
    'is_pinned' => false,
    'title_en' => 'Office Hours',
    'title_bn' => 'অফিস সময়সূচি',
    'excerpt_en' => 'For admission enquiries, the office is open Saturday to Thursday from 9 AM to 4 PM.',
    'excerpt_bn' => 'ভর্তি সংক্রান্ত তথ্যের জন্য শনিবার থেকে বৃহস্পতিবার সকাল ৯টা থেকে বিকেল ৪টা পর্যন্ত অফিস খোলা থাকবে।',
    'body_en' => '<p>For admission enquiries, the school office is open Saturday to Thursday from 9 AM to 4 PM. Friday is the weekly holiday.</p>',
    'body_bn' => '<p>ভর্তি সংক্রান্ত তথ্যের জন্য শনিবার থেকে বৃহস্পতিবার সকাল ৯টা থেকে বিকেল ৪টা পর্যন্ত স্কুল অফিস খোলা থাকবে। শুক্রবার সাপ্তাহিক ছুটি।</p>',
  ),
);

        foreach ($notices as $notice) {
            Notice::updateOrCreate(['slug' => $notice['slug']], $notice);
        }
    }
}
