<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UsersResource;

class UserController extends Controller
{

    public function fetchUserInfo(Request $request) {
        try {
            $userId = $request->input('id');
            $user = User::findOrFail($userId);
            return response()->json(new UsersResource($user));
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function createUserIndex() {
        return view('create-user.index');
    }

    public function editUserIndex() {
        $users = User::all();
        $fullnames = $users->mapWithKeys(function ($user) {
            return [$user->id => $user->prefixname . ' ' . $user->firstname . ' ' . $user->middlename . ' ' .  $user->lastname . ' ' . $user->suffixname];
        });
        return view('edit-user.index', [
            'fullnames' => $fullnames,
        ]);
    }

    public function deleteUserIndex() {
        $users = User::all();
        $fullnames = $users->mapWithKeys(function ($user) {
            return [$user->id => $user->prefixname . ' ' . $user->firstname . ' ' . $user->middlename . ' ' .  $user->lastname . ' ' . $user->suffixname];
        });
        return view('delete-user.index', [
            'fullnames' => $fullnames,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'prefix-name' => 'nullable|string|max:255',
            'first-name' => 'required|string|max:255',
            'middle-name' => 'nullable|string|max:255',
            'last-name' => 'required|string|max:255',
            'suffix-name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'user-name' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'profile-pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'access-type' => 'required|string|in:admin,user',
        ]);

        // Hash the password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Handle photo upload if present
        if ($request->hasFile('profile-pic')) {
            $filename = time() . '_' . $request->file('profile-pic')->getClientOriginalName();
            $path = $request->file('profile-pic')->storeAs('photos', $filename, 'public');
            $validatedData['profile-pic'] = $path;
        }

        // Map the validated data to model attributes
        $userData = [
            'prefixname' => $validatedData['prefix-name'] ?? null,
            'firstname' => $validatedData['first-name'],
            'middlename' => $validatedData['middle-name'] ?? null,
            'lastname' => $validatedData['last-name'],
            'suffixname' => $validatedData['suffix-name'] ?? null,
            'email' => $validatedData['email'],
            'username' => $validatedData['user-name'],
            'password' => $validatedData['password'],
            'photo' => $validatedData['profile-pic'] ?? null,
            'type' => $validatedData['access-type'],
        ];

        // Create the user
        User::create($userData);

        // Redirect with success message
        return redirect()->route('users.create-user.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);
            $validatedData = $request->validate([
                'prefixname' => 'nullable|string|max:255',
                'firstname' => 'nullable|string|max:255',
                'middlename' => 'nullable|string|max:255',
                'lastname' => 'nullable|string|max:255',
                'suffixname' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255|unique:users,email,' . $id,
                'username' => 'nullable|string|max:255|unique:users,username,' . $id,
                'password' => 'nullable|string|min:8|confirmed',
                'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'type' => 'nullable|string|in:admin,user',
            ]);

            if ($request->hasFile('profile_pic')) {
                $filename = time() . '_' . $request->file('profile_pic')->getClientOriginalName();
                $path = $request->file('profile_pic')->storeAs('photos', $filename, 'public');
                $user->photo = $path;
            }

            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->prefixname = $validatedData['prefixname'] ?? $user->prefixname;
            $user->firstname = $validatedData['firstname'] ?? $user->firstname;
            $user->middlename = $validatedData['middlename'] ?? $user->middlename;
            $user->lastname = $validatedData['lastname'] ?? $user->lastname;
            $user->suffixname = $validatedData['suffixname'] ?? $user->suffixname;
            $user->email = $validatedData['email'] ?? $user->email;
            $user->username = $validatedData['username'] ?? $user->username;
            $user->type = $validatedData['type'] ?? $user->type;
            $user->save();

            return redirect()->route('users.edit-user.index')->with('success', 'User updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $selected_user = User::findOrFail($id);
            $selected_user->delete(); // This will soft delete the user
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting user: ' . $e->getMessage()], 500);
        }
    }

    public function trashedUsersIndex() {
        $trashedUsers = User::onlyTrashed()->get();
        return view('trashed-users.index', [
            'users' => $trashedUsers
        ]);
    }

    public function trashedUsers() {
        $trashedUsers = User::onlyTrashed()->get();
        return view('trashed-users.index', ['users' => $trashedUsers]);
    }

    public function restore($id) {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->restore(); // Restore the user
            return response()->json(['success' => true, 'message' => 'User restored successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error restoring user: ' . $e->getMessage()], 500);
        }
    }

    public function forceDelete($id) {
        try {
            $user = User::withTrashed()->findOrFail($id);
            $user->forceDelete(); // Permanently delete the user
            return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleted user: ' . $e->getMessage()], 500);
        }
    }

}
