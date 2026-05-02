<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\ComplaintAnswer;
use App\Models\ComplaintQuestion;
use App\Models\ComplaintStatus;
use App\Services\AuditLogger;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComplaintDemoSeeder extends Seeder
{
    /**
     * Realistic demo complaints for inbox / UI testing.
     * Each scenario maps to one realistic citizen complaint with
     * a distinct subject, area, and detailed description.
     */
    public function run(): void
    {
        $questions = ComplaintQuestion::query()->activeOrdered()->with('options')->get();

        if ($questions->isEmpty()) {
            return;
        }

        $sid = fn (string $name) => (int) ComplaintStatus::query()->where('name', $name)->value('id');

        $scenarios = [
            [
                'status'  => 'submitted',
                'suffix'  => 'A',
                'name'    => 'Md. Rafiqul Islam',
                'email'   => 'rafiqul.islam@example.com',
                'phone'   => '01711234501',
                'type'    => 'Local (স্থানীয়)',
                'area'    => 'Sonagazi (সোনাগাজী)',
                'address' => 'Ward 4, Munsirhat Road, Sonagazi',
                'subject' => 'Main road drainage blocked — causing flooding',
                'body'    => "The main drainage channel along Munsirhat Road has been completely blocked for over two weeks. Rainwater is accumulating on the road surface, making it impassable for pedestrians and vehicles alike.\n\nThe waterlogging is causing serious inconvenience to residents and local shopkeepers. Children walking to school are forced to wade through dirty water. There is a growing risk of waterborne disease if the blockage is not cleared urgently.\n\nI request the municipal authority to depute a maintenance team to clear the drain within 48 hours.",
                'confidential' => '0',
            ],
            [
                'status'  => 'hold',
                'suffix'  => 'B',
                'name'    => 'Fatema Begum',
                'email'   => 'fatema.begum@example.com',
                'phone'   => '01811234502',
                'type'    => 'Local (স্থানীয়)',
                'area'    => 'Daganbhuiyan (দাগনভূঞা)',
                'address' => 'Holding No. 12/B, College Road, Daganbhuiyan',
                'subject' => 'Street lights non-functional for 3 weeks',
                'body'    => "All four street lights on College Road between the high school junction and the post office have been out of order since 14 March 2026. The area becomes completely dark after 7 pm.\n\nThis has led to two motorcycle accidents and increased incidents of petty theft reported to the local police station. Women returning home from the garment factory night shift are particularly at risk.\n\nPrevious verbal complaints to the ward office have not been acted upon. I am now raising this formally and request urgent repair or temporary lighting within one week.",
                'confidential' => '1',
            ],
            [
                'status'  => 'processing',
                'suffix'  => 'C',
                'name'    => 'Abul Kalam Azad',
                'email'   => 'akalam.azad@example.com',
                'phone'   => '01911234503',
                'type'    => 'Local (স্থানীয়)',
                'area'    => 'Sonagazi (সোনাগাজী)',
                'address' => 'Village: Uttar Char, Union: Char Majlis',
                'subject' => 'Garbage not collected from residential area for 10 days',
                'body'    => "The garbage collection truck has not visited our neighbourhood for the past ten days. Waste is piling up in front of homes and at the street corner near the mosque, creating an unbearable stench and attracting stray dogs and rats.\n\nResidents have repeatedly called the sanitation helpline but received no response. One elderly resident has already fallen ill, reportedly due to the unsanitary conditions.\n\nWe urgently request immediate collection and disinfection of the affected area, followed by resumption of the regular twice-weekly schedule.",
                'confidential' => '0',
            ],
            [
                'status'  => 'processing',
                'suffix'  => 'D',
                'name'    => 'Nasrin Akter',
                'email'   => 'nasrin.akter@example.com',
                'phone'   => '01611234504',
                'type'    => 'Non-resident Bangladeshi (প্রবাসী)',
                'area'    => 'Daganbhuiyan (দাগনভূঞা)',
                'address' => 'Current: Dubai, UAE — Property: Plot 7, Bandar Bazar, Daganbhuiyan',
                'subject' => 'Birth certificate correction — wrong date of birth on record',
                'body'    => "My birth certificate (Registration No. 1985-DGN-04471) shows my date of birth as 15 January 1985, but the correct date is 22 January 1985 as evidenced by my school leaving certificate and passport.\n\nThis discrepancy is causing problems with my residence visa renewal in the UAE, and the embassy is requiring a corrected certified copy.\n\nI am currently abroad and unable to visit in person. I have attached a scanned copy of the original certificate, school records, and a notarised affidavit. Please process the correction and courier the updated certificate to the address provided by my authorised representative, Mr. Karim (contact: 01711009988).",
                'confidential' => '1',
            ],
            [
                'status'  => 'resolved',
                'suffix'  => 'E',
                'name'    => 'Jahangir Alam',
                'email'   => 'jahangir.alam@example.com',
                'phone'   => '01511234505',
                'type'    => 'Local (স্থানীয়)',
                'area'    => 'Sonagazi (সোনাগাজী)',
                'address' => 'Ward 2, Near Primary School, Sonagazi Bazar',
                'subject' => 'Water supply pipe burst — resolved after repair team visit',
                'body'    => "A main water supply pipe burst on 20 March 2026 at the intersection near the primary school. Water was gushing onto the road for over six hours, damaging the asphalt and entering adjacent shops.\n\nI filed a complaint verbally with the ward office on the same day. The repair team arrived on 22 March and completed the pipe replacement by the afternoon. Water supply was restored to the area by evening.\n\nI am satisfied with the response time and the quality of the repair. I am updating this complaint as resolved. Thank you to the maintenance team for their prompt action.",
                'confidential' => '0',
            ],
            [
                'status'  => 'unresolved',
                'suffix'  => 'F',
                'name'    => 'Kamrun Nahar',
                'email'   => 'kamrun.nahar@example.com',
                'phone'   => '01311234506',
                'type'    => 'Local (স্থানীয়)',
                'area'    => 'Daganbhuiyan (দাগনভূঞা)',
                'address' => 'Holding 45, Purba Para, Daganbhuiyan',
                'subject' => 'Encroachment on public footpath by neighbouring shop',
                'body'    => "The owner of a shop adjacent to my property has permanently extended their business structure onto the public footpath, blocking approximately 4 feet of the pedestrian walkway in front of my home.\n\nThis complaint was first filed on 1 February 2026 (reference: verbal complaint, Ward Office Daganbhuiyan). A notice was reportedly issued to the shop owner but the encroachment remains in place. The structure has since been extended further with a tin-roof awning.\n\nThe footpath is used by school children and elderly residents daily. I request formal enforcement action to demolish the encroachment and restore the footpath.",
                'confidential' => '0',
            ],
            [
                'status'  => 'reopen',
                'suffix'  => 'G',
                'name'    => 'Shahabuddin Ahmed',
                'email'   => 'shahabuddin.ahmed@example.com',
                'phone'   => '01411234507',
                'type'    => 'Local (স্থানীয়)',
                'area'    => 'Sonagazi (সোনাগাজী)',
                'address' => 'Char Majlis Road, House No. 8, Sonagazi',
                'subject' => 'Reopening: mosquito breeding in stagnant water — problem returned',
                'body'    => "This complaint was previously closed under reference CMP-2026-031 after the municipal fogging team visited on 5 March 2026. However, the problem has returned within two weeks.\n\nThe abandoned construction pit on Char Majlis Road has refilled with stagnant water and is again a breeding ground for mosquitoes. Residents in the area are experiencing a spike in fever cases. Three children from our lane have been diagnosed with dengue this week.\n\nI am formally reopening this complaint and requesting (1) immediate re-fogging of the area, (2) filling and proper drainage of the abandoned pit, and (3) a written commitment from the contractor to complete or seal the site.",
                'confidential' => '0',
            ],
            [
                'status'  => 'invalid',
                'suffix'  => 'H',
                'name'    => 'Test User',
                'email'   => 'test.user@example.com',
                'phone'   => '01211234508',
                'type'    => 'Local (স্থানীয়)',
                'area'    => 'Sonagazi (সোনাগাজী)',
                'address' => 'N/A',
                'subject' => 'Test submission — please ignore',
                'body'    => "This is a test submission created while verifying the complaint portal form. No actual complaint is being filed.\n\nPlease mark this as invalid and disregard.",
                'confidential' => '0',
            ],
        ];

        DB::transaction(function () use ($scenarios, $questions, $sid) {
            $totalScenarios = count($scenarios);
            $totalToSeed = 105;

            // Delete previous demo complaints
            Complaint::query()->where('public_reference', 'like', 'CMP-%')->delete();

            for ($i = 1; $i <= $totalToSeed; $i++) {
                $baseScenario = $scenarios[$i % $totalScenarios];
                $statusId = $sid($baseScenario['status']);
                if (! $statusId) {
                    continue;
                }

                $ref = 'CMP-' . $i;

                $complaint = Complaint::query()->create([
                    'public_reference'    => $ref,
                    'complaint_status_id' => $statusId,
                ]);

                // Create slight variations based on $i
                $created_at = now()->subDays(rand(0, 30))->subHours(rand(0, 23));
                $complaint->created_at = $created_at;
                $complaint->updated_at = $created_at;
                $complaint->save();

                foreach ($questions as $q) {
                    ComplaintAnswer::query()->create([
                        'complaint_id'            => $complaint->id,
                        'complaint_question_id'   => $q->id,
                        'value'                   => $this->answer($q, $baseScenario),
                    ]);
                }

                AuditLogger::logStatusChange($complaint, null, $statusId, null);
            }
        });
    }

    private function answer(ComplaintQuestion $q, array $s): string
    {
        return match ($q->type) {
            ComplaintQuestion::TYPE_EMAIL     => $s['email'],
            ComplaintQuestion::TYPE_PHONE     => $s['phone'],
            ComplaintQuestion::TYPE_TEXTAREA  => $s['body'],
            ComplaintQuestion::TYPE_BOOLEAN   => $s['confidential'],
            ComplaintQuestion::TYPE_FILE      => '',
            ComplaintQuestion::TYPE_SELECTION => $this->matchOption($q, $s),
            default                           => $this->matchText($q, $s),
        };
    }

    private function matchOption(ComplaintQuestion $q, array $s): string
    {
        $prompt = strtolower($q->prompt);

        if (str_contains($prompt, 'type') || str_contains($prompt, 'ধরন')) {
            return $q->options->first(fn($o) => str_contains($o->label, explode(' ', $s['type'])[0]))?->label
                ?? $s['type'];
        }

        if (str_contains($prompt, 'area') || str_contains($prompt, 'এলাকা')) {
            return $q->options->first(fn($o) => str_contains($o->label, explode(' ', $s['area'])[0]))?->label
                ?? $s['area'];
        }

        return $q->options->first()?->label ?? 'Other';
    }

    private function matchText(ComplaintQuestion $q, array $s): string
    {
        $prompt = strtolower($q->prompt);

        if (str_contains($prompt, 'name') || str_contains($prompt, 'নাম'))    return $s['name'];
        if (str_contains($prompt, 'address') || str_contains($prompt, 'ঠিকানা')) return $s['address'];
        if (str_contains($prompt, 'subject') || str_contains($prompt, 'বিষয়'))  return $s['subject'];

        return $s['name'];
    }
}
