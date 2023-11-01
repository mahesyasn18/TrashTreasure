<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use App\Models\Tags;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = News::with('tags')->get();
        return view("page.admin.news.index", ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $tags = Tags::all();
            return view("page.admin.news.create", compact('tags'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while shows data news ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'tags' => 'array',
            ]);

            $cover = $request->file('cover');
            $coverPath = $cover->store('covers', 'public');

            $news = new News();
            $news->title = $request->input('title');
            $news->cover = $coverPath;
            $news->content = $request->input('content');
            $news->save();

            $tags = $request->input('tags');
            $news->tags()->attach($tags);

            return redirect()->route('news.index')->with('success', 'Data news succefully created!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while create data news ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = News::with('tags')->findOrFail($id);
            $tags = Tags::all();

            if (!$data) {
                return redirect()->back()->with('error', 'Data news tidak ditemukan.');
            }

            return view("page.admin.news.edit", ['data' => $data, 'tags' => $tags]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while showing news data: ' . $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $news = News::find($id);

            if (!$news) {
                return redirect()->back()->with('error', 'Data news tidak ditemukan.');
            }

            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'tags' => 'array',
            ]);

            // Update the news data
            $news->title = $request->input('title');
            $news->content = $request->input('content');

            if ($request->hasFile('cover')) {
                // Handle the cover image update
                $newCover = $request->file('cover');
                $coverPath = $newCover->store('covers', 'public');

                Storage::delete('public/' . $news->cover);
                
                $news->cover = $coverPath;
            }

            $news->save();

            // Update the associated tags
            $tags = $request->input('tags');
            $news->tags()->sync($tags);

            return redirect()->route('news.index')->with('success', 'Data news successfully updated!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error while updating data news: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $news = News::find($id);

            if (!$news) {
                return redirect()->back()->with('error', 'Data news tidak ditemukan.');
            }

            Storage::delete('public/' . $news->cover);
            $news->delete();

            return redirect()->route('news.index')->with('success', 'Data news successfully deleted!');

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error while deleting data news: ' . $e->getMessage());
        }
    }
}
