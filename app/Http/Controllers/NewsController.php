<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use App\Models\Tags;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;


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
        try{
            if ($request->ajax()) {
                $data = News::with('tags')->get();

                return Datatables::of($data)
                    ->addColumn('id', function($row) {
                        static $index = 0;
                        $index++;
                        return $index;
                    })
                    ->addColumn('cover', function ($news) {
                        return "<img class='img-fluid img-thumbnail' src='" . asset('storage/' . $news->cover) . "' alt='Image' style='width: 100px;'>";
                    })
                    ->addColumn('tags', function ($news) {
                        return $news->tags->pluck('nama')->implode(', ');
                    })
                    ->addColumn('options', function ($news) {
                        return "<a href='news/{$news->id}/edit'><i class='fas fa-edit fa-lg'></i></a>
                                <a style='border: none; background-color:transparent;' class='hapusData' data-id='$news->id' data-url='news/{$news->id}'><i class='fas fa-trash fa-lg text-danger'></i></a>";
                    })
                    ->rawColumns(['cover', 'options'])
                    ->make(true);
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error while showing data: ' . $e->getMessage());
        }
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

            Alert::success('Berhasil', 'Data berhasil ditambah');
            return redirect()->route('news.index');
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

            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect()->route('news.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Error while updating data news: ' . $e->getMessage());
            return redirect()->back();
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

            return response()->json([
                'msg' => 'Data yang dipilih telah dihapus'
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error while deleting data news: ' . $e->getMessage());
        }
    }
}
