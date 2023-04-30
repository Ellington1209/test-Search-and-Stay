<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStore extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'isbn', 'value'];

    public function rules() {
        return [
            'name' => 'required|unique:book_stores,name,'.$this->id.'|min:3',
            'isbn' => 'required|numeric|unique:book_stores',
            'value' => 'required|numeric',
        ];
    }


}
