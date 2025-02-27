<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserInvitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class UserInvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.userInvitations.index');

    }


    public function invitationsWithYajra(Request $request)
    {
        if($request->ajax()){
            $invitations=UserInvitation::orderBy('created_at','desc')->select('user_invitations.*');

            return DataTables::of($invitations)
                ->addIndexColumn()
                ->make(true);
        }

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
        //
            $invite=new UserInvitation();
            $invite->name= $request->input('name');
            $invite->email= $request->input('email');
            $invite->phone= $request->input('phone');
            $invite->password= $request->input('password');
            $invite->status='Sent';
            $invite->invitation_time= Carbon::now();
            $invite->invitation_expiry= Carbon::now()->addHour(24);

            $invite->save();

            Session::flash('message','Invitation Sent Successfully!');

            return response()->json([
                'message'=> 'Invitation sent Successfully!'
            ]);
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
}
