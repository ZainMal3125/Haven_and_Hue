<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Hash;
use Auth;
use Mail;
use App\Mail\DemoMail;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role= Role::where('name','!=','admin')->get();
        return view('user.add',compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->first_name= $request->fname;
        $user->last_name=$request->lname;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        // $userData= User::where('email',$request->email)->first();
        $userId= $user->id;
        $userRole=$request->role;
        foreach($userRole as $ids){
            $userRole= new UserRole;
            $userRole->roleId=$ids;
            $userRole->userId=$userId;
            $userRole->save();
        }
        $otp= rand(999,9999);
        $mailData = [
            'title' => 'Mail from project.com',
            'body' => $otp,
            'files' => [
            ]
        ];
        Mail::to($request->email)->send(new DemoMail($mailData));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userData= User::all();
        $role=Role::all();
        $userRole= UserRole::all();
        return view("user.show",compact('userData','role','userRole'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $req)
    {
        $id = $req->edit;
        $update=User::where('id',$id)->first();
        return view('user.edit',compact('update'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $abc)
    {
        $id= $abc->update;
        $update=User::where('id',$id)->first();
        if($update){
            $update->first_name= $abc->fname;
            $update->last_name=$abc->lname;
            $update->email=$abc->email;
            $update->update();
            return redirect()->route('userShow');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $req)
    {
        $id= $req->delete;
        User::destroy($id);
        return redirect()->route('userShow');
    }
    public function customLogin(Request $request){
        $email=$request->email;
        $password= $request->password;
        $userData= User::where('email',$email)->first();
        if($userData){
            $dbPassword=$userData->password; 
            if(password_verify($password,$dbPassword)){
                $userId= $userData->id;
                $userRoleData=UserRole::where('userId',$userId)->get();    
                foreach($userRoleData as $urd){
                    $roleId[]= $urd->roleId;
                }
                foreach($roleId as $rIds){
                    $roles=Role::where('id',$rIds)->first();
                    $names[]= $roles->name;
                }
                return view('user.dashboard',compact('names'));
            }else{
            }
        }else{
            return redirect()->back();
        }
    }
    public function rolesModel(){
        return view('user.dashboard');  
    }
    public function authLogin(Request $request){
        $email=$request->email;
        $password= $request->password;
        $userData= Auth::attempt($request->only('email','password'));
        if($userData){
            $user= Auth()->user();
            $userId= $user->id;
            $userRoleData=UserRole::where('userId',$userId)->get();    
            foreach($userRoleData as $urd){
                $roleId[]= $urd->roleId;
            }
            foreach($roleId as $rIds){
                $roles=Role::where('id',$rIds)->first();
                $names[]= $roles->name;
            }
            return view('user.dashboard',compact('names'));
        }else{
            return redirect()->back();
        }
    }   
}
