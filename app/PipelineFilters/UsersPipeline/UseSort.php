<?php

namespace App\PipelineFilters\UsersPipeline;

use Closure;

class UseSort
{

  public function handle($query, Closure $next)
  {
   
    if(request()->has('sortBy'))
    { 
        if(request()->get('sortType'))
        {
          $sortType = request()->get('sortType');
        }
        else
        {
          $sortType = 'desc';
        }
        
         $query->orderBy(''.request()->get('sortBy').'', $sortType);
    }
    
    return $next($query);
  }
}
