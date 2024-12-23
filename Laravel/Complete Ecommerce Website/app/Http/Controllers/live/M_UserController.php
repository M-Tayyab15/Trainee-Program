<?php
//test
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show the user list with pagination and search
    public function index(Request $request)
    {
        // Get search filters from the request
        $firstNameQuery = $request->input('first_name', '');
        $lastNameQuery = $request->input('last_name', '');
        $emailQuery = $request->input('email', '');

        // Paginate users with the filters
        $users = User::with('profile')
            ->where('status', 1)
            ->whereHas('profile', function ($query) use ($firstNameQuery, $lastNameQuery, $emailQuery) {
                $query->where('firstname', 'like', "%$firstNameQuery%")
                      ->where('lastname', 'like', "%$lastNameQuery%");
            })
            ->where('email', 'like', "%$emailQuery%")
            ->paginate(5);

        return view('users.index', compact('users', 'firstNameQuery', 'lastNameQuery', 'emailQuery'));
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('message', 'User deleted successfully');
    }
}
