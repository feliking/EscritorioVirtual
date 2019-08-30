<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{
    public function main(){
        return view('items.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::with('option')->orderBy('created_at', 'DESC')->get(); 
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
        return Item::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Item::findOrFail($id);
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
        $item = Item::findOrFail($id);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            unlink(public_path($item->document));
            // Storage::delete($notice->document);
            $nombre_unico = 'files/'.uniqid().'.'.$file->getClientOriginalExtension();
            Storage::disk('uploads')->put($nombre_unico,  File::get($file));
            $request['document'] = 'uploads/'.$nombre_unico;
        }
        else{
            $request['document'] = $item->document;
        }
        $item->fill($request->all());
        $item->save();
        return $item;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        unlink(public_path($item->document));
        $item->delete();
        return $item;
    }
}
