<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Podcast extends Model
{
	protected $fillable = [
		'title', 'artwork_url', 'description','language', 'rss_url', 'website_url'
	];
	public function episodes(){
		return $this->hasMany(Episode::class);
	}
}