<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DataTableService
{
    protected Request $request;
    protected Builder $query;
    protected array $columns;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function query(Builder $query)
    {
        $this->query = $query;
        return $this;
    }
    
    public function columns(array $columns)
    {
        $this->columns = $columns;
        return $this;
    }
    
    public function make()
    {
        $draw = $this->request->get('draw', 1);
        $start = $this->request->get('start', 0);
        $length = $this->request->get('length', 10);
        $search = $this->request->get('search.value', '');
        
        // Search
        if ($search !== '') {
            $this->query->where(function ($q) use ($search) {
                foreach ($this->columns as $column) {
                    if ($column !== 'actions') {
                        $q->orWhere($column, 'like', '%' . $search . '%');
                    }
                }
            });
        }
        
        // Total records
        $totalRecords = $this->query->count();
        $totalFiltered = $totalRecords;
        
        // Paginate
        $data = $this->query->offset($start)->limit($length)->get();
        
        return response()->json([
            'draw' => (int) $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ]);
    }
}
