<?php

namespace AirAroma\Repository;

use AirAroma\Model\Blog;
use AirAroma\Model\Blogstag;
use AirAroma\Model\Tagstranslation;
use AirAroma\Model\Website;
use Illuminate\Http\Request as Request;

class BlogRepository
{
    /**
     * Create a respoitory
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \AirAroma\Model\Website $website
     * @param  \AirAroma\Model\Blog $blog
     * @param  \AirAroma\Model\Blogstag $blogsTag
     * @return void
     */
    function __construct(Request $request, Website $website, Blog $blog, Blogstag $blogsTag)
    {
        $this->request = $request;
        $this->website = $website;
        $this->blog = $blog;
        $this->blogsTag = $blogsTag;
    }

    /**
     * Get blog posts
     *
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function blogPosts($options = [])
    {
        $defaults = ['status' => null, 'approved' => null, 'order' => 'desc', 'paginate' => null, 'showFuturePosts' => false];

        if ($options) {
            $defaults = array_merge($defaults, $options);
        }

        extract($defaults);

        $blogs = $this->blog->where('blg_web_id', websiteId());
        if (! $showFuturePosts) {
            $blogs->whereDate('blg_date', '<=', date('Y-m-d'));
        }
            $blogs->orderby('blg_date', $order);
            $blogs->orderby('blg_id', $order);
        if ($status) {
            $blogs->where('blg_status', $status);
        }
        if ($approved) {
            $blogs->where('blg_approved', $approved);
        }

        if ($paginate) {
            return $blogs->paginate($paginate);
        }
            return $blogs;
    }

    /**
     * Get blog post by slug
     *
     * @param string $blogSlug
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getBlogBySlug($blogSlug)
    {
        return $this->blog
            ->where('blg_web_id', websiteId())
            ->where('blg_slug', $blogSlug)
            ->first();
    }


    /**
     * Get posts by tag slug
     *
     * @param string $tagSlug
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getPostsByTag($tagSlug)
    {
        extract(['status' => 1, 'approved' => 2, 'order' => 'desc', 'limit' => 15]);

        return $this->blog
            ->select('blg_title', 'blg_date', 'blg_slug')
            ->leftJoin('blogstags', function ($join) {
                $join->on('blogstags.blgtag_blg_id', '=', 'blogs.blg_id');
            })
            ->leftJoin('tagstranslations', function ($join) {
                $join->on('tagstranslations.tat_tag_id', '=', 'blogstags.blgtag_tag_id');
            })
            ->where('tagstranslations.tat_web_id', websiteId())
            ->where('tagstranslations.tat_slug', $tagSlug)
            ->where('blogs.blg_web_id', websiteId())
            ->where('blogs.blg_status', $status)
            ->where('blogs.blg_approved', $approved)
            ->orderBy('blogs.blg_date', $order);
    }

    /**
     * Get posts by tag slug
     *
     * @param integer $blogId
     * @return bolean
     */
    public function deleteBlog($blogId)
    {
        if ($this->blog->where('blg_id', $blogId)->delete()) {
            return $this->blogsTag->where('blgtag_blg_id', $blogId)->delete();
        }
    }

    /**
     * Update blog post
     *
     * @param integer $blogId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateBlog($blogId)
    {
        $request = $this->blogFields();
        $blog = $this->blog->where('blg_id', $blogId)->update($request);
        $this->updateBlogTags($blogId, $this->request->get('blg_tags'));
        return $blog;
    }

    /**
     * Insert new blog post
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function insertBlog()
    {
        $request = $this->blogFields();
        $blog = $this->blog->create($request);
        $this->insertBlogTags($blog->blg_id, $this->request->get('blg_tags'));
        return $blog;
    }

    /**
     * Update blog post tags
     *
     * @return void
     */
    public function updateBlogTags($id, $tags)
    {
        $this->blogsTag->where('blgtag_blg_id', $id)->delete();
        $this->insertBlogTags($id, $tags);
    }

    /**
     * Insert new blog tag
     *
     * @param integer $blogId
     * @param array $tags
     * @return void
     */
    public function insertBlogTags($blogId, $tags)
    {
        foreach ($tags as $tag) {
            $this->blogsTag->create([
                'blgtag_blg_id' => $blogId,
                'blgtag_tag_id' => $tag,
            ]);
        }
    }

    /**
     * Get blog fields
     *
     * @return array
     */
    private function blogFields()
    {
        $date = $this->blogDate($this->request->get('blg_date'));

        $request = [
            'blg_web_id' => websiteId(),
            'blg_title' => $this->request->get('blg_title'),
            'blg_slug' => $this->request->get('blg_slug'),
            'blg_date' => $date,
            'blg_content' => $this->request->get('blg_content'),
            'blg_status' => $this->request->get('blg_status'),
            'blg_hero' => $this->request->get('blg_hero'),
            'blg_approved' => $this->request->get('blg_approved')
        ];

        if ($this->request->get('blg_approved') == blogStatus('approved')) {
            $request = array_merge($request, ['blg_slug_locked' => 'true']);
        }

        return $request;
    }


    /**
     * Convert blog date
     *
     * @param string $date
     * @return date
     */
    public function blogDate($date)
    {
        return date('Y-m-d H:i:s', strtotime($date.' '.date('H:i:s')));
    }
}
