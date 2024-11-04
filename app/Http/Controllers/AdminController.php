<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->get();
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        if (auth()->user()->is_admin) {
            $user->is_active = !$user->is_active;
            $user->save();
            return redirect()->back()->with('success', 'Status user berhasil diubah.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah status.');
    }
}
