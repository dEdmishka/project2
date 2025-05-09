<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Center;
use App\Models\Document;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\Record;
use App\Models\RecordType;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DocumentController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('image');

        if ($user->is_staff) {
            $staffId = $user->staff->id;
            $centerId = $user->staff->center_id;

            $patients = Patient::with([
                'appointments',
                'user',
            ])->where('center_id', $centerId)
                ->whereHas('appointments', function ($query) use ($staffId) {
                    $query->whereHas('staff', function ($q) use ($staffId) {
                        $q->where('staff.id', $staffId);
                    });
                })
                ->get();

            // dd($patients);

            $patients = $patients->map(function ($item) {
                return [
                    'id' => $item->id,
                    'first_name' => $item->user->first_name,
                    'last_name' => $item->user->last_name,
                    'email' => $item->user->email,
                    'birth_date' => $item->birth_date,
                    'address' => $item->address,
                    'gender' => $item->gender,
                    'status' => $item->status,
                    'phones' => $item->phone_numbers,
                    'social_links' => $item->social_links,
                ];
            });

            return Inertia::render('Account/Staff/Document/Index', [
                'user' => $user,
                'data' => $patients,
                'main_url' => route('account.document'),
            ]);
        }

        if ($user->is_patient) {
            $patientId = $user->patient->id;
            $centerId = $user->patient->center_id;

            $patients = Patient::with([
                'appointments',
                'user',
            ])->where('center_id', $centerId)->get();

            // dd($patients);

            $patients = $patients->map(function ($item) {
                return [
                    'id' => $item->id,
                    'first_name' => $item->user->first_name,
                    'last_name' => $item->user->last_name,
                    'email' => $item->user->email,
                    'birth_date' => $item->birth_date,
                    'address' => $item->address,
                    'gender' => $item->gender,
                    'status' => $item->status,
                    'phones' => $item->phone_numbers,
                    'social_links' => $item->social_links,
                ];
            });

            return Inertia::render('Account/Staff/Document/Index', [
                'user' => $user,
                'data' => $patients,
                'main_url' => route('account.document'),
            ]);
        }

        return redirect()->back();
    }

    public function medcard()
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient) {
            $patientId = $user->patient->id;

            $patient = Patient::with([
                'user',
                'records.documents',
                'records' => function ($query) {
                    $query->whereHas('recordType', function ($q) {
                        $q->where('type', 'Medical Card');
                    });
                }
            ])->findOrFail($patientId);

            return Inertia::render('Account/Patient/Medcard/Index', [
                'user' => $user,
                'data' => $patient,
                'main_url' => route('account.document.medcard'),
            ]);
        }

        return redirect()->back();
    }

    public function showMedcard($patientId)
    {
        $user = Auth::user()->load('image');

        if ($user->is_staff && $patientId) {
            $patient = Patient::with([
                'user',
                'records.documents',
                'records' => function ($query) {
                    $query->whereHas('recordType', function ($q) {
                        $q->where('type', 'Medical Card');
                    });
                }
            ])->findOrFail($patientId);

            return Inertia::render('Account/Staff/Medcard/Index', [
                'user' => $user,
                'data' => $patient,
                'main_url' => route('account.document.medcard'),
            ]);
        }

        return redirect()->back();
    }

    public function storeMedcard(Request $request, $patientId)
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient || $user->is_staff) {
            $patient = Patient::findOrFail($patientId);

            if ($request->hasFile('file')) {
                $validator = Validator::make($request->all(), [
                    'file' => 'required|file|mimes:pdf,doc,docx|max:5120',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::transaction(function () use ($patient, $request) {
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

                    $fileName = $patient->user->first_name . '-' . $patient->user->last_name . '-' . $patient->id . '.' . $request->file('file')->getClientOriginalExtension();

                    $filePath = $request->file('file')->storeAs('documents/medical_cards', $fileName, 'public');

                    $document = new Document([
                        'file_path' => $filePath,
                        'file_name' => $fileName,
                        'file_type' => $request->file('file')->getClientMimeType(),
                        'is_private' => false,
                    ]);

                    $record->documents()->save($document);
                });

                return redirect()->back()->with(['success' => 'Medical card uploaded successfully!', 'data' => $patient]);
            }

            $validator = Validator::make($request->all(), [
                'weight' => 'required|string',
                'height' => 'required|string',
                'blood_type' => 'required|string',
                'blood_pressure' => 'required|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function () use ($patient, $request) {
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

                $data = [
                    'patient' => $patient,
                    'weight' => $request->weight,
                    'height' => $request->height,
                    'blood_type' => $request->blood_type,
                    'blood_pressure' => $request->blood_pressure,
                ];

                $pdf = PDF::loadView('pdf.medical_card', $data);

                $fileName = $patient->user->first_name . '-' . $patient->user->last_name . '-' . $patient->id . '.pdf';
                $filePath = 'documents/medical_cards/' . $fileName;

                Storage::disk('public')->put($filePath, $pdf->output(), 'public');

                $document = new Document([
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_type' => 'application/pdf',
                    'is_private' => false,
                ]);

                $record->documents()->save($document);
            });

            return redirect()->back()->with('success', 'Medical card uploaded successfully!');
        }

        return redirect()->back();
    }

    public function intake()
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient) {
            $patientId = $user->patient->id;

            $patient = Patient::with([
                'user',
                'records.documents',
                'records' => function ($query) {
                    $query->whereHas('recordType', function ($q) {
                        $q->where('type', 'Intake Summary');
                    });
                }
            ])->findOrFail($patientId);

            return Inertia::render('Account/Patient/Intake/Index', [
                'user' => $user,
                'data' => $patient,
                'main_url' => route('account.document.intake'),
            ]);
        }

        return redirect()->back();
    }

    public function showIntake($patientId)
    {
        $user = Auth::user()->load('image');

        if ($user->is_staff && $patientId) {
            $patient = Patient::with([
                'user',
                'records.documents',
                'records' => function ($query) {
                    $query->whereHas('recordType', function ($q) {
                        $q->where('type', 'Intake Summary');
                    });
                }
            ])->findOrFail($patientId);

            return Inertia::render('Account/Staff/Intake/Index', [
                'user' => $user,
                'data' => $patient,
                'main_url' => route('account.document.intake'),
            ]);
        }

        return redirect()->back();
    }

    public function storeIntake(Request $request, $patientId)
    {
        $user = Auth::user()->load('image');

        if ($user->is_staff) {
            $patient = Patient::findOrFail($patientId);

            if ($request->hasFile('file')) {
                $validator = Validator::make($request->all(), [
                    'file' => 'required|file|mimes:pdf,doc,docx|max:5120',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::transaction(function () use ($patient, $request) {
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

                    $fileName = $patient->user->first_name . '-' . $patient->user->last_name . '-' . $patient->id . '.' . $request->file('file')->getClientOriginalExtension();

                    $filePath = $request->file('file')->storeAs('documents/intake_summaries', $fileName, 'public');

                    $document = new Document([
                        'file_path' => $filePath,
                        'file_name' => $fileName,
                        'file_type' => $request->file('file')->getClientMimeType(),
                        'is_private' => false,
                    ]);

                    $record->documents()->save($document);
                });

                return redirect()->back()->with('success', 'Intake summary uploaded successfully!');
            }

            // $validator = Validator::make($request->all(), []);

            // if ($validator->fails()) {
            //     return redirect()->back()->withErrors($validator)->withInput();
            // }

            DB::transaction(function () use ($patient, $request) {
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

                $data = [
                    'patient' => $patient,
                    'patologies' => $request->patologies,
                    'chronic_diseases' => $request->chronic_diseases,
                    'complaints' => $request->complaints,
                    'awareness' => $request->awareness,
                    'head' => $request->head,
                    'limbs' => $request->limbs,
                    'abdomen' => $request->abdomen,
                    'skin' => $request->skin,
                    'lymph_nodes' => $request->lymph_nodes,
                    'breathe' => $request->breathe,
                    'blood_pressure' => $request->blood_pressure,
                    'heart_rate' => $request->heart_rate,
                ];

                $pdf = PDF::loadView('pdf.intake_summary', $data);

                $fileName = $patient->user->first_name . '-' . $patient->user->last_name . '-' . $patient->id . '.pdf';
                $filePath = 'documents/intake_summaries/' . $fileName;

                Storage::disk('public')->put($filePath, $pdf->output(), 'public');

                $document = new Document([
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'file_type' => 'application/pdf',
                    'is_private' => false,
                ]);

                $record->documents()->save($document);
            });

            return redirect()->back()->with('success', 'Intake summary uploaded successfully!');
        }

        return redirect()->back();
    }

    public function diagnosis()
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient) {
            $patientId = $user->patient->id;
            $centerId = $user->patient->center_id;

            $patients = Patient::with([
                'appointments',
                'user',
            ])->where('center_id', $centerId)->get();

            $patients = $patients->map(function ($item) {
                return [
                    'id' => $item->id,
                    'first_name' => $item->user->first_name,
                    'last_name' => $item->user->last_name,
                    'email' => $item->user->email,
                    'birth_date' => $item->birth_date,
                    'address' => $item->address,
                    'gender' => $item->gender,
                    'status' => $item->status,
                    'phones' => $item->phone_numbers,
                    'social_links' => $item->social_links,
                ];
            });

            return Inertia::render('Account/Patient/Diagnosis/Index', [
                'user' => $user,
                'data' => $patients,
                'main_url' => route('account.document'),
            ]);
        }
    }
}
