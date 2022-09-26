<div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add album</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{--                <form  method="post" action="{{route('albums.store')}}" enctype="multipart/form-data">--}}

                <div class=" mb-3">
                    <label class="form-label" for="">title</label>
                    <input class="form-control" type="text" name="title" value="{{old('title')}}"
                           wire:model="albumName">

                    @error('albumName')<p class="alert-danger">{{$message}}</p>@enderror

                </div>
                <div class=" mb-3">
                    <label class="form-label" for="">Cover Image</label>
                    <input class="form-control" type="file" name="image" wire:model="coverImage">
                    @error('coverImage')<p class="alert-danger">{{$message}}</p>@enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:click="storeAlbum">Add</button>
                </div>
                {{--                </form>--}}
            </div>

        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Album {{$albumName}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @if($album && $this->album->images->count()>0 && $albums->count()>1)
                    <label for="">Select album to move images</label>
                    <select class="form-select" name="" id="" required wire:model.defer="albumToMoveTo">
                        <option value="" selected>--select album--</option>
                        @foreach($albums as $albumval)
                            @if($albumval->id != $album->id )
                                <option value="{{$albumval->id}}">{{$albumval->title}}</option>
                            @endif
                        @endforeach
                        <option value=""></option>
                    </select>
                @else
                    <p>delete this Album?</p>
                @endif


                <div class="mt-2">
                    <button class="btn btn-danger" type="button" wire:click="destroy({{$album?$album->id:''}})">
                        @if($album&& $this->album->images->count()>0&&$albums->count()>1)
                            Delete with images
                        @else
                            yes delete
                        @endif

                    </button>
                    @if($album&&$this->album->images->count()>0&&$albums->count()>1)
                        <button class="btn btn-primary" type="button"
                                wire:click="destroyAndMove({{$album?$album->id:''}})">
                            Delete and move images
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Album </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class=" mb-3">
                    <label class="form-label" for="">title</label>
                    <input class="form-control" type="text" name="title" value="{{old('title')}}"
                           wire:model="albumName">

                    @error('albumName')<p class="alert-danger">{{$message}}</p>@enderror

                </div>
                <div class=" mb-3">
                    <label class="form-label" for="">Cover Image</label>
                    <input class="form-control" type="file" name="image" wire:model="coverImage">
                    @error('coverImage')<p class="alert-danger">{{$message}}</p>@enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:click="updateAlbum">Edit</button>
                </div>

            </div>

        </div>
    </div>
</div>




