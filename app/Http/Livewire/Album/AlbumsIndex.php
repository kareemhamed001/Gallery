<?php

namespace App\Http\Livewire\Album;

use App\Models\Album;
use App\Models\AlbumImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Monolog\Handler\IFTTTHandler;

class AlbumsIndex extends Component
{
    use WithFileUploads;
    public $album,$albumName,$coverImage,$albumToMoveTo,$searchValue;

    function storeAlbum(){
        $this->validate([
            'albumName'=>'required',
            'coverImage'=>'required|image',
        ]);
        $file=$this->coverImage;
        $ext=$file->getClientOriginalExtension();
        $fileName=time().'.'.$ext;
        $file->storeAs('uploads/albums/covers/',$fileName);

        $finalName='uploads/albums/covers/'.$fileName;

        $album=Album::create([
            'title'=>$this->albumName,
            'cover'=>$finalName
        ]);
        $this->dispatchBrowserEvent('close-modals');
    }

    function emptyFields()
    {

        $this->albumName = null;
        $this->albumId = null;
        $this->albumTitle = null;
        $this->albumToMoveTo = null;
        $this->coverImage = null;

    }

    public function rules()
    {
        return [
            'albumName' => 'required|string|max:50',
            'coverImage' => 'required|image',

        ];
    }

    function setAlbumData($id)
    {
       if ($id){
           $this->album = Album::find($id);
           $this->albumName = $this->album->title;
       }else{
           session('message','try again');
       }
    }

    function destroy($id)
    {
        $album = Album::find($id);
        if ($album) {
            File::delete($album->cover);
            $album->delete();
            $this->dispatchBrowserEvent('close-modals');
            $this->emptyFields();
        }

    }

    function destroyAndMove($id)
    {
        if ($this->albumToMoveTo) {
            $album = Album::find($id);
            $newAlbum = Album::find($this->albumToMoveTo);

            AlbumImage::where('album_id', '=', $album->id)->update(['album_id' => $newAlbum->id]);
            File::delete($album->cover);
            $album->delete();
            $this->dispatchBrowserEvent('close-modals');
            $this->emptyFields();
        }
    }

    function updateAlbum()
    {

        $this->validate([
            'albumName'=>'required',
            'coverImage'=>'nullable|image',
        ]);

        $this->album->title=$this->albumName;

        if ($this->coverImage){

            File::delete($this->album->cover);
            $file=$this->coverImage;
            $ext=$file->getClientOriginalExtension();
            $fileName=time().'.'.$ext;
            $file->storeAs('uploads/albums/covers/',$fileName);
            $finalName='uploads/albums/covers/'.$fileName;

            $this->album->cover=$finalName;
        }

        $this->album->save();
        session('message', 'done');
        $this->dispatchBrowserEvent('close-modals');
        $this->emptyFields();
    }

    public function render()
    {
        $albums=Album::where(function ($query){

            $query->where('title','like','%'.$this->searchValue.'%')
                ->orWhere('id','like','%'.$this->searchValue.'%');
        })->paginate(50);
        return view('livewire.album.albums-index',compact('albums'));
    }
}
