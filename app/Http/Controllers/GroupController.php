<?php
    
namespace App\Http\Controllers;
    
use App\Models\Group;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Auth;
use Redirect;
use DB;
use App\Models\Groupuser;

    
class GroupController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::table('groups')->where('filled', 0 )->delete(); 

        $groups = Group::latest()->paginate(5);     
        $groupusers= Groupuser::all();

        return view('groups.index',compact('groups','groupusers'))->with('i', (request()->input('page', 1) - 1) * 5);  
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Groupuser::select('user_id')->where('user_id' , '=', auth()->user()->id)->first();

        if(!$user) {
            return view('groups.create');
        }
        else{
            return Redirect::back()->withErrors('Multiple groups cannot be created.');
        }
    }
   
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'topic' => 'required',
            'description' => 'required',
            'count_limit' => 'required',
        ]);

        $group = new Group();
        $group->topic = $request->topic;
        $group->description = $request->description;
        $group->count_limit = $request->count_limit;
        $group->user_id = auth()->user()->id;
        $group->filled = '1';
        $group->save();

        $groupuser = new Groupuser();
        $groupuser->user_id = auth()->user()->id;
        $groupuser->group_id = $group->id;
        $groupuser->joined = '1';
        $groupuser->save();
    
        // Group::create($request->all());
    
        return redirect()->route('groups.index')
                        ->with('success','Group created successfully.');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $groupusers= Groupuser::all();
        return view('groups.show',compact('groupusers'),[ 'group' => $group]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {  
        $user = Group::select('user_id')->where('user_id' , '=', auth()->user()->id)->get()->first();
        
        if ($user)  {
            return view('groups.edit',compact('group'));
        }
        else {
            return Redirect::back()->withErrors('No Permission');
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        request()->validate([
            'topic' => 'required',
            'description' => 'required',
            'count_limit' => 'numeric',
        ]);

        $group->topic = $request->topic;
        $group->description = $request->description;
        $group->count_limit = $request->count_limit;
        $group->save();

        // $group->update($request->all());
        return redirect()->route('groups.index')->with('success','Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        // dd($group->id);
        DB::table('group_user')->where('group_id', $group->id )->delete(); 
        $group->delete();    
        return redirect()->route('groups.index')->with('success','Group deleted successfully');   
    }
}
