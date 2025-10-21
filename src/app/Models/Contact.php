<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
     use HasFactory; 
    protected $fillable = [
         'category_id',
         'first_name',
         'last_name',
         'gender',
         'email',
         'tel',
         'address',
         'building',
         'detail'

     ];

     public function category()
   {
       return $this->belongsTo(Category::class);
   }
   public function scopeKeywordSearch($query, $keyword)
{
  if (!empty($keyword)) {
           // 姓、名、メールアドレスのいずれかにキーワードが含まれる
           $query->where(function ($q) use ($keyword) {
               $q->where('last_name', 'like', '%' . $keyword . '%')
                 ->orWhere('first_name', 'like', '%' . $keyword . '%')
                 ->orWhere('email', 'like', '%' . $keyword . '%');
           });
       }
       return $query;
    }

    public function scopeGenderSearch($query, $gender)
    {
        if (!empty($gender)) {
            $query->where('gender', $gender);
        }
        return $query;

    }
    
    public function scopeCategorySearch($query, $category_id)
    {
        if (!empty($category_id)) {
            $query->where('category_id', $category_id);
        }
        return $query;
}
public function scopeDateStartSearch($query, $date_start)
    {
        if (!empty($date_start)) {
            // 指定された日付の00:00:00以降
            $query->whereDate('created_at', '>=', $date_start);
        }
        return $query;
    }
public function scopeDateEndSearch($query, $date_end)
    {
        if (!empty($date_end)) {
            // 指定された日付の23:59:59以前
            $query->whereDate('created_at', '<=', $date_end);
        }
        return $query;
    }
    public function scopeContentSearch($query, $content)
    {
        if (!empty($content)) {
            
            $query->whereHas('category', function ($q) use ($content) {
                
                $q->where('content', 'like', '%' . $content . '%');
            });
        }
        return $query;
    }
}