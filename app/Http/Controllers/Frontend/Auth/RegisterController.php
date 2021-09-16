<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // max:20480Kilobyte(KB) == 20Megabyte(MB)
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'unique:users', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'numeric', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_image' => ['nullable', 'image', 'max:20480', 'mimes:jpeg,jpg,png'],
            'bio' => ['nullable', 'string', 'max:65535'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'username' =>$data['username'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);
        /*
         *  isset: returns TRUE if the variable exists and has a value other than NULL
         *  public_path: generate a fully qualified path to a given file within the public directory
         *  Image::make('foo/bar/baz.jpg'): Read image from file AND Return Values Instance of Intervention\Image\Image
         */
        if(isset($data['user_image'])) {
            $image = $data['user_image'];
            $filename = Str::slug($data['username']) . '.' . $image->getClientOriginalExtension();
            $path = public_path('/assets/users/' . $filename);
            // image.intervention
            Image::make($image->getRealPath())->resize(300, 300, function ($constraint){
                $constraint->aspectRatio();
            })->save($path, 100);

            // Save image name in database
            $user->update(['user_image' => $filename]);
        }
        $user->attachRole(Role::whereName('user')->first()->id);
        return $user;
    }

    /*
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('frontend.auth.register');
    }

    /*
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect()->route('frontend.index')->with([
            'message' => 'Your account registrered successfully, Please check your email to activate your account.',
            'alert-type' => 'success'
        ]);
    }
}
