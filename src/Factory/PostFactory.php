<?php

namespace App\Factory;

use App\Entity\Post;
use DateTime;

class PostFactory
{
	public function create(string $title, string $body, ?string $summary = null, $status = 1)
	{
		$post = new Post();
		$post->setTitle($title);
		$post->setBody($body);
		if ($summary) {
			$post->setSummary($summary);
		} else {
			$post->setSummary(mb_substr(strip_tags($body), 0, 50));
		}
		$post->setStatus($status);
		$post->setCreatedAt(new DateTime());
        $post->setPostImage('');
		return $post;
	}
}