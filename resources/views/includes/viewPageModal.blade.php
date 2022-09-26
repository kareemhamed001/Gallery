<div wire:ignore.self class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{--                <form  method="post" action="{{route('albums.store')}}" enctype="multipart/form-data">--}}

                <div class=" mb-3">
                    <label class="form-label" for="">Image Name</label>
                    <input class="form-control" type="text" name="title" value="{{old('title')}}"
                           wire:model="imageName">

                    @error('imageName')<p class="alert-danger">{{$message}}</p>@enderror

                </div>
                <div class=" mb-3">
                    <label class="form-label" for="">Image</label>
                    <input class="form-control" type="file" name="image" wire:model="image">
                    @error('image')<p class="alert-danger">{{$message}}</p>@enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:click="storeImage">Add</button>
                </div>
                {{--                </form>--}}
            </div>

        </div>
    </div>
</div>



<div wire:ignore.self class="modal fade" id="moveImageModal" tabindex="-1" aria-labelledby="deleteModal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Move Image </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                @if($albums->count()>1)
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
                    <p>No albums to move to</p>
                @endif

                <div class="mt-2">
                    @if($albums->count()>1)
                        <button wire:click="moveImage" class="btn btn-primary" type="button">
                             move image
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>


<div wire:ignore.self class="modal fade" id="deleteImageModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Delete image?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" wire:click="deleteImage">Delete</button>
            </div>

        </div>
    </div>
</div>

<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Image </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class=" mb-3">
                    <label class="form-label" for="">title</label>
                    <input class="form-control" type="text"
                           wire:model="imageName">
                    @error('imageName')<p class="alert-danger">{{$message}}</p>@enderror

                </div>
                <div class=" mb-3">
                    <label class="form-label" for="">Cover Image</label>
                    <input class="form-control" type="file"  wire:model="image">
                    @error('image')<p class="alert-danger">{{$message}}</p>@enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" wire:click="updateImage">Edit</button>
                </div>

            </div>

        </div>
    </div>
</div>
