<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PredictionHistory extends Model implements HasMedia {
   use InteractsWithMedia;

   protected $table = 'prediction_history';

   protected $guarded = ['id'];

   protected $casts = [
      'predicted_at' => 'datetime',
   ];

   public function registerMediaCollections(): void {
      $this->addMediaCollection('predictions')
         ->useDisk('public')->singleFile();
   }

   public function user(): BelongsTo {
      return $this->belongsTo(User::class, 'user_id');
   }
}
