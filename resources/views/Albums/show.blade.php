@extends('Layouts.app-layout')
@section('content')
    <section id="page-cover-section">
        <div class="overlay"></div>
        <div
            class="position-absolute top-0 start-0 m-3  "
            style="z-index: 101;" id="back-arrow-container" title="back">
            <a href="/"
               class="d-flex justify-content-center align-items-center p-2 rounded-circle bg-white text-decoration-none"
               style="z-index: 101;width: 30px;height: 30px">

                <i class="fa fa-arrow-left text-black" id="back-arrow"></i>
            </a>
        </div>
        <a href="{{asset($album->cover)}}" target="_blank" class="text-decoration-none h-100">
            <img class="w-100 h-100" src="{{asset($album->cover)}}" alt="">
            <div class="position-absolute top-50 start-50 translate-middle text-center" style="z-index: 100">
                <h1 class="text-white">{{$album->name}}</h1>
            </div>
        </a>

    </section>

    <section id="images-section" class="container py-3">
        <div class="d-flex flex-row  justify-content-between align-items-center">
            <h1>Images</h1>
            <div>

                <button class="btn btn-primary w-auto" data-bs-toggle="modal" data-bs-target="#addAlbumModal">Add
                </button>
                <button class="btn btn-danger w-auto" id="deleteAllButton" data-id="{{$album->id}}">Delete
                    All
                </button>
            </div>
        </div>
        <div class="row mt-4" id="imagesContainer">
            @forelse($album->images as $image)
                <div class="col-12 col-md-3 col-lg-3 col-xl-3 col-xxl-4 album">
                    <div class="card p-0 border-0 rounded-0 bg-light h-100">
                        <a href="{{asset($image->image)}}" target="_blank" class="text-decoration-none h-100">
                            <div class="card-body p-0 position-relative h-100">
                                <img class="w-100 h-100" style="object-fit: cover"
                                     src="{{asset($image->image)}}" alt="">
                            </div>
                        </a>
                        <div class="options-container">
                            <button type="button" class="btn btn-danger m-1 delete-image-button" title="delete"
                                    data-id="{{$image->id}}"><i class="fa fa-trash text-white" title="delete"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                no images
            @endforelse
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addAlbumModal" tabindex="-1" aria-labelledby="addAlbumModalLabel" aria-hidden="true"
         data-id="{{$album->id}}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAlbumModalLabel">Add Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="album_cover" id="images-preview-container"
                           class="d-flex justify-content-center align-items-center flex-wrap">

                    </label>
                    <form action="" id="addImageForm" data-id="{{$album->id}}">
                        <div class="my-2">
                            <label for="album_cover" class="form-label">Image</label>
                            <input type="file" name="images[]" id="album_cover" class="form-control album_cover"
                                   multiple accept="image/*" max="10">
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="addImageForm">Add</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteAlbumModal" tabindex="-1" aria-labelledby="deleteAlbumModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAlbumModalLabel">Delete Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="deleteAlbumForm" data-id="">
                        <div class="my-2">
                            <label for="move_to" class="form-label">Move Album Images to</label>
                            <select name="move_to" id="move_to" class="form-control">
                                <option value="">Select Album</option>
                            </select>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" form="deleteAlbumForm">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @vite('public/assets/js/Album/show.js')
@endsection
