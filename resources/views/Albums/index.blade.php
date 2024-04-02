@extends('Layouts.app-layout')
@section('content')
    <section id="page-cover-section">
        <div class="overlay"></div>
        <img class="w-100 h-100" src="{{asset('assets/images/wallpaperflare.com_wallpaper40.jpg')}}" alt="">
        <div class="position-absolute top-50 start-50 translate-middle" id="search-box">
            <form action="" id="searchForm">

            <div class="input-group">
                <input type="text" class="form-control rounded-0" placeholder="Search albums" name="search">
                <button class="btn btn-primary rounded-0">Search</button>
            </div>
            </form>
        </div>
    </section>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <section id="albums-section" class="container py-3">
        <div class="d-flex flex-row  justify-content-between align-items-center">
            <h1>Albums</h1>
            <button class="btn btn-primary w-auto" data-bs-toggle="modal" data-bs-target="#addAlbumModal">Add</button>
        </div>
        <div class="row mt-4" id="albumsContainer">
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="addAlbumModal" tabindex="-1" aria-labelledby="addAlbumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAlbumModalLabel">Add Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="album_cover">
                        <img class="w-100 h-50 album_cover_preview" style="display: none" src="" alt="album cover" id="album_cover_preview">
                    </label>
                    <form action="" id="addAlbumForm">
                        <div class="my-2">
                            <label for="album_name" class="form-label">Album Name</label>
                            <input type="text" name="name" id="album_name" class="form-control album_name"
                                   placeholder="album name">
                        </div>

                        <div class="my-2">
                            <label for="album_cover" class="form-label">Album Cover</label>
                            <input type="file" name="cover" id="album_cover" class="form-control album_cover">
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="addAlbumForm">Add</button>
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

    <div class="modal fade" id="editAlbumModal" tabindex="-1" aria-labelledby="editAlbumModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAlbumModalLabel">Edit Album</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="album_cover">
                        <img class="w-100 h-50 album_cover_preview" style="display: none" src="" alt="album cover" id="">
                    </label>
                    <form action="" id="updateAlbumForm">
                        <div class="my-2">
                            <label for="album_name_edit" class="form-label">Album Name</label>
                            <input type="text" name="name" id="album_name_edit" class="form-control album_name"
                                   placeholder="album name">
                        </div>

                        <div class="my-2">
                            <label for="album_cover_edit" class="form-label">Album Cover</label>
                            <input type="file" name="cover" id="album_cover_edit" class="form-control album_cover">
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" form="updateAlbumForm">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @vite('public/assets/js/Album/main.js')
@endsection
