<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    : Response
    {
        // Define your configuration, if needed
        $config = [];

        // Configure the Environment with all the extensions you need
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());
        $environment->addExtension(new \League\CommonMark\Extension\TableOfContents\TableOfContentsExtension());
        $environment->addExtension(new \App\Markdown\TableOfContentsSidebarExtension());

        $converter = new MarkdownConverter($environment);

        return Inertia::render('Page/Index', [
            'pages' => Page::all()->map(fn($page) => [
                'id'       => $page->id,
                'name'     => $page->name,
                'markdown' => $converter->convert($page->markdown),
            ])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    : Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    : Response {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    : Response {
        return Inertia::render('Page/Show', [
            'page' => [
                'id'       => $page->id,
                'name'     => $page->name,
                'markdown' => Markdown::convert($page->markdown)->getContent(),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    : Response {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $page)
    : Response {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    : Response {
        //
    }
}
