<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Reg;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = session('user');

        if (!$user) {
            return view('users.login');
        }

        // Load registrations using Eloquent and return early
        $user_regs = Reg::with(['user', 'course'])
            ->where('user_id', $user->id)
            ->get();
        return view('users.index', compact('user', 'user_regs'));

        // Legacy query below (unreached)
        $user_regs = \DB::table('regs')
            ->join('users', 'regs.user_id', '=', 'users.id')
            ->join('courses', 'regs.course_id', '=', 'courses.id')
            ->select('regs.*','users.name', 'courses.*')
            ->where('users.id', $user->id)
            ->get();

        $urs = Reg::with(['user', 'course'])->where('user_id', $user->id)->get();

        // Use Eloquent result for rendering instead of raw DB join
        $user_regs = Reg::with(['user', 'course'])
            ->where('user_id', $user->id)
            ->get();


        // foreach($urs as $reg) {
        //     echo $reg->user->name . ' - ' . $reg->course->topic . '<br>';
        // }

        return view('users.index' , compact('user','user_regs'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        // dd($request->all());
        
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:email',
        //     'password' => 'required|string|min:6',
        // ]);


        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('users.index')->with('success', 'สมัครสมาชิกเรียบร้อยแล้ว');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function login(Request $request)
    {
        //


        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            $request->session()->flash('message', 'ชื่อผู้ใช้ หรือ รหัสผ่านไม่ถูกต้อง!');
            return Redirect::back();
        }

        session(['user' => $user]);

        return redirect()->route('users.index')->with('success', 'เข้าสู่ระบบเรียบร้อยแล้ว');
    }


    function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('users.index')->with('success', 'ออกจากระบบเรียบร้อยแล้ว');
        
    }





}
