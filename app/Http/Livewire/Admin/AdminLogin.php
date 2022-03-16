<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLogin extends Component
{
    public $username, $password;

    public function render()
    {
        return view('livewire.admin.login')
            ->layout('components.admin.layoutadminlogin');
    }
 
    protected $rules = [
        'password' => 'required',
        'username' => 'required',
    ];

    protected $messages = [
        'password.required' => 'Please enter password',
        'username.required' => 'Please enter username',
    ];


    public function login(Request $request)
    {
        $this->validate();

        $data = [
            'username' => $this->username,
            'password' => $this->password,
        ];

        $user = DB::table('users')
        ->where('username', '=', $this->username)
        ->first();

        if($user) {

            if(Hash::check($this->password, $user->password))
            {      
                $admin_data = [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "level" => $user->level,
                    "isAdminLogin" => true
                ];
        
                Session::put("admin_data", $admin_data);

                return redirect()->intended('admin/exchange');

            } else {
                return back()->with('error', 'Wrong username or password.');
            }
            
        } else {

            return back()->with('error', 'Wrong username or password.');

        }


    }

    public function logout() 
    {
        Session::flush();

        return redirect('admin/login');
    }
}
