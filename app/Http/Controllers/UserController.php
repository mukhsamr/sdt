<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\HasTryCatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    use HasTryCatch;

    public function index(Request $request)
    {
        return Inertia::render('User/UserDaftar', [
            'daftar' => User::where('nama', 'like', "%$request->cari%")->get(),
            'cari' => $request->cari
        ]);
    }

    public function create()
    {
        return Inertia::render('User/UserTambah');
    }

    public function store(UserRequest $request)
    {
        $alert = $this::execute(
            try: fn () => User::create($request->input()),
            message: 'tambah user'
        );

        return back()->with('alert', $alert);
    }

    public function edit(User $user)
    {
        return Inertia::render('User/UserEdit', [
            'user' => $user
        ]);
    }

    public function update(UserRequest $request)
    {
        if ($request->password) {
            $request->merge(['password' => bcrypt($request->password)]);
        }

        $data = $request->password
            ? $request->input()
            : $request->except('password');

        $alert = $this::execute(
            try: fn () => User::where('id', $request->id)->update($data),
            message: 'update user'
        );

        return back()->with('alert', $alert);
    }

    public function destroy(User $user)
    {
        $alert = $this::execute(
            try: fn () => $user->delete(),
            message: 'hapus user'
        );

        return back()->with('alert', $alert);
    }
}
