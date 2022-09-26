<div>
    @include('includes.viewPageHeader')
    <div class="row m-2" style="height: 80vh">
        <img class="w-100 h-100" style="object-fit: cover" src="{{asset($album->cover)}}" alt="">
    </div>
    <div class="container">


        @include('includes.viewPageModal')

        <div class="row">
            <div class="d-flex justify-content-between">
                <h3 col-6>{{$album->title}}</h3>
                <div class="col-6">
                    <input class="form-control" type="text" wire:model="searchValue" placeholder="Search for image">
                </div>
            </div>
        </div>

        <div class="row mt-3">
            @forelse($images as $image)
                <div class="col-12 col-md-4 col-lg-3 mb-2 px-1 py-0" style="height: 20rem;">
                    <div class="card shadow-sm   overflow-hidden border-0 w-100 h-100 album-card rounded-0 ">

                        <a href="" class="w-100 h-100">
                            <div
                                class="position-absolute top-50 start-50 translate-middle w-100 h-100  justify-content-center align-items-center title-container">
                                <h5 class="text-white">{{$image->title}}</h5>
                            </div>

                            <img style="object-fit: cover " class="h-100 w-100"
                                 src="{{asset($image->image) }}"
                                 alt="">

                        </a>

                        <div class="w-100 position-absolute  list-group-container" style="height: 3rem">
                            <div class=" h-100 d-flex justify-content-evenly align-items-center bg-white ">
                                <a wire:click="setImageData({{$image->id}})" class="text-decoration-none"
                                   data-bs-toggle="modal" data-bs-target="#updateModal">

                                    <i class="fa-solid fa-pen-to-square"></i> edit
                                </a>
                                <a wire:click="setImageData({{$image->id}})" class="text-decoration-none"
                                   data-bs-toggle="modal" data-bs-target="#deleteImageModal">
                                    <i class="fa-solid fa-trash"></i> delete
                                </a>
                                <a wire:click="setImageData({{$image->id}})" class="text-decoration-none"
                                   data-bs-toggle="modal" data-bs-target="#moveImageModal">
                                    <i class="fa-regular fa-share-from-square"></i> Move
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <h3>No images for album {{$album->title}}</h3>
            @endforelse

            <div>
                {{$images->links()}}
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modals', function () {
            $('#addImageModal').modal('hide');
            $('#moveImageModal').modal('hide');
            $('#deleteImageModal').modal('hide');
            $('#updateModal').modal('hide');

        });

        window.addEventListener('openAddImageModal', function () {
            $('#addImageModal').modal('show');

        });

    </script>
@endpush
