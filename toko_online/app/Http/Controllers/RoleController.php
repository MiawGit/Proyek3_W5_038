<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRoleRequest;
use App\Models\User;
use App\Services\RoleManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function update(
        ChangeRoleRequest $request,
        User $user,
        RoleManagementService $service
    ): RedirectResponse {
        $data = $request->validated();

        $service->changeRole($request->user(), $user, $data['role']);

        return back()->with('status', 'Role diperbarui.');
    }
}
