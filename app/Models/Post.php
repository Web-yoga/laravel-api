<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	use HasFactory;

	protected $fillable = ['category_id', 
	'title', 
	'annotation_title', 
	'slug', 
	'content', 
	'annotation', 
	'is_published'];

	protected $casts = [
		'is_published' => 'boolean',
	];

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}

	public function getPostList($category_id, $skip, $take)
	{

		$skip = $skip ? $skip : 0;
		$take = $take ? $take : 10;

		$posts =  Post::select('id', 
		'category_id', 
		'title', 
		'annotation_title', 
		'slug', 
		'annotation',
		'is_published', 
		'created_at')
			->where('category_id', $category_id)
			->where('is_published', 1)
			->skip($skip)
			->take($take)
			->get()
			->sortByDesc("created_at");

		foreach ($posts as $post) {
			if (empty($post->annotation_title)) {
				$post->annotation_title = $post->title;
			}
		}

		return $posts;
	}

	public function getPostBySlug($post_slug)
	{
		$post = Post::where('slug', $post_slug)->get();
		return $post;
	}
}
