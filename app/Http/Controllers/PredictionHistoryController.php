<?php

namespace App\Http\Controllers;

use App\Models\PredictionHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PredictionHistoryController extends Controller {
   /**
    * Display a listing of all predictions (Fasyankes only).
    * Shows all predictions from all users.
    */
   public function index(Request $request): Response {
      // Get all predictions with user relationship, paginated
      $predictions = PredictionHistory::with(['user.profile', 'media'])
         ->orderBy('predicted_at', 'desc')
         ->orderBy('created_at', 'desc')
         ->paginate(10);

      // Transform the data to include media URLs
      $predictions->getCollection()->transform(function ($prediction) {
         return [
            'id' => $prediction->id,
            'nik' => $prediction->nik,
            'user' => $prediction->user ? [
               'id' => $prediction->user->id,
               'name' => $prediction->user->name,
               'email' => $prediction->user->email,
            ] : null,
            'predicted_class' => $prediction->predicted_class,
            'confidence_score' => round($prediction->confidence_score * 100, 2), // Convert to percentage
            'processing_time' => $prediction->processing_time,
            'summary' => $prediction->summary,
            'clinical_explanation' => $prediction->clinical_explanation,
            'radiological_findings' => $prediction->radiological_findings, // Already formatted with bullet points
            'recommended_actions' => $prediction->recommended_actions, // Already formatted with bullet points
            'important_notes' => $prediction->important_notes,
            'follow_up_suggestions' => $prediction->follow_up_suggestions,
            'all_probabilities' => json_decode($prediction->all_probabilities, true), // Decode JSON to array
            'model_metadata' => json_decode($prediction->model_metadata, true), // Decode JSON to array
            'predicted_at' => $prediction->predicted_at?->format('d M Y, H:i'),
            'created_at' => $prediction->created_at->format('d M Y, H:i'),
            'image_url' => $prediction->getFirstMediaUrl('predictions'),
         ];
      });

      return Inertia::render('Dashboard/Predictions', [
         'predictions' => $predictions,
      ]);
   }

   /**
    * Display prediction history for the authenticated patient.
    * Shows only the logged-in patient's predictions.
    */
   public function history(Request $request): Response {
      $user = $request->user();

      // Get predictions for the authenticated user only
      $predictions = PredictionHistory::with('media')
         ->where('user_id', $user->id)
         ->orderBy('predicted_at', 'desc')
         ->orderBy('created_at', 'desc')
         ->paginate(10);

      // Transform the data to include media URLs
      $predictions->getCollection()->transform(function ($prediction) {
         return [
            'id' => $prediction->id,
            'nik' => $prediction->nik,
            'predicted_class' => $prediction->predicted_class,
            'confidence_score' => round($prediction->confidence_score * 100, 2), // Convert to percentage
            'processing_time' => $prediction->processing_time,
            'summary' => $prediction->summary,
            'clinical_explanation' => $prediction->clinical_explanation,
            'radiological_findings' => $prediction->radiological_findings, // Already formatted with bullet points
            'recommended_actions' => $prediction->recommended_actions, // Already formatted with bullet points
            'important_notes' => $prediction->important_notes,
            'follow_up_suggestions' => $prediction->follow_up_suggestions,
            'all_probabilities' => json_decode($prediction->all_probabilities, true), // Decode JSON to array
            'model_metadata' => json_decode($prediction->model_metadata, true), // Decode JSON to array
            'predicted_at' => $prediction->predicted_at?->format('d M Y, H:i'),
            'created_at' => $prediction->created_at->format('d M Y, H:i'),
            'image_url' => $prediction->getFirstMediaUrl('predictions'),
         ];
      });

      return Inertia::render('PredictionHistory', [
         'predictions' => $predictions,
      ]);
   }
}
