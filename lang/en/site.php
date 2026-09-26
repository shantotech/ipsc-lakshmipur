<?php

/*
|--------------------------------------------------------------------------
| Site content (English)
|--------------------------------------------------------------------------
| Page content for the public website. Keep the structure identical to
| lang/bn/site.php. This moves into the admin panel (database) later.
| Items marked PLACEHOLDER must be replaced with the school's real details.
*/

return [

    'school' => [
        'name' => 'International Peace School & College',
        'branch' => 'Lakshmipur',
        'full_name' => 'International Peace School & College, Lakshmipur',
        'short' => 'IPSC Lakshmipur',
        'tagline' => 'A Trilingual Caring Education',
        'version' => 'English Version Islamic School',
        'address' => 'Lakshmipur Sadar, Lakshmipur', // PLACEHOLDER: full street address
        'phone' => '+880 1XXX-XXXXXX', // PLACEHOLDER
        'email' => 'info@ipsclakshmipur.edu.bd', // PLACEHOLDER
        'office_hours' => 'Saturday – Thursday, 9:00 AM – 4:00 PM',
        'facebook' => '#', // PLACEHOLDER
        'youtube' => '#', // PLACEHOLDER
    ],

    'meta' => [
        'description' => 'International Peace School & College, Lakshmipur: a trilingual (English, Arabic, Bangla) English-version Islamic school following the National Curriculum.',
    ],

    'announcement' => [
        'id' => 'admission-2027',
        'text' => 'Admission is open for the 2027 academic year (Play to Class Five).',
        'link_label' => 'Apply now',
    ],

    'hero' => [
        'eyebrow' => 'Now open in Lakshmipur',
        'title' => 'Knowledge, character and faith — nurtured together.',
        'text' => 'An English-version Islamic school where children learn in three languages, follow the National Curriculum, and grow up with care, confidence and good character.',
        'primary' => 'Apply for admission',
        'secondary' => 'Discover our school',
        'stats' => [
            ['value' => '3', 'label' => 'Languages: English, Arabic, Bangla'],
            ['value' => 'Play–5', 'label' => 'Classes enrolling for 2027'],
            ['value' => 'NCTB', 'label' => 'National Curriculum, English version'],
        ],
    ],

    'features' => [
        [
            'icon' => 'languages',
            'title' => 'Trilingual Education',
            'text' => 'Equal proficiency in three languages: English, Arabic and Bangla.',
        ],
        [
            'icon' => 'heart-handshake',
            'title' => 'Caring Service',
            'text' => 'Child psychologists, nutrition specialists and doctors support every child\'s physical and mental growth.',
        ],
        [
            'icon' => 'moon-star',
            'title' => 'Quranul Karim',
            'text' => 'Learn to recite the Quran correctly and memorise the equivalent of three paras, including Amma para.',
        ],
        [
            'icon' => 'graduation-cap',
            'title' => 'Curriculum & Version',
            'text' => 'The National Curriculum in English version, keeping our own and national identity strong.',
        ],
    ],

    'about' => [
        'title' => 'About Our School',
        'lead' => 'True knowledge leads us towards kindness, charity and compassion for all people. Through it a person gains high morals, spiritual dignity and nobility.',
        'body' => [
            'International Peace School & College brings a new approach to education in Bangladesh. It provides quality education and facilities to raise a new generation of modern, capable people guided by the teachings of Islam.',
            'Our students learn to meet the challenges and opportunities of life with confidence, care and competence, and to become leaders for the nation. The Lakshmipur campus brings this same education and care to the families of Lakshmipur.',
        ],
        'mission_title' => 'Our Mission',
        'mission' => 'To inspire lifelong learning and develop future leaders who combine modern knowledge with strong Islamic values.',
        'vision_title' => 'Our Vision',
        'vision' => 'A generation of confident, caring and competent people who serve their families, their community and the nation.',
        'values_title' => 'What we stand for',
        'values' => [
            ['icon' => 'book-open', 'title' => 'Quality learning', 'text' => 'Strong foundations in language, mathematics and science through active, joyful teaching.'],
            ['icon' => 'moon-star', 'title' => 'Islamic values', 'text' => 'Daily practice of good manners, honesty and prayer, taught with love and example.'],
            ['icon' => 'heart-handshake', 'title' => 'Care for every child', 'text' => 'Small classes and attentive teachers who know each child by name.'],
            ['icon' => 'shield', 'title' => 'Safe environment', 'text' => 'A secure campus with trained staff, CCTV and supervised arrival and dismissal.'],
        ],
    ],

    'messages' => [
        'chairman' => [
            'title' => 'Chairman\'s Message',
            'name' => 'Chairman', // PLACEHOLDER: name
            'role' => 'Chairman, International Peace School & College',
            'body' => [ // PLACEHOLDER: replace with the chairman's own message
                'Assalamu alaikum. Education is the foundation on which a nation is built. At International Peace School & College we believe that a child needs both modern knowledge and strong moral values to succeed in this world and the next.',
                'With the opening of our Lakshmipur campus, we are bringing the same trilingual, caring education that families trust in our other branches. I invite you to visit us and see how our children learn, pray and grow together.',
            ],
        ],
        'principal' => [
            'title' => 'Principal\'s Message',
            'name' => 'Principal', // PLACEHOLDER: name
            'role' => 'Principal, IPSC Lakshmipur',
            'body' => [ // PLACEHOLDER: replace with the principal's own message
                'Assalamu alaikum and welcome. Every child who walks through our gate is a trust from Allah and from their parents. Our teachers take that trust seriously, in every lesson and every interaction.',
                'We work closely with parents so that what children learn at school continues at home. Our doors are always open. Please come and talk to us about your child.',
            ],
        ],
    ],

    'academic' => [
        'title' => 'Academic Programme',
        'intro' => 'We follow the National Curriculum and Textbook Board (NCTB) syllabus in English version, enriched with Arabic, Quran and Islamic studies.',
        'levels_title' => 'Classes',
        'levels' => [
            ['name' => 'Early Years', 'classes' => 'Play, Nursery, KG', 'text' => 'Learning through play, stories and activities. Reading readiness in English, Arabic and Bangla.'],
            ['name' => 'Primary', 'classes' => 'Class One – Five', 'text' => 'Strong foundations in language, mathematics and science, with regular Quran and Arabic lessons.'],
            ['name' => 'Secondary', 'classes' => 'Class Six onwards', 'text' => 'Will open class by class as our first students move up.'],
        ],
        'method_title' => 'How we teach',
        'method' => [
            'Small classes so every child gets attention',
            'Activity-based learning with smart classrooms',
            'Regular assessment and parent feedback',
            'Daily Quran recitation and Islamic manners',
            'Spoken English and Arabic practice every day',
            'Co-curricular activities: art, sports, debate and science fairs',
        ],
        'subjects_title' => 'Subjects',
        'subjects' => ['English', 'Bangla', 'Arabic', 'Mathematics', 'Science', 'Bangladesh & Global Studies', 'Islamic Studies', 'Quran', 'ICT', 'Art & Craft', 'Physical Education'],
    ],

    'school_hours' => [
        'title' => 'School Hours',
        'intro' => 'The school week runs from Saturday to Thursday. Friday is the weekly holiday.', // PLACEHOLDER: confirm timings
        'rows' => [
            ['group' => 'Play – KG', 'days' => 'Saturday – Thursday', 'time' => '8:00 AM – 11:30 AM'],
            ['group' => 'Class One – Two', 'days' => 'Saturday – Thursday', 'time' => '8:00 AM – 12:30 PM'],
            ['group' => 'Class Three – Five', 'days' => 'Saturday – Thursday', 'time' => '8:00 AM – 1:30 PM'],
            ['group' => 'School office', 'days' => 'Saturday – Thursday', 'time' => '9:00 AM – 4:00 PM'],
        ],
        'notes' => [
            'Students should arrive 10 minutes before the first bell.',
            'Timings may change during Ramadan and examinations; notices will be published in advance.',
        ],
    ],

    'uniform' => [
        'title' => 'School Uniform',
        'intro' => 'A neat uniform builds discipline and a sense of belonging. Uniforms are available from the school\'s approved supplier.', // PLACEHOLDER: confirm details
        'groups' => [
            ['name' => 'Boys', 'items' => ['White panjabi / shirt with school logo', 'Green trousers', 'White tupi (cap)', 'Black shoes with white socks']],
            ['name' => 'Girls', 'items' => ['White kameez with school logo', 'Green salwar', 'Green hijab / scarf', 'Black shoes with white socks']],
            ['name' => 'Sports day', 'items' => ['School sports T-shirt', 'Green track pants', 'White sports shoes']],
        ],
    ],

    'calendar' => [
        'title' => 'Academic Calendar',
        'intro' => 'Important dates for the academic year. The full calendar and holiday list will be published before the session starts.',
        'holidays_title' => 'Main holidays',
        'holidays' => [ // PLACEHOLDER: confirm with the official holiday list
            ['name' => 'International Mother Language Day', 'date' => '21 February'],
            ['name' => 'Independence Day', 'date' => '26 March'],
            ['name' => 'Eid ul-Fitr', 'date' => 'According to the moon'],
            ['name' => 'Eid ul-Adha', 'date' => 'According to the moon'],
            ['name' => 'Victory Day', 'date' => '16 December'],
        ],
    ],

    'facilities' => [
        'title' => 'Facilities',
        'intro' => 'A safe, modern campus designed around how children learn best.',
        'items' => [
            ['icon' => 'monitor', 'title' => 'Smart classrooms', 'text' => 'Bright classrooms with multimedia displays to make lessons interactive.'],
            ['icon' => 'library', 'title' => 'Library', 'text' => 'Books in English, Bangla and Arabic, with a reading corner for young readers.'],
            ['icon' => 'flask', 'title' => 'Science lab', 'text' => 'Hands-on experiments that turn science lessons into discovery.'],
            ['icon' => 'moon-star', 'title' => 'Prayer room', 'text' => 'A clean, dedicated space for daily prayers, with separate arrangements for girls.'],
            ['icon' => 'trophy', 'title' => 'Playground', 'text' => 'Space for sports, games and physical education every week.'],
            ['icon' => 'shield', 'title' => 'Safety & security', 'text' => 'CCTV, trained guards and a supervised gate for arrival and dismissal.'],
            ['icon' => 'bus', 'title' => 'Transport', 'text' => 'School transport on selected routes across Lakshmipur town.'],
            ['icon' => 'heart-handshake', 'title' => 'Health care', 'text' => 'Regular health check-ups and first aid on campus.'],
        ],
    ],

    'administration' => [
        'title' => 'Administration',
        'intro' => 'The school is guided by an experienced advisory council and managed by a dedicated governing body.',
        'groups' => [ // PLACEHOLDER: real names and photos
            ['name' => 'Advisory Council', 'people' => [
                ['name' => 'Member name', 'role' => 'Chief Adviser'],
                ['name' => 'Member name', 'role' => 'Adviser'],
                ['name' => 'Member name', 'role' => 'Adviser'],
            ]],
            ['name' => 'Governing Body', 'people' => [
                ['name' => 'Member name', 'role' => 'Chairman'],
                ['name' => 'Member name', 'role' => 'Principal'],
                ['name' => 'Member name', 'role' => 'Vice Principal'],
                ['name' => 'Member name', 'role' => 'Member'],
            ]],
        ],
    ],

    'rules' => [
        'title' => 'Rules & Regulations',
        'intro' => 'These rules help keep our school a safe, respectful place to learn. Parents are requested to go through them with their children.',
        'sections' => [
            ['title' => 'Attendance', 'items' => [
                'Students must attend regularly and on time.',
                'An application signed by a guardian is required for any absence.',
                'Students may leave during school hours only with a guardian and the office\'s permission.',
            ]],
            ['title' => 'Discipline & manners', 'items' => [
                'Students must wear the full school uniform every day.',
                'Respect for teachers, staff and fellow students is expected at all times.',
                'Mobile phones and electronic devices are not allowed without permission.',
            ]],
            ['title' => 'Fees', 'items' => [
                'Monthly tuition fees must be paid by the 10th of each month.',
                'Fees once paid are not refundable.',
            ]],
            ['title' => 'Parents', 'items' => [
                'Parents should attend parent–teacher meetings.',
                'Please inform the office of any change in address or phone number.',
            ]],
        ],
    ],

    'admission' => [
        'title' => 'Admission',
        'intro' => 'Admission is open for the 2027 academic year. We welcome families who want a caring, trilingual education for their children.',
        'steps_title' => 'How to apply',
        'steps' => [
            ['title' => 'Apply', 'text' => 'Fill in the online form or collect a form from the school office.'],
            ['title' => 'Visit', 'text' => 'Bring your child to meet our teachers and see the campus.'],
            ['title' => 'Assessment', 'text' => 'A short, friendly assessment for Class One and above.'],
            ['title' => 'Enrol', 'text' => 'Submit documents and pay the admission fee to confirm the seat.'],
        ],
        'ages_title' => 'Age requirements',
        'ages_note' => 'Age on 1 January of the admission year.',
        'ages' => [
            ['class' => 'Play', 'age' => '3+ years'],
            ['class' => 'Nursery', 'age' => '4+ years'],
            ['class' => 'KG', 'age' => '5+ years'],
            ['class' => 'Class One', 'age' => '6+ years'],
            ['class' => 'Class Two – Five', 'age' => 'Based on the previous class result'],
        ],
        'documents_title' => 'Documents needed',
        'documents' => [
            'Online birth registration certificate of the student',
            'Four recent passport-size photos of the student',
            'Copies of both parents\' National ID cards',
            'Transfer certificate and last result card (Class Two and above)',
        ],
        'cta_title' => 'Ready to apply?',
        'cta_text' => 'Apply online in a few minutes, or call the school office and we will help you.',
    ],

    'careers' => [
        'title' => 'Careers',
        'intro' => 'Join a team that is building a new kind of school. We look for teachers and staff who love children, value good character and want to keep learning.',
        'why_title' => 'Why work with us',
        'why' => [
            'A respectful, Islamic working environment',
            'Regular training and professional development',
            'Part of a growing network of schools across Bangladesh',
            'Competitive salary and festival bonuses',
        ],
        'apply_text' => 'Send your CV and a short cover letter to the school office or by email.',
    ],

    'contact' => [
        'title' => 'Contact Us',
        'intro' => 'Have a question about admission or anything else? Call, email or send us a message and we will get back to you.',
        'map_query' => 'Lakshmipur, Bangladesh', // PLACEHOLDER: exact campus location
    ],
];
