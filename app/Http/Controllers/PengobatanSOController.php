<?php

namespace App\Http\Controllers;

use App\Models\PengobatanSO;
use Illuminate\Http\Request;

class PengobatanSOController extends Controller {
   public function index(Request $request) {
      // $data = PengobatanSO::all();

      return inertia('PengobatanSO3', [
         // 'apiData' => $data,
      ]);
   }

   public function getData(Request $request) {
      $data = PengobatanSO::all();
      return response()->json($data);
   }
}
