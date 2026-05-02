<?php

namespace Database\Seeders;

use App\Models\ComplaintQuestion;
use App\Models\ComplaintQuestionOption;
use Illuminate\Database\Seeder;

class ComplaintQuestionSeeder extends Seeder
{
    /**
     * Fields aligned with https://complaint.aamintoo.com/complaint/new (Frappe Web Form "Complaint").
     */
    public function run(): void
    {
        ComplaintQuestion::query()->whereIn('prompt', [
            'Full name',
            'Email',
            'Mobile number',
            'Write your complaint in detail',
            'Category',
        ])->delete();

        $sort = 10;

        ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'Name(নাম)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_TEXT,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        $sort += 10;

        ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'e-mail(ইমেইল)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_EMAIL,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        $sort += 10;

        $typeQ = ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'Type(ধরন)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_SELECTION,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        $sort += 10;
        foreach (['Local (স্থানীয়)', 'Non-resident Bangladeshi (প্রবাসী)'] as $i => $label) {
            ComplaintQuestionOption::query()->firstOrCreate(
                ['complaint_question_id' => $typeQ->id, 'label' => $label],
                ['sort_order' => ($i + 1) * 10]
            );
        }

        ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'Mobile Number(মোবাইল নম্বর)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_PHONE,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        $sort += 10;

        $areaQ = ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'Area(এলাকা)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_SELECTION,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        $sort += 10;
        foreach (['Srimangal (শ্রীমঙ্গল)', 'Kamalganj (কমলগঞ্জ)'] as $i => $label) {
            ComplaintQuestionOption::query()->firstOrCreate(
                ['complaint_question_id' => $areaQ->id, 'label' => $label],
                ['sort_order' => ($i + 1) * 10]
            );
        }

        ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'Address(ঠিকানা)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_TEXT,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        $sort += 10;

        ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'Complaint or Feedback subject (অভিযোগ/মতামতের বিষয়)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_TEXT,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        $sort += 10;

        ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'Details of Complaint/Feedback (অভিযোগ/মতামতের বিস্তারিত)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_TEXTAREA,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        $sort += 10;

        ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'Evidence(প্রমাণ)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_FILE,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );
        ComplaintQuestion::query()->updateOrCreate(
            ['prompt' => 'I request that my personal information remain confidential (আমার ব্যক্তিগত তথ্য গোপন রাখার অনুরোধ করছি)'],
            [
                'prompt_bn' => null,
                'type' => ComplaintQuestion::TYPE_BOOLEAN,
                'allow_multiple' => false,
                'sort_order' => $sort,
                'is_active' => true,
            ]
        );


    }
}
