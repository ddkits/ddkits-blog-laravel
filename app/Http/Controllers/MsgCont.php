<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Msgs;
use App\friend;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use Redirect;

class MsgCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $uid = Auth::user()->id;
        $messages = Msgs::where('to', $uid);
        return view('msgs.index')->with(
            [
                'msgs' => $messages,
            ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newMsgs()
    {
        $uid = Auth::user()->id;
        $messages = Msgs::where(['to'=> $uid, 'new'=> 1]);
        return $messages;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notNew($id)
    {
        $uid = Auth::user()->id;
        return Msgs::where(['id'=>$id, 'to'=> $uid])->update(['new'=>0]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function outbox()
    {
        $uid = Auth::user()->id;
        $messages = DB::table('msgs')->where('from', $uid)->paginate(10);
        return view('msgs.outbox')->with(
            [
                'msgs' => $messages,
            ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getScript($id)
    {
        $script = '
                   $(document).ready(function(){
                    event.preventDefault();
                        $("#hide-'.$id.'").click(function(){
                            $("#messageBody-'.$id.'").hide("slow");
                        });
                        $("#show-'.$id.'").click(function(){
                            $("#messageBody-'.$id.'").show("slow");
                        });
                    });
                ';
        return $script;
    }
        


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userid = Auth::user()->id;
        $friends = friend::where(['uid1' => $userid, 'status' => 1])
                    ->orwhere(['uid2' => $userid, 'status' => 1])
                    ->get();
        $form_to = [];
            foreach ($friends as $friend) {
                if ($friend->uid1 == $userid) {
                            $userFriend = DB::table('users')->where('id', $friend->uid2)->first();
                           $form_to[$friend->uid1] = $userFriend->firstname . ' ' . $userFriend->lastname ;
                        }
                        if ($friend->uid2 == $userid) {
                           $userFriend = DB::table('users')->where('id', $friend->uid1)->first();
                            $form_to[$friend->uid1] = $userFriend->firstname . ' ' . $userFriend->lastname ;
                        }
            }
        return view('msgs.create')->with([
            'form_to' => $form_to,
        ]);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFriendsList()
    {
        $getFriendsList=[];
        $userid = Auth::user()->id;
        $friends = friend::where(['uid1' => $userid, 'status' => 1])
                    ->orwhere(['uid2' => $userid, 'status' => 1])
                    ->get();
                    foreach ($friends as $friend) {
                        if ($friend->uid1 != $userid) {
                            $userFriend = DB::table('users')->where('id', $friend->uid2)->first();
                           $getFriendsList[] = [$friend->uid1 => $userFriend->firstname . $userFriend->lastname ];
                        }
                        if ($friend->uid2 != $userid) {
                           $userFriend = DB::table('users')->where('id', $friend->uid2)->first();
                           $getFriendsList[] = [$friend->uid2 => $userFriend->firstname . $userFriend->lastname ];
                        }
                    }
        
        return $getFriendsList;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            // validate the data
                $this->validate($request, array(
                    'from' => 'required',
                    'body' => 'required',
                    'to' => 'required',
                ));

            $save_msg = new Msgs;
            $save_msg->from = $request->from;
            $save_msg->to = $request->to;
            $save_msg->body = $request->body;
            $save_msg->reply = ($request->reply) ? $request->reply : 0;
            $save_msg->original = ($request->original) ? $request->original : 0;
            $save_msg->save();

        Session::flash('Success', 'Message sent.');
       return redirect::back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $msg = Msgs::find($id);
        $replies = Msgs::where('original', $id);
        $up = Msgs::where('id', $id)->orwhere('original', $id)->update(['new' => 0]);
        return view('msgs.show')->with([
            'msg'=>$msg,
            'replies' => $replies,
            ]);
    }
     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getReplies($id)
    {
        $replies = Msgs::where('original', $id);
        return $replies;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
