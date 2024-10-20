<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    // Show list of users

    public function index(Request $request)
    {
        $this->authorize('isAdmin');

        $users = Utilities::sortedSearchLike(
            'name', $request->search,
            ['id', 'name', 'email', 'created_at', 'type', 'blocked'],
            $request->sort, $request->sortOrder, 'id',
            User::class
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $users);

        return view(
            'userManagement.index',
            [
                'users' => $users,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    // Show create user page

    public function create()
    {
        $this->authorize('isAdmin');
        
        return view('userManagement.create');
    }

    // Create a new user

    public function store(Request $request)
    {
        $this->authorize('isAdmin');

        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|confirmed',
                'name' => 'required',
                'type' => [
                    'required',
                    Rule::in(['user', 'editor', 'admin'])
                ],
            ],

            [
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email format',
                'password.required' => 'Password is required',
                'password.confirmed' => 'Incorrect confirmation password',
                'name.required' => 'Name is required',
                'type.required' => 'User type is required',
                'type.in' => 'Invalid user type',
            ]
        );

        $user = new User();

        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->type = $request->type;
        $user->created_at = now();

        $user->save();

        return Redirect('/userManagement')->with('success', 'User created successfully');
    }

    // Show details of a user and for editing a user

    public function show(String $id)
    {
        $this->authorize('isAdmin');

        $user = User::findOrFail($id);

        return view('userManagement.show', ['user' => $user]);
    }

    // Update a user

    public function update(Request $request, String $id)
    {
        $this->authorize('isAdmin');
        
        $request->validate(
            [
                'type' => [
                    'required',
                    Rule::in(['user', 'editor', 'admin'])
                ],
                'blocked' => 'required',
            ],

            [
                'type.required' => 'User type is required',
                'type.in' => 'User type is invalid',
                'blocked.required' => 'Blocked status is required',
            ]
        );

        $user = User::findOrFail($id);

        $user->type = $request->type;
        $user->blocked = ($request->blocked == 'n') ? false : true;

        $user->save();

        return Redirect("/userManagement/$id")->with('success', 'User updated successfully');
    }
}
