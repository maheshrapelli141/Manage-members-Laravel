<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Member::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id){
          $member = Member::where('id',$request->id)->first();
          if (!$member) {
            return response()->json(['status'=>false,'type'=>'error','message'=>'Member Not Found'],400);
          }
          unset($request->email);
        } else {
          $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'dob' => 'required',
            'address' => 'required',
          ]);

          if($validator->fails()){
            return response()->json($validator->messages(), 400);
          }  
          $member = new Member;
        }
       
        if (isset($request->firstname)) {
          $member->firstname = $request->firstname;
        }
        if (isset($request->lastname)) {
          $member->lastname = $request->lastname;
        }
        if (isset($request->mobile)) {
          $member->mobile = $request->mobile;
        }
        if (isset($request->email)) {
          $member->email = $request->email;
        }
        if (isset($request->dob)) {
          $member->dob = $request->dob;
        }
        if (isset($request->address)) {
          $member->address = $request->address;
        }

        $member->save();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'data' => $member
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
      return $member;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        if (!$member) {
          return response()->json(['status'=>false,'type'=>'error','message'=>'Member Not Found'],400);
        }
        $member->delete();
        return response()->json([
            'status' => true,
            'type' => 'success',
            'message' => 'Member Deleted Successfully'
        ],202);
    }
}
