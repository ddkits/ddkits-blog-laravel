<?php

namespace App\Http\Controllers;

use App\userFiles;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminCont;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use File;

class UserFilesCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = userFiles::where('uid', Auth::user()->id);

        return view('userfiles.index')->with([
            'files' => $files,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if file exist
            if(!empty($request->file('file'))){
                $files = $request->file('file');
                foreach ($files as $file) {
                    $checkFile = userFiles::where('ftype', $file->getClientOriginalName());
                    if ($checkFile->count() > 0) {
                        $files = $checkFile->first();
                        Session::flash('Error', 'File ' . $files->ftype . ' exist already.');
                    }else{
                          //Move Uploaded File
                          $destinationPath = 'uploads/files/' . $request->uid;
                          $file->move($destinationPath, $file->getClientOriginalName());
                          $saveFile = $destinationPath . '/' . $file->getClientOriginalName();
                 //  Now save the file in our database 
                        $fileDB = new userFiles;
                        $fileDB->uid = $request->uid;
                        $fileDB->nid = null;
                        $fileDB->ntype = 'media';
                        $fileDB->file = $saveFile;
                        $fileDB->ftype = $file->getClientOriginalName();
                        $fileDB->save();
                        Session::flash('Success', 'Files uploaded successfully.');
                  }
                }
            }
            
            return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFiles($files)
    {

        // check if file exist
        foreach ($files as $file) {
            $fileDes = $destinationPath . '/' . $file->getClientOriginalName();
            $checkFile = userFiles::where('file', $fileDes);
            if ($checkFile->count() > 0) {
                $files = $checkFile->first();
                Session::flash('Error', 'File ' . $files->ftype . ' exist already.');
            }else{
                  //Move Uploaded File
                  $destinationPath = 'uploads/files/' . $request->uid;
                  $file->move($destinationPath, $file->getClientOriginalName());
                  $saveFile = $destinationPath . '/' . $file->getClientOriginalName();
         //  Now save the file in our database 
                $fileDB = new userFiles;
                $fileDB->uid = $request->uid;
                $fileDB->nid = null;
                $fileDB->ntype = 'media';
                $fileDB->file = $saveFile;
                $fileDB->ftype = $file->getClientOriginalName();
                $fileDB->save();
                Session::flash('Success', 'Files uploaded successfully.');
            }
        }
    
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFile($file, $type, $uid)
    {

        $checkFile = userFiles::where('ftype', $file->getClientOriginalName());
        if ($checkFile->count() > 0) {
            $file = $checkFile->first();
            Session::flash('Error', 'File ' . $files->ftype . ' exist already.');
            $file1 = $checkFile->first()->file;
            return $file;
        }else{
              //Move Uploaded File
              $destinationPath = 'uploads/files/' . $uid;
              $file->move($destinationPath, $file->getClientOriginalName());
              $saveFile = $destinationPath . '/' . $file->getClientOriginalName();
     
        //  Now save the file in our database 
            $fileDB = new userFiles;
            $fileDB->uid = $uid;
            $fileDB->nid = null;
            $fileDB->ntype = $type;
            $fileDB->file = $saveFile;
            $fileDB->ftype = $file->getClientOriginalName();
            $fileDB->save();
            Session::flash('Success', 'Files uploaded successfully.');
            $file1 = $fileDB->file;
            return $file1;
      }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
         $getFile = userFiles::find($id);


         // find if there is any node connected
         $getPost = Post::where(['image'=>$getFile->file]);
         if ($getPost->count() > 0) {
             $getPost = Post::where(['image'=>$getFile->file])->update([
                'image' => 'img/blogImage.png'
             ]);
         }


         $remove = File::delete($getFile->file);
         $del = userFiles::destroy($id);

         Session::flash('Success', 'File removed succesfully.');
         return redirect()->back();
    }
}
