<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' =>  ['required','string','min:5'],
            'excerpt' =>  ['required','string','min:5'],
            'published_at' =>  ['required'],
        ];
        if ($this->method()=='PUT'){
            //
        }
        return $rules;
    }

    public function createPost()
    {
        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'published_at' => $this->published_at
        ]);
        return $post;
    }

    public function updateSku($post)
    {
        $post->update($this->all());

        return $post;
    }
}
