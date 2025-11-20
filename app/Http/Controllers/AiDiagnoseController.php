<?php

namespace App\Http\Controllers;

use App\Models\PredictionHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiDiagnoseController extends Controller {
   public function index(Request $request) {
      $user = $request->user();
      if (!$user->profile || ($user->profile && !$user->profile->nik)) {
         return redirect('/profile')->with('error', 'Please complete your profile with a valid NIK before accessing AI Diagnose.');
      }

      return inertia('AiDiagnose');
   }

   public function store(Request $request) {
      $request->validate([
         'nik' => 'required|string',
         'image' => 'required|image|max:5120',
      ]);

      // dd($request->all());

      $user = User::whereHas('profile', function ($query) use ($request) {
         $query->where('nik', $request->nik);
      })->first();

      $result = DB::transaction(function () use ($user, $request) {
         $diagnose = $request->diagnosis;

         $prediction = PredictionHistory::create([
            'nik' => $request->nik,
            'user_id' => $user ? $user->id : null,
            'confidence_score' => $diagnose['confidence'] / 100, // Convert from percentage to decimal (0-1)
            'predicted_class' => $diagnose['prediction'],
            'processing_time' => number_format($diagnose['processing_time_seconds'], 3) . 's', // Format: "0.663s"

            'summary' => $diagnose['clinical_explanation']['ringkasan_diagnosis'] ?? null,
            'clinical_explanation' => $diagnose['clinical_explanation']['penjelasan_klinis'] ?? null,
            'radiological_findings' => $diagnose['clinical_explanation']['temuan_radiologis'] ? implode("\n• ", $diagnose['clinical_explanation']['temuan_radiologis']) : null, // Join with bullet points
            'recommended_actions' => $diagnose['clinical_explanation']['rekomendasi_tindakan'] ? implode("\n• ", $diagnose['clinical_explanation']['rekomendasi_tindakan']) : null, // Join with bullet points
            'important_notes' => $diagnose['clinical_explanation']['catatan_penting'] ?? null,
            'follow_up_suggestions' => $diagnose['clinical_explanation']['follow_up'] ?? null,

            'all_probabilities' => json_encode($diagnose['all_probabilities'] ?? []),
            'model_metadata' => json_encode($diagnose['model_info'] ?? []),

            'predicted_at' => now(),
         ]);


         if ($request->hasFile('image')) {
            $prediction->addMediaFromRequest('image')->toMediaCollection('predictions');
         }

         return $prediction;
      });

      return redirect()->back()->with('success', 'Image uploaded successfully.');
   }
}
