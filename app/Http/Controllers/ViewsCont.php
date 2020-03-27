<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\views;
use DB;
class ViewsCont extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getViews($nid)
    {
        $views = Views::find($nid)->first();
        return $views->views;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBlogViews($nid)
    {
        $views = DB::table('views')->where('nid', $nid)->first();
        return $views->views;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPostViews($nid)
    {
        $views = DB::table('pro_views')->where('nid', $nid)->first();
        return $views->views;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }
    public function addView($nid)
    {
        $views = DB::table('views')->where('nid', $nid)->first();
        if($views){
                   DB::table('views')
                    ->where('nid', $nid)
                    ->update(['views' => ($views->views + 1)]);
        }else{
            DB::table('views')->insert(
                ['nid' => $nid, 'views' => 0]
            );
        }
    }
    public function addProView($nid)
    {
        $views = DB::table('pro_views')->where('nid', $nid)->first();
        if($views){
                   DB::table('pro_views')
                    ->where('nid', $nid)
                    ->update(['views' => ($views->views + 1)]);
        }else{
            DB::table('pro_views')->insert(
                ['nid' => $nid, 'views' => 0]
            );
        }
    }
}
