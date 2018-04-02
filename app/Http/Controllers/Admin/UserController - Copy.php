<?php
namespace App\Http\Controllers\Admin;

use Mail;
use Sentinel;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use Centaur\AuthManager;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Users\IlluminateUserRepository;
use App\Http\Controllers\Controller;
use App\Models\Users;

class UserController extends Controller
{
    /** @var Cartalyst\Sentinel\Users\IlluminateUserRepository */
    protected $userRepository;
    /** @var Centaur\AuthManager */
    protected $authManager;
    public function __construct(AuthManager $authManager)
    {
        // Middleware
        $this->middleware('sentinel.auth');
        $this->middleware('sentinel.access:users.create', ['only' => ['create', 'store']]);
        $this->middleware('sentinel.access:users.view', ['only' => ['index', 'show']]);
        $this->middleware('sentinel.access:users.update', ['only' => ['edit', 'update']]);
        $this->middleware('sentinel.access:users.destroy', ['only' => ['destroy']]);
        // Dependency Injection
        $this->userRepository = app()->make('sentinel.users');
        $this->authManager = $authManager;
    }
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Users::orderBy('last_name','ASC')->get();
        return view('admin.users.index', ['users' => $users]);

    }
    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = app()->make('sentinel.roles')->createModel()->all();
        return view('admin.users.create', ['roles' => $roles]);
    }
    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request;
		if($request->get('productionProject_id') <> null){
		$data = array(
			'email' => trim($request->get('email')),
            'password' => $request->get('password'),
            'first_name' => $request->get('first_name', null),
            'last_name' => $request->get('last_name', null),
			'telefon' => $request->get('telefon'),
			'productionProject_id'=> $request->get('productionProject_id')
			//'department_id' => $request->get('department_id', null)
		);
		} else {
			
			$data = array(
			'email' => trim($request->get('email')),
            'password' => $request->get('password'),
            'first_name' => $request->get('first_name', null),
            'last_name' => $request->get('last_name', null),
			'telefon' => $request->get('telefon'),
			//'department_id' => $request->get('department_id', null)
		);
		}
		
		$result = $this->authManager->register($data, $activation=true);
		// Assign User Roles
        foreach ($request->get('roles', []) as $slug => $id) {
            $role = Sentinel::findRoleBySlug($slug);
            if ($role) {
                $role->users()->attach($result->user);
            }
        }
			
		$message = session()->flash('success', 'Uspješno je dodan novi djelatnik');
		
		//return redirect()->back()->withFlashMessage($messange);
		return redirect()->route('users.index')->withFlashMessage($message);
		
    }
    /**
     * Display the specified user.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // The user detail page has not been included for the sake of brevity.
        // Change this to point to the appropriate view for your project.
        return redirect()->route('users.index');
    }
    /**
     * Show the form for editing the specified user.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch the user object
        // $id = $this->decode($hash);
        $user = $this->userRepository->findById($id);
        // Fetch the available roles
        $roles = app()->make('sentinel.roles')->createModel()->all();
        if ($user) {
            return view('admin.users.edit', [
                'user' => $user,
                'roles' => $roles
            ]);
        }
        session()->flash('error', 'Invalid user.');
        return redirect()->back();
    }
    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Decode the user id
        // $id = $this->decode($hash);
        // Validate the form data
        $result = $this->validate($request, [
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'confirmed|min:6',
        ]);
        // Assemble the updated attributes
        $attributes = [
            'email' => trim($request->get('email')),
            'first_name' => $request->get('first_name', null),
            'last_name' => $request->get('last_name', null),
			//'department_id' => $request->get('department_id', null)
        ];
        // Do we need to update the password as well?
        if ($request->has('password')) {
            $attributes['password'] = $request->get('password');
        }
        // Fetch the user object
        $user = $this->userRepository->findById($id);
        if (!$user) {
            if ($request->ajax()) {
                return response()->json("Invalid user.", 422);
            }
            session()->flash('error', 'Invalid user.');
            return redirect()->back()->withInput();
        }
        // Update the user
        $user = $this->userRepository->update($user, $attributes);
        // Update role assignments
        $roleIds = array_values($request->get('roles', []));
        $user->roles()->sync($roleIds);
        // All done
        if ($request->ajax()) {
            return response()->json(['user' => $user], 200);
        }
        session()->flash('success', "{$user->email} has been updated.");
        return redirect()->route('users.index');
    }
    /**
     * Remove the specified user from storage.
     *
     * @param  string  $hash
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = $this->userRepository->findById($id);
		dd($user);
        // Check to be sure user cannot delete himself
        if (Sentinel::getUser()->id == $user->id) {
            $message = "You cannot remove yourself!";
            if ($request->ajax()) {
                return response()->json($message, 422);
            }
            session()->flash('error', $message);
            return redirect()->route('users.index');
        }
        // Remove the user
        $user->delete();
        // All done
        $message = "{$user->email} has been removed.";
        if ($request->ajax()) {
            return response()->json([$message], 200);
        }
        session()->flash('success', $message);
        return redirect()->route('users.index');
    }

}