<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class NoticeController extends Controller
{
    public function main(){
        return view('notices.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Notice::with('notice_type')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file'); 
        $nombre_unico = 'files/'.uniqid().'.'.$file->getClientOriginalExtension();
        Storage::disk('uploads')->put($nombre_unico,  File::get($file));
        $request['document'] = 'uploads/'.$nombre_unico;
        return Notice::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Notice::findOrFail($id);
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
        $notice = Notice::findOrFail($id);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            unlink(public_path($notice->document));
            // Storage::delete($notice->document);
            $nombre_unico = 'files/'.uniqid().'.'.$file->getClientOriginalExtension();
            Storage::disk('uploads')->put($nombre_unico,  File::get($file));
            $request['document'] = 'uploads/'.$nombre_unico;
        }
        else{
            $request['document'] = $notice->document;
        }
        $notice->fill($request->all());
        $notice->save();
        return $notice;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        unlink(public_path($notice->document));
        // Storage::delete('/'.$notice->document);
        $notice->delete();
        return $notice;
    }
}
