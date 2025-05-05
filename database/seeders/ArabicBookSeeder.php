<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class ArabicBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arabicBooks = [
            [
                'B_title' => 'ألف ليلة وليلة',
                'B_Author' => 'مؤلف مجهول',
                'language' => 'Arabic',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'قواعد اللغة العربية',
                'B_Author' => 'حفني ناصف',
                'language' => 'Arabic',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'مقدمة ابن خلدون',
                'B_Author' => 'ابن خلدون',
                'language' => 'Arabic',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'كليلة ودمنة',
                'B_Author' => 'ابن المقفع',
                'language' => 'Arabic',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'البخلاء',
                'B_Author' => 'الجاحظ',
                'language' => 'Arabic',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'أساسيات البرمجة',
                'B_Author' => 'أحمد محمد',
                'language' => 'Arabic',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ],
            [
                'B_title' => 'الذكاء الاصطناعي للمبتدئين',
                'B_Author' => 'سارة عبد الرحمن',
                'language' => 'Arabic',
                'AddBy' => 'admin',
                'DateAdd' => now(),
            ]
        ];

        foreach ($arabicBooks as $book) {
            Book::create($book);
        }
    }
}
