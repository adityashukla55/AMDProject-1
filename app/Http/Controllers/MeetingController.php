<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Group;
use App\Models\Groupuser;;
use Illuminate\Http\Request;
Use \Carbon\Carbon;
Use DB;
use Auth;

class MeetingController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::table('meetings')->where('end_time' , '<=', Carbon::now()->toDateTimeString())->update(['hidden' => "1"]);

        $meetings = Meeting::where('hidden', '0')->get();
        $groupusers= Groupuser::all();

        return view('meetings.index',compact('meetings','groupusers'))->with('i', (request()->input('page', 1) - 1) * 5);  
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hidden()
    {
        $meetings = Meeting::where('hidden', '1')->get();

        $groupusers= Groupuser::all();

        return view('meetings.hidden',compact('meetings','groupusers'))->with('i', (request()->input('page', 1) - 1) * 5);  
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        return view('meetings.create', compact('groups'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $date=Carbon::now()->today()->format('H:i:m');
        $date = Carbon::now()->toDateTimeString();

        $request->validate([
            'name' => 'required|string|max:25',
            'location' => 'required|string',
            'group_id' => 'required|unique:meetings,group_id',
            'start_time'=> "required|date|after_or_equal:$date",
            'end_time' => 'required|date|after:start_time',
        ]);

        $meeting = Meeting::create($request->all());
  
        return redirect()->route('meetings.index')
                        ->with('success','Meeting created successfully.')
                        ->with('status', __('New meeting has been created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function show(Meeting $meeting)
    {
        $meeting->load('group');
        $groupusers= Groupuser::all();

        return view('meetings.show', compact('meeting','groupusers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function edit(Meeting $meeting)
    {

        // $groups = Group::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $meeting->load('group');
        $groups = Group::all();

        return view('meetings.edit', compact('meeting', 'groups'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meeting $meeting)
    {
        $date = Carbon::now()->toDateTimeString();

        $request->validate([
            'name' => 'required|string|max:25',
            'location' => 'required|string',
            'group_id' => 'required',
            'start_time'=> "required|date|after_or_equal:$date",
            'end_time' => 'required|date|after:start_time',
        ]);

        $meeting->update($request->all());

        return redirect()->route('meetings.index')
                        ->with('success','Meeting updated successfully')
                        ->with('status', __('The meeting has been edited'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meeting  $meeting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meeting $meeting)
    {
        $group = Group::where('id' , '=', $meeting->group_id)->delete();
        $meeting->delete();
        
        return redirect()->route('meetings.index')
                        ->with('success','Meeting deleted successfully');
    }
}
