<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));

    }


    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the view to create a new user
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate user input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            // Add more validation rules if needed
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // Add more fields if needed
        ]);

        if($user){
            return redirect()->route('users.index')->with('success', 'User created successfully!');
        } else {
            return back()->withInput()->with('error', 'Failed to create user');
        }

    }



    public function batchStore(Request $request)
    {
        // Validate batch user input
        $request->validate([
            'batch_users' => 'required',
            // Add more validation rules if needed
        ]);

        // Explode batch users input by comma and trim whitespace
        $batchUsers = array_map('trim', explode(',', $request->batch_users));

        // Array to store errors
        $errors = [];

        // Loop through batch users and create them
        foreach ($batchUsers as $username) {
            // Check if user with the same email already exists
            if (User::where('email', $username)->exists()) {
                $errors[] = "User with email $username already exists.";
                continue;
            }

            // Create the user
            User::create([
                'name' => $username, // Assuming username is the name
                'email' => $username, // Assuming username is also the email
                'password' => bcrypt('defaultpassword'), // You can set default password here or leave it blank
                // Add more fields if needed
            ]);
        }

        // Check if there were any errors during batch user creation
        if (!empty($errors)) {
            return redirect()->back()->with('error', implode('<br>', $errors));
        }

        // Redirect back with success message
        return redirect()->route('users.index')->with('success', 'Batch users created successfully!');
    }
    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id); // Find user by ID
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
        $user = User::findOrFail($id); // Find user by ID
        return view('admin.users.edit', compact('user'));
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
        // Validate user input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            // Add more validation rules if needed
        ]);

        // Update the user
        $user = User::findOrFail($id); // Find user by ID
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            // Update other fields if needed
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
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
}
