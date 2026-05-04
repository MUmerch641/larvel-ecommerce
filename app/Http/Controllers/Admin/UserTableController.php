<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $draw = $request->get('draw', 1);
            $start = $request->get('start', 0);
            $length = $request->get('length', 10);
            $search = $request->get('search.value', '');
            
            $query = User::query()
                ->where('is_admin', false)
                ->whereHas('orders');
            
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            }
            
            $totalRecords = User::where('is_admin', false)->whereHas('orders')->count();
            $totalFiltered = $query->count();
            
            $users = $query->offset($start)->limit($length)->get();
            
            $data = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => '<span class="badge bg-secondary">Customer</span>',
                    'order_count' => $user->orders()->count(),
                    'created_at' => $user->created_at->format('M d, Y'),
                ];
            });
            
            return response()->json([
                'draw' => (int) $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $data,
            ]);
        }

        return view('admin.users.table');
    }
}
