<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\userFiles;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use App\ToDo;
use View;

class ToDoCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $allToDo = ToDo::where('uid', $user_id)->orderBy('created_at', 'asc');
        return View::make('todo.index')->with([
            'allToDo' =>  $allToDo,
            'userId' => $user_id

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('todo.create');
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
            'body' => 'required',
            'uid' => 'required',
            ));
        if ($request) {
            $newToDo = new ToDo;
            $newToDo->body = $request->body;
            $newToDo->date_from = $request->date_from;
            $newToDo->date_to = $request->date_to;
            $newToDo->uid = $request->uid;
            $newToDo->save();
            if(!empty($request->file('file'))){
                      $files = $request->file('file');
                      foreach ($files as $file) {
                          //Move Uploaded File
                      $destinationPath = 'uploads/files/' . $request->uid . '/' . date('m-d-Y', time());
                      $file->move($destinationPath, $file->getClientOriginalName());
                      $saveFile = $destinationPath . '/' . $file->getClientOriginalName();
             
                         //  Now save the file in our database 
                        $fileDB = new userFiles;
                        $fileDB->uid = $request->uid;
                        $fileDB->nid = $newToDo->id;
                        $fileDB->ntype = 'todo';
                        $fileDB->file = $saveFile;
                        $fileDB->ftype = $file->getClientOriginalName();
                        $fileDB->save();
                      }
             }
        }
        return redirect()->route('my_to_do_list.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $todo = ToDo::find($id);
        $files = userFiles::where('nid', $id)->where('ntype', 'todo');
        return View::make('todo.show')->with([
            'todo'=>$todo,
            'files'=> $files 
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = ToDo::find($id);
        $files = userFiles::where('nid', $id)->where('ntype', 'todo')->orderBy('id', 'asc');
        return View::make('todo.edit')->with([
            'todo'=>$todo,
            'files'=> $files,
        ]);
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
        // validate the data
        $this->validate($request, array(
            'body' => 'required',
            'uid' => 'required',
            ));
            $newToDo = ToDo::find($id);
            $newToDo->body = $request->body;
            $newToDo->date_from = $request->date_from;
            $newToDo->date_to = $request->date_to;
            $newToDo->uid = $request->uid;
            $newToDo->save();

        // check if file exist
            if(!empty($request->file('file'))){
                $files = $request->file('file');
                foreach ($files as $file) {
                    $checkFile = userFiles::where('ftype', $file->getClientOriginalName())->where(['ntype' => 'todo', 'nid' => $newToDo->id]);
                    if ($checkFile->count() > 0) {
                        $files = $checkFile->first();
                    }else{
                          //Move Uploaded File
                          $destinationPath = 'uploads/files/' . $request->uid;
                          $file->move($destinationPath, $file->getClientOriginalName());
                          $saveFile = $destinationPath . '/' . $file->getClientOriginalName();
                 //  Now save the file in our database 
                        $fileDB = new userFiles;
                        $fileDB->uid = $request->uid;
                        $fileDB->nid = $newToDo->id;
                        $fileDB->ntype = 'todo';
                        $fileDB->file = $saveFile;
                        $fileDB->ftype = $file->getClientOriginalName();
                        $fileDB->save();
                }
             }
            }
        $files = userFiles::where('nid', $id)->where('ntype', 'todo')->orderBy('id', 'asc');
        Session::flash('Success', 'Updated Successfully.');
        return redirect()->route('my_to_do_list.show', $newToDo->id)->with([
            'todo'=>$newToDo,
            'files'=> $files 
        ]);;
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
