<?php

namespace App\Http\Controllers;

use App\Enums\ModuleEnum;
use App\Http\Requests\Blog\CommentRequest;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Services\BlogService;
use App\Services\RecaptchaService;
use App\Services\SeoService;

class BlogController extends Controller
{
    private const COMMENT_IP_BLOCK_CODE = 1001;

    private const COMMENT_RATE_LIMIT_MINUTES = 15;

    public function __construct(private RecaptchaService $recaptchaService, private SeoService $seoService, private BlogService $blogService) {}

    public function index()
    {
        $this->seoService->module(ModuleEnum::Blog);
        $data = $this->blogService->getIndexData();
        return view(ModuleEnum::Blog->folder().'.index', $data);
    }

    public function show(Blog $blog)
    {
        $this->seoService->show($blog);
        $blog->increment('view_count');
        $data = $this->blogService->getDetailData($blog);
        $data['recaptcha'] = $this->recaptchaService->getConfig();

        return view(ModuleEnum::Blog->folder().'.show', $data);
    }

    public function comment_store(CommentRequest $request, Blog $blog)
    {
        if (! $this->recaptchaService->validation($request->validated())) {
            return back()->with('error', __('recaptcha.failed'));
        }
        try {
            $this->ipControl($request->ip());

            $blog->comments()->create($request->validated());

            return back()->with('success', __('front/blog.comment_success'));
        } catch (\Exception $e) {
            $message = $e->getCode() === self::COMMENT_IP_BLOCK_CODE ? $e->getMessage() : __('front/blog.comment_error');

            return back()->withInput()->with('error', $message);
        }
    }

    private function ipControl($ip): void
    {
        $comment = BlogComment::whereIp($ip)->latest()->first();
        if ($comment) {
            if ($comment->created_at->diffInMinutes(\Carbon\Carbon::now()) < self::COMMENT_RATE_LIMIT_MINUTES) {
                throw new \Exception(__('front/blog.comment_ip_block'), self::COMMENT_IP_BLOCK_CODE);
            }
        }
    }
}
