<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Model\Blog;
use AirAroma\Repository\BlogRepository;
use AirAroma\Service\BlogService;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BlogController extends Controller
{

	public function __construct(Request $request, Blog $blog, BlogRepository $blogRepository, BlogService $blogService)
	{
		$this->request = $request;
		$this->blog = $blog;
		$this->blogRepository = $blogRepository;
		$this->blogService = $blogService;
	}

	/*
	* show all blogs
	*/
	public function getBlogs()
	{
		$blogs = $this->blogRepository->blogPosts(['paginate' => 12, 'showFuturePosts' => 'true']);
		return view('admin.blog.list')->with(compact('blogs'));
	}

	/*
	* create a new blog post
	*/
	public function createBlog()
	{
        if ($this->request->isMethod('post')) {
        	
			$fields = [
                'blg_title' => 'required',
                'blg_slug' => 'required|min:4|unique:blogs,blg_slug',
                'blg_date' => 'required',
                'blg_tags' => 'required',
                'blg_content' => 'required',
                'blg_hero' => 'required',
            ]; 

           	$valid = $this->blogService->validateForm($fields); 

            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }
            
            $blog = $this->blogRepository->insertBlog();

            return redirect('admin/blog');
        }

		$options['defaultDate'] = date('Y-m-d');
		$options['newPost'] = true;

		return view('admin.blog.form')->with(compact('options'));
	}

	/*
	* edit an existing blog
	*/
	public function editBlog($id)
	{
		if ($this->request->isMethod('post')) {

			$fields = [
                'blg_title' => 'required',
                'blg_slug' => 'required|unique:blogs,blg_slug,'.$id.',blg_id,blg_web_id,'.websiteId(),
                'blg_date' => 'required',
                'blg_tags' => 'required',
                'blg_content' => 'required',
                'blg_hero' => 'required',
            ]; 

			$valid = $this->blogService->validateForm($fields); 

			if ($valid->fails()) {
				return redirect()->back()->withErrors($valid)->withInput();
			}

			$this->blogRepository->updateBlog($id);

			return redirect('admin/blog');
		}

		$blog = $this->blog->find($id);
        $blog->blg_tags = $blog->tags->lists('blgtag_tag_id')->toArray();
        $blog->blg_date = date('Y-m-d', strtotime($blog->blg_date));

		return view('admin.blog.form')->with(compact('blog'));
	}

	/*
	* delete blog post
	*/
	public function deleteBlog($id)
	{
        if ($this->blogRepository->deleteBlog($id)) {
        	return redirect('admin/blog');
        }
	}
}