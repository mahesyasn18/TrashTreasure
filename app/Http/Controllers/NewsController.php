<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use App\Models\Tags;
use Yajra\Datatables\Datatables;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NewsExport;
use App\Imports\NewsImport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NewsRequest;


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
        Log::info('Showing index news page.');
        return view("page.admin.news.index", compact('title'));
    }

    public function getNewsData(Request $request)
    {
        try{
            if ($request->ajax()) {
                $data = News::with('tags')->get();

                return Datatables::of($data)
                    ->addColumn('id', function($news) {
                        static $index = 0;
                        $index++;
                        return $index;
                    })
                    ->addColumn('cover', function ($news) {
                        if($news->cover == 'cover.png'){
                            $coverUrl = asset('img/default2.png');
                        }else{
                            $coverUrl = asset('storage/' . $news->cover);
                        }
                        return "<img class='img-fluid img-thumbnail' src='" . $coverUrl . "' alt='Image' style='width: 100px;'>";
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
            Log::error("Error while showing data : ".$e->getMessage());
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
        Log::info('Showing create news page.');
        return view("page.admin.news.create", compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        try {
            $cover = $request->file('cover');
            $coverPath = $cover->store('covers', 'public');

            $news = new News();
            $news->title = $request->input('title');
            $news->cover = $coverPath;
            $news->content = $request->input('content');
            $news->save();

            $tags = $request->input('tags');
            $news->tags()->attach($tags);
            $tagNames = $news->tags->pluck('nama')->toArray();

            Log::info('News data saved successfully.', [
                'user_id' => Auth::user()->id,
                'title' => $news->title,
                'tags' => $tagNames,
                'image_cover' => $news->cover,
                'content' => $news->content,
            ]);

            Alert::success('Berhasil', 'Data berhasil ditambah');
            return redirect()->route('news.index');

        } catch (\Exception $e) {
            Log::error('Failed to store news data: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');
            return redirect()->back()->withInput();
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

            Log::info('Showing edit news page.');
            return view("page.admin.news.edit", ['data' => $data, 'tags' => $tags]);
        } catch (\Exception $e) {
            Log::error("Error while showing data : ".$e->getMessage());
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
    public function update(NewsRequest $request, $id)
    {
        try {
            $news = News::find($id);

            if (!$news) {
                return redirect()->back()->with('error', 'Data news tidak ditemukan.');
            }

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
            $tagNames = $news->tags->pluck('nama')->toArray();

            Log::info('News data has been successfully changed.', [
                'user_id' => Auth::user()->id,
                'title' => $news->title,
                'tags' => $tagNames,
                'image_cover' => $news->cover,
                'content' => $news->content,
            ]);

            Alert::success('Berhasil', 'Data berhasil diubah');
            return redirect()->route('news.index');
            
        } catch (\Exception $e) {
            Log::error('Failed to update news data: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

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
            $tagNames = $news->tags->pluck('nama')->toArray();

            Log::info('News data has been successfully deleted.', [
                'user_id' => Auth::user()->id,
                'title' => $news->title,
                'tags' => $tagNames,
                'image_cover' => $news->cover,
                'content' => $news->content,
            ]);

            return response()->json([
                'msg' => 'Data yang dipilih telah dihapus'
            ]);

        }catch(\Exception $e){
            Log::error('Failed to delete news data: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Error while deleting data news: ' . $e->getMessage());
        }
    }

    public function importNews(Request $request){
        try{
            Log::info('News data has been successfully imported.', [
                'user_id' => Auth::user()->id
            ]);

            Excel::import(new NewsImport, $request->file('file')->store('files'));

            return redirect()->back();
        }catch(\Exception $e){
            Log::error('Failed to import news data: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
            ]);
        }
    }

    public function exportNews(Request $request){
        try{
            Log::info('News data has been successfully exported.', [
                'user_id' => Auth::user()->id
            ]);
            return Excel::download(new NewsExport, 'news.xlsx');

        }catch(\Exception $e){
            Log::error('Failed to export news data: ' . $e->getMessage(), [
                'user_id' => Auth::user()->id,
            ]);
        }
    }
}
