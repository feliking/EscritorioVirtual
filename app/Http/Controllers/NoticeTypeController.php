<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NoticeType;
use Auth;

class NoticeTypeController extends Controller
{
    public function main(){
        return view('notice_types.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return NoticeType::with('notices')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return NoticeType::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return NoticeType::findOrFail($id);
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
        $notice_type = NoticeType::findOrFail($id);
        $notice_type->fill($request->all());
        $notice_type->save();
        return $notice_type;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice_type = NoticeType::findOrFail($id);
        $notice_type->delete();
        return $notice_type;
    }

    public function fill($request)
    {
        $request = json_decode($request, true);
        return NoticeType::where($request)->get();
    }
}
