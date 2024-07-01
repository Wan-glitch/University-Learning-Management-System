<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Faculty;
use App\Mail\UserCreated;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $faculties = Faculty::all();
        $users = User::with('GotRole', 'HasFaculty')->get();
        return view('admin.users.index', compact('users', 'roles', 'faculties'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $faculties = Faculty::all();
        return view('admin.users.modals.add_user_modal', compact('roles', 'faculties'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
            'faculty' => 'nullable|exists:faculties,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'faculty' => $request->faculty,
        ]);

        $user->assignRole($request->role);

        // Send email to the user
        Mail::to($user->email)->send(new UserCreated($user, $request->password));

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }



    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('GotRole', 'HasFaculty')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $faculties = Faculty::all();
        return view('admin.users.edit', compact('user', 'roles', 'faculties'));
    }
    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
            'faculty' => 'nullable|exists:faculties,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $newPassword = null;
        if ($request->filled('password')) {
            $newPassword = $request->password;
            $user->password = Hash::make($newPassword);
        }
        $user->role = $request->role;
        $user->faculty = $request->faculty;
        $user->save();

        $user->syncRoles($request->role);

        // Send email to the user if the password was updated
        if ($newPassword) {
            Mail::to($user->email)->send(new \App\Mail\UserUpdated($user, $newPassword));
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Find user by ID
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function getInitialSuggestions()
    {
        // Query your database to get initial tag suggestions
        $suggestions = User::select('id', 'name', 'email')->take(5)->get();
        return response()->json($suggestions);
    }

    public function getUserSuggestions(Request $request)
    {
        // Query your database to get suggestions based on the query
        $query = $request->query('query');
        $suggestions = User::where('name', 'like', "%{$query}%")
                           ->orWhere('email', 'like', "%{$query}%")
                           ->select('id', 'name', 'email')
                           ->get();
        return response()->json($suggestions);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function getUser(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'LIKE', "%{$query}%")
                      ->orWhere('email', 'LIKE', "%{$query}%")
                      ->get(['id', 'name', 'email']);

        return response()->json($users);
    }
}
