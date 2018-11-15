<?php

namespace AirAroma\Controller\Admin;


use AirAroma\Repository\GalleryRepository;
use App\Http\Controllers\Controller;
use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem as File;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Validation\Factory as Validator;


class GalleryController extends Controller
{

    public function __construct(Validator $validator, Response $response, File $file, FilesystemManager $storage, Config $config, Request $request, GalleryRepository $galleryRepository)
    {
        $this->config = $config;
        $this->request = $request;
        $this->storage = $storage;
        $this->file = $file;
        $this->response = $response;
        $this->validator = $validator;
        $this->galleryRepository = $galleryRepository;

        $this->websiteId = websiteId();
    }

    public function blogModal()
    {
        $images = $this->galleryRepository->getImages()['blog'][$this->websiteId];
        $path = $this->galleryRepository->getBlogImagePath();

        arsort($images);

    	return view('admin.blog.gallery')->with(compact('images', 'path'));
    }

    public function blogDeleteImage($id)
    {
        $path = $this->galleryRepository->getBlogImagePath();
        $file = $path.'/'.$this->websiteId.'/'.$id;
        if ($this->file->exists($file))
        {
            $this->storage->disk('public')->delete($file);
            return $this->response->json(['status' => 'file deleted']);
        }
        return $this->response->json(['status' => 'file does not exist']);
    }

    public function clientDeleteImage($id)
    {
        $path = $this->galleryRepository->getClientImagePath();
        $file = $path.'/'.$id;
        if ($this->file->exists($file))
        {
            $this->storage->disk('public')->delete($file);
            return $this->response->json(['status' => 'file deleted']);
        }
        return $this->response->json(['status' => 'file does not exist']);
    }


    public function blogUploadImage()
    {
        $path = $this->galleryRepository->getBlogImagePath();

        $rules = [
            'gallery-modal-fileupload' => 'required|mimes:jpeg,png|max:600'
        ];

        $valid = $this->validator->make($this->request->all(), $rules);

        if ($valid->fails()) {
            return $this->response->json(['status' => 'fail']);
        } else {
            $uploadedfile = $this->request->file('gallery-modal-fileupload');
            //$extension = $uploadedfile->getClientOriginalExtension();
            $file = $uploadedfile->getClientOriginalName();

            //$file = $hash.'.'.$extension;

            $this->storage->disk('public')->put($path.'/'.$file, $this->file->get($uploadedfile));
            $this->storage->disk('public')->put($path.'/'.$this->websiteId.'/'.$file, null);

            return $this->response->json(['status' => 'success']);
        }
    }

    public function bannerUploadImage()
    {
        $path = $this->galleryRepository->getBannerImagePath();


        $rules = [
            'gallery-modal-fileupload' => 'required|mimes:jpeg,png|max:600'
        ];

        $valid = $this->validator->make($this->request->all(), $rules);

        if ($valid->fails()) {
            return $this->response->json(['status' => 'fail']);
        } else {

            $uploadedfile = $this->request->file('gallery-modal-fileupload');
            //$extension = $uploadedfile->getClientOriginalExtension();
            $file = $uploadedfile->getClientOriginalName();

            //$file = $hash.'.'.$extension;

            $this->storage->disk('public')->put($path.'/'.$file, $this->file->get($uploadedfile));
            $this->storage->disk('public')->put($path.'/'.$this->websiteId.'/'.$file, null);

            return $this->response->json(['status' => 'success']);
        }
    }

    public function clientUploadImage()
    {
        $path = $this->galleryRepository->getClientImagePath();

        $rules = [
            'gallery-modal-fileupload' => 'required|mimes:jpeg,png|max:600'
        ];

        $valid = $this->validator->make($this->request->all(), $rules);

        if ($valid->fails()) {
            return $this->response->json(['status' => 'fail']);
        } else {
            $uploadedfile = $this->request->file('gallery-modal-fileupload');
            //$extension = $uploadedfile->getClientOriginalExtension();
            //$hash = $this->file->get($uploadedfile);
            $file = $uploadedfile->getClientOriginalName();

            //$file = $hash.'.'.$extension;

            $this->storage->disk('public')->put($path.'/'.$file, $this->file->get($uploadedfile));
            //$this->storage->disk('public')->put($path.'/'.$this->websiteId.'/'.$file, null);

            return $this->response->json(['status' => 'success']);
        }
    }

    public function bannerModal()
    {
        $images = $this->galleryRepository->getImages()['banners'][$this->websiteId];
        $path = $this->galleryRepository->getBannerImagePath();

        arsort($images);

        return view('admin.banners.gallery')->with(compact('images', 'path'));
    }

    public function clientModal()
    {
        $images = $this->galleryRepository->getImages()['clients']['featured'];
        $path = $this->galleryRepository->getClientImagePath();

        arsort($images);

        return view('admin.clients.gallery')->with(compact('images', 'path'));
    }

}