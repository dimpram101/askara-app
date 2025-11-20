<?php

namespace App\Http\Controllers;

use App\Models\PredictionHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AiDiagnoseController extends Controller {
   public function index(Request $request) {
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
            'confidence_score' => $diagnose['confidence'],
            'predicted_class' => $diagnose['prediction'],
            'processing_time' => $diagnose['processing_time_seconds'],

            'summary' => $diagnose['clinical_explanation']['ringkasan_diagnosis'] ?? null,
            'clinical_explanation' => $diagnose['clinical_explanation']['penjelasan_klinis'] ?? null,
            'radiological_findings' => $diagnose['clinical_explanation']['temuan_radiologis'] ? collect($diagnose['clinical_explanation']['temuan_radiologis'])->implode(',') : null,
            'recommended_actions' => $diagnose['clinical_explanation']['rekomendasi_tindakan'] ? collect($diagnose['clinical_explanation']['rekomendasi_tindakan'])->implode(',') : null,
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
