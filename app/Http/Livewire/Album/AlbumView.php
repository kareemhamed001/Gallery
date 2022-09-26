<?php

namespace App\Http\Livewire\Album;

use App\Models\Album;
use App\Models\AlbumImage;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AlbumView extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme='bootstrap';

    public $albumId,$album,$searchValue,$albums,$albumToMoveTo;
    public $imageName,$image,$imageId;

    function mount(){

        $this->album=Album::find($this->albumId);
        $this->albums=Album::all();
    }

    function emptyFields()
    {
        $this->image = null;
        $this->imageName = null;
    }

    function storeImage(){
        $this->validate([
            'imageName'=>'required|max:50',
            'image'=>'required|image'
        ]);
        if ($this->albumId &&$this->imageName &&$this->image){

            $file=$this->image;
            $ext=$file->getClientOriginalExtension();
            $fileName=time().'.'.$ext;
            $file->storeAs('uploads/albums/images/',$fileName);
            $finalName='uploads/albums/images/'.$fileName;


            AlbumImage::create([
                'album_id'=>$this->albumId,
                'title'=>$this->imageName,
                'image'=>$finalName
            ]);
            $this->dispatchBrowserEvent('close-modals');
            $this->emptyFields();
        }
    }

    function setImageData($id){
        $this->imageId=$id;
        $image=AlbumImage::find($id);
        $this->imageName=$image->title;

    }

    function moveImage(){
        if ($this->imageId && $this->albumToMoveTo){
            $image=AlbumImage::find($this->imageId);
            $image->update([
               'album_id'=> $this->albumToMoveTo
            ]);

            $this->dispatchBrowserEvent('close-modals');
        }
    }

    function updateImage(){

        $this->validate([
            'imageName'=>'required|string|max:50',
            'image'=>'nullable|image',
        ]);

        if ($this->imageId){

            $image=AlbumImage::find($this->imageId);
            if($image){

                $image->title=$this->imageName;

                if ($this->image){

                    $file=$this->image;
                    $ext=$file->getClientOriginalExtension();
                    $fileName=time().'.'.$ext;
                    $file->storeAs('uploads/albums/images/',$fileName);
                    $finalName='uploads/albums/images/'.$fileName;
                    File::delete($image->image);

                    $image->image=$finalName;
                }

                $image->save();

                $this->dispatchBrowserEvent('close-modals');
                session()->flash('message','image update successfully');
            }
        }
    }

    function deleteImage(){
        if ($this->imageId){
            $image=AlbumImage::find($this->imageId);
            if ($image){
                $image->delete();
                File::delete($image->image);
                $this->dispatchBrowserEvent('close-modals');
                session()->flash('message','deleted successfully');
            }else{
                $this->dispatchBrowserEvent('close-modals');
                session()->flash('message','Try Again');
            }
        }
    }
    public function render()
    {
        $images=$this->album->images()->where(function ($query){

            $query->where('title','like','%'.$this->searchValue.'%')
                ->orWhere('id','like','%'.$this->searchValue.'%');
        })->paginate(50);
        return view('livewire.album.album-view',compact('images'));
    }
}
