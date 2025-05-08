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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $centerId = $user->patient->center_id;

            $patient = Patient::with([
                'user',
                'records.recordType',
                'records.documents'
            ])->findOrFail($patientId);

            return Inertia::render('Account/Patient/Medcard/Index', [
                'user' => $user,
                'data' => $patient,
                'main_url' => route('account.document'),
            ]);
        }

        return redirect()->back();
    }

    public function storeMedcard(Request $request, $patientId)
    {
        $user = Auth::user()->load('image');

        if ($user->is_patient) {
            $patient = Patient::findOrFail($patientId);

            if ($request->hasFile('file')) {
                $validator = Validator::make($request->all(), [
                    'file' => 'required|file|mimes:pdf,doc,docx|max:5120',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::transaction(function () use ($patient, $request) {
                    // Get or create 'Medical Card' record type
                    $recordType = RecordType::where('type', 'Medical Card')->firstOrFail();

                    // Create a new medical card record
                    $record = new Record([
                        'record_type_id' => $recordType->id,
                        'content' => 'Uploaded medical card file',
                    ]);
                    $patient->records()->save($record); // recordable = Patient

                    // Store file
                    $path = $request->file('file')->store('documents/medical_cards', 'public');

                    // Create Document record
                    $document = new Document([
                        'path' => $path,
                        'name' => $request->file('file')->getClientOriginalName(),
                        'type' => $request->file('file')->getClientMimeType(),
                    ]);

                    $record->documents()->save($document); // documentable = Record
                });

                return redirect()->back()->with('success', 'Medical card uploaded successfully!');
            }

            $validator = Validator::make($request->all(), [
                'weight' => 'required|integer',
                'height' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function () use ($patient, $request) {});

            // return redirect()->back()->with(['data' => $record->load('documents'), 'success' => 'Medical card uploaded successfully!']);
            return redirect()->back()->with('success', 'Medical card uploaded successfully!');
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

            return Inertia::render('Account/Patient/Diagnosis/Index', [
                'user' => $user,
                'data' => $patients,
                'main_url' => route('account.document'),
            ]);
        }
    }
}
