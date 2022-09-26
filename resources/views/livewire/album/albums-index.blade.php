<div>
    @include('includes.header')
    <div class="container mt-3">

        <div class="my-3">


            <div class="d-flex justify-content-between">
                <h3 col-6>Albums</h3>
                <div class="col-6">
                    <input class="form-control" type="text" wire:model="searchValue" placeholder="Search for album">
                </div>
            </div>

        </div>

        <div class="row">
            @include('includes.modals')
            @forelse($albums as $album)
                <div class="col-12 col-md-4 col-lg-3 mb-2  rounded-3" style="height: 14rem;">
                    <div class="card shadow overflow-hidden border-0 w-100 h-100 album-card ">

                        <a href="{{route('albums.view',$album->id)}}" class="w-100 h-100">
                            <div
                                class="position-absolute top-50 start-50 translate-middle w-100 h-100  justify-content-center align-items-center title-container">
                                <h5 class="text-white">{{$album->title}}</h5>
                            </div>

                                <img style="object-fit: cover " class="h-100 w-100"
                                     src="{{asset($album->cover) }}"
                                     alt="">

                        </a>

                        <div class="w-100 position-absolute  list-group-container" style="height: 3rem">
                            <div class=" h-100 d-flex justify-content-evenly align-items-center bg-white ">
                                <a wire:click="setAlbumData({{$album->id}})" class="text-decoration-none"
                                   data-bs-toggle="modal" data-bs-target="#updateModal">

                                    <i class="fa-solid fa-pen-to-square"></i> edit
                                </a>
                                <a wire:click="setAlbumData({{$album->id}})" class="text-decoration-none"
                                   data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="fa-solid fa-trash"></i> delete
                                </a>
                                <a href="{{route('albums.view',$album->id)}} " class="text-decoration-none">
                                    <i class="fa-solid fa-eye"></i> view
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <p>
                    No Albums
                </p>
            @endforelse

        </div>
        <div>
            {{$albums->links()}}
        </div>

    </div>
</div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modals', function () {
            $('#deleteModal').modal('hide');
            $('#exampleModal').modal('hide');
            $('#updateModal').modal('hide');
        });

        window.addEventListener('openShowDeleteModal', function () {
            $('#deleteModal').modal('show');

        });
        window.addEventListener('openAddAlbumModal', function () {

            $('#exampleModal').modal('show');
        });
    </script>
@endpush

