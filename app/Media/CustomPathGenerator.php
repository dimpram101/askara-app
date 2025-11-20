<?php

namespace App\Media;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CustomPathGenerator implements PathGenerator {
   public function getPath(Media $media): string {
      return "predictions/{$media->model_id}/";
   }

   public function getPathForConversions(Media $media): string {
      return "predictions/{$media->model_id}/conversions/";
   }

   public function getPathForResponsiveImages(Media $media): string {
      return "predictions/{$media->model_id}/responsive/";
   }
}
