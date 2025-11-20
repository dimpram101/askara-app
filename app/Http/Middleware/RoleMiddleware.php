<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware {
   public function handle(Request $request, Closure $next, ...$roles): Response {
      // Pastikan user sudah login
      if (! $request->user()) {
         abort(403, 'Unauthorized');
      }

      // Cek apakah punya salah satu role
      if (! $request->user()->hasAnyRole($roles)) {
         abort(403, 'You do not have permission to access this resource.');
      }

      return $next($request);
   }
}
