<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:news,slug',
            'short_description' => 'nullable|string',
            'content'           => 'required|string',
            'image_url'         => 'nullable|url',
            'source_url'        => 'required|url',
            'published_at'      => 'nullable|date',
        ]);

        News::create($request->all());

        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:news,slug,' . $news->id,
            'short_description' => 'nullable|string',
            'content'           => 'required|string',
            'image_url'         => 'nullable|url',
            'source_url'        => 'required|url',
            'published_at'      => 'nullable|date',
        ]);

        $news->update($request->all());

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }

    /**
     * Fetch news data from a given URL.
     */
    public function fetchNewsData(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        $url = $request->input('url');
        $data = $this->newsService->fetchNewsContent($url);

        if ($data) {
            return response()->json(['success' => true, 'news' => $data]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to fetch news content. Please check the URL or try again later.']);
    }
}
