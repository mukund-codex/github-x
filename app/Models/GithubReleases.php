<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GithubReleases extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tag_name',
        'description',
        'url',
        'published_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    public function graphqlQuery()
    {
        return <<<'GRAPHQL'
        {
          repository(owner: "founderandlightning", name: "fl-laravel_boilerplate") {
            releases(last: 10) {
              edges {
                node {
                  name
                  tagName
                  description
                  publishedAt
                  url
                }
              }
            }
          }
        }
        GRAPHQL;
    }
}
