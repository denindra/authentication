<?php

namespace App\PipelineFilters\UsersPipeline;

use Closure;

class GetByWord
{

  public function handle($query, Closure $next)
  {
    if (request()->has('keyword') ) 
    {
        $query->where('name', 'like', '%' .request()->get('keyword').'%');
        $query->orWhere('email', 'like', '%' .request()->get('keyword').'%');
    }

    return $next($query);
  }
}
