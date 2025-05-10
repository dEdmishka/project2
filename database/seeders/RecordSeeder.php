<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\Patient;
use App\Models\Record;
use App\Models\RecordType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();

        foreach ($patients as $patient) {
            $recordType = RecordType::where('type', 'Medical Card')->firstOrFail();
            $record = $patient->records()->firstOrCreate(
                [
                    'record_type_id' => $recordType->id,
                ],
                [
                    'content' => 'Uploaded medical card file',
                ]
            );
            foreach ($record->documents as $document) {
                Storage::disk('public')->delete($document->file_path);
                $document->delete();
            }
            $fileName = $patient->user->first_name . '-' . $patient->user->last_name . '-' . $patient->id . '.pdf';
            $filePath = 'documents/medical_cards/' . $fileName;
            Storage::disk('public')->put($filePath, file_get_contents(storage_path('app/public/documents/samples/card_sample.pdf'), 'public'));
            $document = new Document([
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => 'application/pdf',
                'is_private' => false,
            ]);
            $record->documents()->save($document);

            $recordType = RecordType::where('type', 'Intake Summary')->firstOrFail();
            $record = $patient->records()->firstOrCreate(
                [
                    'record_type_id' => $recordType->id,
                ],
                [
                    'content' => 'Uploaded intake summary file',
                ]
            );
            foreach ($record->documents as $document) {
                Storage::disk('public')->delete($document->file_path);
                $document->delete();
            }
            $fileName = $patient->user->first_name . '-' . $patient->user->last_name . '-' . $patient->id . '.pdf';
            $filePath = 'documents/intake_summaries/' . $fileName;
            Storage::disk('public')->put($filePath, file_get_contents(storage_path('app/public/documents/samples/intake_sample.pdf'), 'public'));
            $document = new Document([
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => 'application/pdf',
                'is_private' => false,
            ]);
            $record->documents()->save($document);
        }
    }
}
