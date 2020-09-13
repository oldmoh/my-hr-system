<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Department;
use App\User;
use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request['keyword'];

        $department = Department::where('id', $request['department_id'])->first();
        $predicate = isset($department) ? ['department_id' => $department->id] : [];
        $users = User::where($predicate)
            ->where(function ($query) use ($keyword) {
                $query->where('email', 'like', "%$keyword%")
                    ->orWhere('first_name', 'like', "%$keyword%")
                    ->orWhere('last_name', 'like', "%$keyword%");
            })
            ->paginate();

        return view("users.index", [
            'departments' => Department::orderBy('id')->get(),
            'users' => $users,
            'keyword' => $request['keyword'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize("create", Auth::user());
        return view("users.create", ['departments' => Department::orderBy('id')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize("create", Auth::user());

        $validatedData  = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department_id' => ['required'],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        Log::create([
            'old_value' => json_encode([]),
            'new_value' => $user->toJson(),
            'modified_user_id' => $user->id,
            'modifier_id' => Auth::user()->id
        ]);

        return redirect("users");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view("users.show", ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize("update", $user);

        return view("users.edit", ['user' => $user, 'departments' => Department::orderBy('id')->get()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize("update", $user);

        $old_value = $user->toJson();

        $user->update($request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'department_id' => ['required'],
        ]));

        Log::create([
            'old_value' => $old_value,
            'new_value' => $user->toJson(),
            'modified_user_id' => $user->id,
            'modifier_id' => Auth::user()->id
        ]);

        return redirect("users");
    }

    /**
     * Show the form for editing the password.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit_password(User $user)
    {
        $this->authorize("update_password", $user);
        return view("users.edit_password", ['user' => $user]);
    }

    /**
     * Update the password of the user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, User $user)
    {
        $this->authorize("update_password", $user);

        $validatedData = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $old_value = $user->toJson();

        $user->update([
            'password' => Hash::make($validatedData['password'])
        ]);

        Log::create([
            'old_value' => $old_value,
            'new_value' => $user->toJson(),
            'modified_user_id' => $user->id,
            'modifier_id' => Auth::user()->id
        ]);

        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
