<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Document;
use App\Models\Office;
use App\Models\Folder;


class UserController extends Controller
{
   public function userView()
    {

        // Fetch all users
        $users = User::all();
        // $userCount = User::count();
       

        $offices = Office::orderBy('office_name', 'asc')->get();
        
        // Return the view with users data
        return view('users.user', compact('users','offices'));
    }

    public function addUser(Request $request)
{
    // Validate the request data with custom messages
    $request->validate([
        'username' => 'required|string|max:255|unique:users,username', // Check for unique username
        'fname' => 'required|string|max:255',
        'mname' => 'nullable|string|max:255',
        'lname' => 'required|string|max:255',
        'department' => 'required|string|max:255',
        'role' => 'required|string|max:255',
        'password' => 'required|string|min:8', // Minimum length changed to 8
    ], [
        'username.unique' => 'This username is already taken. Please choose another one.', // Custom error message
    ]);

    // Create a new user
    $password = Hash::make($request->input('password'));
    User::create([
        'username' => $request->username,
        'fname' => $request->fname,
        'mname' => $request->mname,
        'lname' => $request->lname,
        'department' => $request->department,
        'role' => $request->role,
        'password' => $password,
    ]);

    // Redirect back with success message or do any additional logic here
    return redirect()->back()->with('success', 'User added successfully.');
}

public function userEdit($id)
{
  $editUser = User::where('id', $id)->first();
    $offices = Office::all();
    $users = User::all(); // To repopulate user list in the table

    if (!$editUser) {
        return redirect()->back()->with('error', 'User not found');
    }

    return view('users.user', compact('editUser', 'offices', 'users'));
}

public function userUpdate(Request $request, $id)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(), [
        'username' => 'required|string|max:255|unique:users,username,' . $id . ',id',
        'password' => 'nullable|string|min:8|confirmed', // Make password nullable and use 'confirmed' for password confirmation
        'department' => 'required|string|max:255',
        'role' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Find the user by ID
    $user = User::find($id);
    if (!$user) {
        return redirect()->back()->with('error', 'User not found');
    }

    // Update user details
    $user->fname = $request->input('fname');
    $user->mname = $request->input('mname');
    $user->lname = $request->input('lname');
    $user->username = $request->input('username');
    $user->department = $request->input('department');
    $user->role = $request->input('role');

    // Only update the password if it's provided and not empty
    if (!empty($request->input('password'))) {
        $user->password = Hash::make($request->input('password'));
    }

    // Save the updated user details
    $user->save();

    // Redirect with a success message
    return redirect()->route('userView')->with('success', 'User updated successfully.');
}


    public function deleteUser($id)
{
    // Find the user by ID
    $user = User::findOrFail($id);

    // Delete the user
    $user->delete();

    // Redirect back with a success message
    return redirect()->route('userView')->with('success', 'User deleted successfully.');
}

}
