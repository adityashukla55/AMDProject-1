<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\User;
use App\Models\Group;
use App\Models\Groupuser;
use Illuminate\Http\Request;
Use \Carbon\Carbon;
Use DB;
use Auth;
use Redirect;

class JoingroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groupusers= Groupuser::where('user_id',  Auth::user()->id)->get();
        return view('joingroups.index',compact('groupusers'))->with('i', (request()->input('page', 1) - 1) * 5);  
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $meetings = Meeting::where('hidden', '0')->get();
        $groups = Group::all();
        // whereRaw('filled < count_limit')->get();
        return view('joingroups.create', compact('groups','meetings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required',
        ]);

        $user = Groupuser::where('user_id' , Auth::user()->id)->first();

        if (!$user) {

            // dd(Auth::user()->id);

            $data = new Groupuser;
            $data->group_id = $request->group_id;
            $data->user_id = auth()->user()->id;
            $data->joined = '1';
            $data->save();

            DB::table('groups')->where('id', $request->group_id)->increment('filled',1);    
        }
        else {

            $user1 = DB::table('groups')->where('user_id' , $user->user_id)->first();

            // dd($user1);

            if (!$user1) {

                DB::table('groups')->where('id', $user->group_id)->decrement('filled',1);            
                DB::table('group_user')->where('user_id' , $user->user_id)->update(['group_id' => $request->group_id ]);      
                DB::table('groups')->where('id', $request->group_id)->increment('filled',1);
                
                // $gro = DB::table('group_user')->where('group_id', $user->group_id)->
                //                 where('created_at' , function($q) {
                //                     $q->selectRaw('MIN(created_at)')->from('group_user');
                //                 })->get();

                // dd($gro);
                // $us = Groupuser::where('group_id', $user1->group_id)->where('created_at', '>', $user1->created_at)->first();
  
                return redirect()->route('joingroups.index')->with('success','Group Changed successfully.');
            }
            else {
                

                DB::table('groups')->where('id', $user1->id)->decrement('filled',1); 
               
                $user3 = DB::table('group_user')->where('group_id' , $user1->id)->orderBy('created_at', 'ASC')->skip(1)->first();
                // dd($user3);
                if (!$user3) {
                    DB::table('group_user')->where('user_id', $user1->user_id)->where('group_id' , $user1->id)->update(['group_id' => $request->group_id , 'created_at' => Carbon::now()]);
                    DB::table('groups')->where('id', $request->group_id)->increment('filled',1);
                } 
                else {
                    DB::table('groups')->where('id', $user1->id)->update(['user_id' => $user3->user_id]);
                    DB::table('group_user')->where('user_id', $user1->user_id)->where('group_id' , $user1->id)->update(['group_id' => $request->group_id , 'created_at' => Carbon::now()]);
                    DB::table('groups')->where('id', $request->group_id)->increment('filled',1);
                } 
                return redirect()->route('joingroups.index')->with('success','Group Changed successfully.');

            }
        }
        // $groupuser = Groupuser::create($request->all());

        return redirect()->route('joingroups.index')
                        ->with('success','Group Joined successfully.');
    }

    public function leave(Groupuser $groupuser)
    {
        $cuser = DB::table('groups')->where('user_id', Auth::user()->id)->first();

        if(!$cuser) {
            $us = DB::table('group_user')->where('user_id', Auth::user()->id)->first();
            DB::table('groups')->where('id', $us->group_id)->decrement('filled',1);
            DB::table('group_user')->where('user_id', Auth::user()->id)->delete();
            return redirect()->route('groups.index')->with('success','Group left successfully');
        }
        else if($cuser) {

            $user1 = DB::table('group_user')->where('group_id', $cuser->id)->where('user_id' , $cuser->user_id)->first();
        
     
            $us = Groupuser::where('group_id', $user1->group_id)->where('created_at', '>', $user1->created_at)->first();
            // $us = Groupuser::where('group_id', $user1->group_id)->orderBy('created_at', 'ASC')->skip(1)->first();

            if (!$us) {
                Group::where('id', $user1->group_id)->decrement('filled',1);
                DB::table('group_user')->where('user_id', Auth::user()->id)->delete();          
            }
            else {
                DB::table('groups')->where('id', $user1->group_id)->update(['user_id' => $us->user_id]);
                Group::where('id', $user1->group_id)->decrement('filled',1);
                DB::table('group_user')->where('user_id', Auth::user()->id)->delete();
            }
            return redirect()->route('groups.index')->with('success','Group left successfully');
        }
        else {
            return Redirect::back()->withErrors('Something else happened!');
        }
    }

    public function destroy(Groupuser $groupuser)
    {
        $user = User::select('id','group_id')->where('id', Auth::user()->id)->delete();
        if ($user) {
            return redirect()->route('groups.index')->with('success','Group left successfully');
        }
        else {
            return Redirect::back()->withErrors('Joined Group not found');
        }   
    }
}
