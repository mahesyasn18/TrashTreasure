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
        $title = 'News';
        return view("page.admin.news.index", compact('title'));
    }

    public function getNewsData(Request $request)
    {
        $totalFilteredRecord = $totalDataRecord = $draw_val = "";
        $columns_list = array(
            0 => 'title',
            1 => 'cover',
            2 => 'tags',
            3 => 'id',
        );

        $totalDataRecord = News::count();

        $totalFilteredRecord = $totalDataRecord;

        $limit_val = $request->input('length');
        $start_val = $request->input('start');
        $order_val = $columns_list[$request->input('order.0.column')];
        $dir_val = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $news_data = News::with('tags')
                ->offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_val, $dir_val)
                ->get();
        } else {
            $search_text = $request->input('search.value');

            $news_data = News::with('tags')
                ->where('title', 'LIKE', "%{$search_text}%")
                ->offset($start_val)
                ->limit($limit_val)
                ->orderBy($order_val, $dir_val)
                ->get();

            $totalFilteredRecord = News::where('title', 'LIKE', "%{$search_text}%")
                ->orWhere('cover', 'LIKE', "%{$search_text}%")
                ->count();
        }

        $data_val = array();
        if (!empty($news_data)) {
            foreach ($news_data as $news_val) {
                $tags = $news_val->tags->pluck('nama')->implode(', '); 
                $newsNestedData['title'] = $news_val->title;
                $newsNestedData['cover'] = "<img class='img-fluid img-thumbnail' src='" . asset('storage/' . $news_val->cover) . "' alt='Image' style='width: 100px;'>";
                $newsNestedData['tags'] = $tags;
                $urlEdit = "news/{$news_val->id}/edit";
                $urlDelete = "news/{$news_val->id}";
                $newsNestedData['options'] = "
                <a href='$urlEdit'>
                    <i class='fas fa-edit fa-lg'></i>
                </a>
                <a style='border: none; background-color:transparent;' class='hapusData' data-id='$news_val->id' data-url='$urlDelete'>
                    <i class='fas fa-trash fa-lg text-danger'></i>
                </a>";
                $data_val[] = $newsNestedData;
            }
        }

        $draw_val = $request->input('draw');
        $get_json_data = array(
            "draw" => intval($draw_val),
            "recordsTotal" => intval($totalDataRecord),
            "recordsFiltered" => intval($totalFilteredRecord),
            "data" => $data_val
        );

        return response()->json($get_json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tags::all();
        return view("page.admin.news.create", compact('tags'));
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
