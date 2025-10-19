<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
class ContactController extends Controller
{
    public function index(){

        return view('contact.index');
    }

    public function confirm(CategoryRequest $request)
    {
        
        $tel = $request->input('tel_part1') . $request->input('tel_part2') . $request->input('tel_part3');
        
        $data = $request->except(['_token', 'tel_part1', 'tel_part2', 'tel_part3']);
        $data['tel'] = $tel;
        $gender_map = [
            '1' => '男性',
            '2' => '女性',
            '3' => 'その他', 
        ];
            $data['gender_text'] = $gender_map[$data['gender']];
        
        return view('contact.confirm', compact('data'));
    }
    
    
    public function send(CategoryRequest $request)
    {
        $category_content = $request->input('content');

        $new_category = Category::firstOrCreate([
        'content' => $category_content
        ]);

        $contact = $request->only([
            'category_id', 'first_name', 'last_name', 'gender', 'email', 'tel', 'address', 'building', 'detail'
        ]); 
       $contact['category_id'] = $new_category->id;
       Contact::create($contact);
        return view('contact.thanks');
    }
}
