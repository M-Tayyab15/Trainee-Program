<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\UserPic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use App\Models\File;




class UserManagementController extends Controller
{
    // Constructor to ensure only admins can access
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

   
    public function index(Request $request)
{
    $emailQuery = $request->input('email', '');
    $nameQuery = $request->input('name', '');

    $users = User::search($nameQuery, $emailQuery)
        ->paginate(5);

   
    foreach ($users as $user) {
        $user->encrypted_id = Crypt::encrypt($user->id);
        $fileStatus = $user->hasFile();
        $user->fileExists = $fileStatus['fileExists'];
        $user->fileName = $fileStatus['fileName'];
    }

    return view('admin.manage-users', compact('users', 'nameQuery', 'emailQuery'));
}


    // Delete
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        return redirect()->route('manageusers')->with('message', 'User has been deactivated.');
    }

    public function create()
    {
        return view('admin.adduser');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'emailID' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&]/|regex:/\d/',
            'phoneNo' => 'required|numeric',
            'address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Image validation
        ]);

        // Create the user in the users table
        $user = User::create([
            'name' => $request->firstName . ' ' . $request->lastName,
            'email' => $request->emailID,
            'password' => Hash::make($request->password),
            'status' => 1,
        ]);

        $currentTimestamp = now()->timestamp;
        $ipAddress = $request->ip();


        if ($ipAddress === '::1') {
            $ipAddress = '127.0.0.1';
        }


        $ipAddress = filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ? $ipAddress : '127.0.0.1';

        // Store the IP address in the profile
        Profile::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'phone' => $request->phoneNo,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'ip_address' => $ipAddress,
            'created_on' => $currentTimestamp, 
            'modified_on' => $currentTimestamp, 
        ]);

        // Handle the image upload if present
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension(); // Get the file extension

            $imageName = $user->id . '.' . $imageExtension;

            $userImagePath = "profile_images/{$user->id}/";

            Storage::disk('public')->makeDirectory($userImagePath);

            $imagePath = $image->storeAs("public/{$userImagePath}", $imageName);

            UserPic::create([
                'user_id' => $user->id,
                'name' => $imageName,
                'path' => $imagePath,
            ]);
        }

        return redirect()->route('adduser')->with('message', 'User and profile added successfully!');
    }


    public function edit($encryptedId)
    {
        // Decrypt the ID to get the user ID
        $userId = Crypt::decrypt($encryptedId);


        $user = User::findOrFail($userId);

        $nameParts = explode(' ', $user->name, 2);
        $user->firstName = $nameParts[0];
        $user->lastName = $nameParts[1] ?? '';

        return view('admin.updateuser', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'oldPassword' => 'nullable|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&]/|regex:/\d/',
            'newPassword' => 'nullable|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&]/|regex:/\d/',
            'address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->filled('oldPassword') && $request->filled('newPassword')) {
            if (!Hash::check($request->oldPassword, $user->password)) {
                return redirect()->back()->withErrors(['oldPassword' => 'The old password is incorrect.']);
            }
            $user->password = Hash::make($request->newPassword);
        }

        $user->name = $request->firstName . ' ' . $request->lastName;

        $user->save();

        $profile = $user->profile;

        $profile->address = $request->address;
        $profile->country = $request->country;
        $profile->state = $request->state;
        $profile->city = $request->city;

        $profile->modified_on = now()->timestamp;
        $profile->save();

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Save the new image with the user ID as the filename
            $imageName = $user->id . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs("public/profile_images/{$user->id}", $imageName);

            // If the user already has a picture, rename the old image with a timestamp
            if ($user->pic) {
                $oldImagePath = storage_path('app/' . $user->pic->path);

                // Add timestamp to old image if it exists
                if (file_exists($oldImagePath)) {
                    $oldImageName = pathinfo($user->pic->name, PATHINFO_FILENAME);
                    $oldImageExtension = pathinfo($user->pic->name, PATHINFO_EXTENSION);
                    $timestampedOldImageName = $oldImageName . '-' . now()->timestamp . '.' . $oldImageExtension;
                    $newOldImagePath = "public/profile_images/{$user->id}/" . $timestampedOldImageName;

                    // Rename the old image with the timestamp
                    rename($oldImagePath, storage_path('app/' . $newOldImagePath));

                    // Update the image record with the new timestamped file path
                    $user->pic->update([
                        'name' => $timestampedOldImageName,
                        'path' => $newOldImagePath,
                    ]);
                }
            } else {
                // If the user doesn't have a profile image, create a new record in the user pics table
                UserPic::create([
                    'user_id' => $user->id,
                    'name' => $imageName,
                    'path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('manageusers')->with('message', 'User details updated successfully!');
    }


    public function uploadFile(Request $request)
    {
        // Validate the file and user ID
        $request->validate([
            'file' => 'required|file|mimes:pdf,docx,doc|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);


        $user = User::find($request->user_id);
        $file = $request->file('file');


        $folderPath = base_path('uploads/' . $user->id);

        // Ensure the folder exists, create it if not
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0775, true);
        }

        // Check if any file already exists in the folder
        $existingFiles = scandir($folderPath);


        if (count($existingFiles) > 2) {
            foreach ($existingFiles as $existingFile) {
                if ($existingFile !== '.' && $existingFile !== '..') {
                    // Rename the old file by appending a timestamp
                    $timestamp = time();
                    $newFilename = pathinfo($existingFile, PATHINFO_FILENAME) . '-' . $timestamp . '.' . pathinfo($existingFile, PATHINFO_EXTENSION);

                    // Rename the old file
                    rename($folderPath . '/' . $existingFile, $folderPath . '/' . $newFilename);


                    File::where('filename', $existingFile)->where('user_id', $user->id)->update(['status' => 0, 'modified_on' => time()]);
                }
            }
        }

        // Generate the filename for the new file
        $filename = $user->id . '.' . $file->getClientOriginalExtension();

        // Store the new file in the defined folder
        $file->move($folderPath, $filename);

        // Get the file size manually using PHP's filesize function
        $fileSize = filesize($folderPath . '/' . $filename);

        // Save the file path to the user's profile (or any other logic)
        $user->profile->update(['file_path' => 'uploads/' . $user->id . '/' . $filename]);

        // Insert record into the tbl_file table using Eloquent for the new file
        File::create([
            'filename'    => $filename,
            'size'        => $fileSize, 
            'folder'      => $folderPath,
            'user_id'     => $user->id,
            'status'      => 1,
            'created_on'  => time(),
            'modified_on' => time(),
        ]);

        // Return a success response
        return redirect()->back()->with('message', 'File uploaded successfully!');
    }


    public function downloadFile($userId, $fileName)
    {
        // Path to the user's file
        $filePath = base_path("uploads/{$userId}/{$fileName}");


        if (file_exists($filePath)) {

            return response()->download($filePath);
        } else {

            return abort(404, 'File not found');
        }
    }
}
