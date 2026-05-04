<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $draw = $request->get('draw', 1);
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $search = $request->get('search.value', '');
            
            $query = User::query()->where('is_admin', true);
            
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
            
            $totalRecords = User::where('is_admin', true)->count();
            $totalFiltered = $query->count();
            
            $admins = $query->offset($start)->limit($length)->get();
            
            $data = $admins->map(function ($admin) {
                return [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'email' => $admin->email,
                    'role' => '<span class="badge bg-danger">Admin</span>',
                    'created_at' => $admin->created_at->format('M d, Y'),
                ];
            });
            
            return response()->json([
                'draw' => (int) $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        }

        return view('admin.admins.table');
    }
}
