<?php

namespace App\PipelineFilters\UsersPipeline;

use Closure;

class GetByKey
{

  public function handle($query, Closure $next)
  {
    if (request()->has('byId') && request()->get('byId')) 
    {
        $query->where('id', request()->get('byId'));
    }
    if (request()->has('byEmail') && request()->get('byEmail')) 
    {
        $query->where('email', request()->get('byEmail'));
    }
    
    return $next($query);
  }
}
