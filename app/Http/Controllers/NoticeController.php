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
        return Notice::with('notice_type')->orderBy('created_at', 'DESC')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        if($request->hasFile('document_a')){
            $file = $request->file('document_a'); 
            $nombre_unico = 'files/'.uniqid().'.'.$file->getClientOriginalExtension();
            Storage::disk('uploads')->put($nombre_unico,  File::get($file));
            $request['document'] = 'uploads/'.$nombre_unico;
        }
        else{
            $request['document'] = null;
        }
        if($request->hasFile('img_a')){
            $file = $request->file('img_a'); 
            $nombre_unico = 'files/'.uniqid().'.'.$file->getClientOriginalExtension();
            Storage::disk('uploads')->put($nombre_unico,  File::get($file));
            $request['img'] = 'uploads/'.$nombre_unico;
            //return $request->get('img');
        }
        else{
            $request['img'] = null;
        }
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
        if($request->hasFile('document_update')){
            if($notice->document != null){
                unlink(public_path($notice->document));
            }
            $file = $request->file('document_update'); 
            $nombre_unico = 'files/'.uniqid().'.'.$file->getClientOriginalExtension();
            Storage::disk('uploads')->put($nombre_unico,  File::get($file));
            $request['document'] = 'uploads/'.$nombre_unico;
        }
        else{
            $request['document'] = $notice->document;
        }
        if($request->hasFile('img_update')){
            if($notice->img != null){
                unlink(public_path($notice->img));
            }
            $file = $request->file('img_update'); 
            $nombre_unico = 'files/'.uniqid().'.'.$file->getClientOriginalExtension();
            Storage::disk('uploads')->put($nombre_unico,  File::get($file));
            $request['img'] = 'uploads/'.$nombre_unico;
        }
        else{
            $request['img'] = $notice->img;
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
        if($notice->document != null){
            unlink(public_path($notice->document));
        }
        if($notice->img != null){
            unlink(public_path($notice->img));
        }
        $notice->delete();
        return $notice;
    }
}
