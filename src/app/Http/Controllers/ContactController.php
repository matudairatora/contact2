<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){

        return view('contact.index');
    }

    public function confirm(Request $request)
    {
        
        $tel = $request->input('tel_part1') . $request->input('tel_part2') . $request->input('tel_part3');
        
        $data = $request->except(['_token', 'tel_part1', 'tel_part2', 'tel_part3']);
        $data['tel'] = $tel;

        return view('contact.confirm', compact('data'));
    }
    public function send(Request $request)
    {
        $contact = $request->only([
            'category_id', 'first_name', 'last_name', 'gender', 'email', 'tel', 'address', 'building', 'detail'
        ]); 

        DB::table('contacts')->insert($contactData);

        return redirect('/thanks');
    }
}
