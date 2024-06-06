<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Display a listing of the faculty.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all faculties
        $title = "Faculty";
        $faculties = Faculty::all();

        // Return view with faculties data
        return view('faculty.index', compact('faculties', 'title'));
    }

    /**
     * Show the form for creating a new faculty.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return view for creating a new faculty
        return view('faculties.create');
    }

    /**
     * Store a newly created faculty in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new faculty instance
        $faculty = new Faculty();
        $faculty->title = $request->title;
        $faculty->description = $request->description;
        $faculty->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Faculty created successfully!');
    }

    /**
     * Display the specified faculty.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function show(Faculty $faculty)
    {
        // Return view with the specified faculty data
        return view('faculties.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified faculty.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        // Return view for editing the specified faculty
        return view('faculties.edit', compact('faculty'));
    }

    /**
     * Update the specified faculty in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            // Add more validation rules as needed
        ]);

        // Update the faculty
        $faculty->update($request->all());

        // Redirect back with success message
        return redirect()->route('faculties.index')->with('success', 'Faculty updated successfully.');
    }

    /**
     * Remove the specified faculty from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        // Delete the faculty
        $faculty->delete();

        // Redirect back with success message
        return redirect()->route('faculties.index')->with('success', 'Faculty deleted successfully.');
    }
}
