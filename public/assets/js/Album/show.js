import Image from "./Image";
import Swal from "sweetalert2";
import {handleResponse, Modal} from "../helpers";

let albumCoverInputs = document.querySelectorAll('.album_cover');
albumCoverInputs.forEach(function (albumCoverInput) {
    albumCoverInput.addEventListener('change', function () {
        let imagesPreviewContainer = document.getElementById('images-preview-container');
        let files = Array.from(this.files); // Convert FileList to Array
        if (files.length>10){
            Swal.fire({
                icon: 'warning',
                title: "Allowed files are 10",
                showCancelButton: false,
                timer:1500
            })
            files=[]
            return
        }
        files.forEach(function (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                let imageContainer = document.createElement('div')
                imageContainer.classList.add('col-3', 'p-1')

                let imagePreview = document.createElement('img');
                imagePreview.classList.add('w-100', 'h-50');

                imagePreview.src = e.target.result; // Use the result from the event
                imageContainer.appendChild(imagePreview)
                imagesPreviewContainer.appendChild(imageContainer);
            };
            reader.readAsDataURL(file);
        });
    });
});


let addImageForm = document.getElementById('addImageForm')
addImageForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    let formData = new FormData(addImageForm);
    let images=formData.get('images[]')
    if (images.length>10){
        Swal.fire({
            icon: 'warning',
            title: "Allowed files are 10",
            showCancelButton: false,
            timer:1500
        })
        return
    }
    let albumId = addImageForm.dataset.id
    formData.append('album_id', albumId)
    console.log(formData)

    let response = await Image.store(formData)
    handleResponse(response, true)
})

let deleteImagesButtons = document.querySelectorAll('.delete-image-button')

deleteImagesButtons.forEach(function (deleteImageButton) {
    deleteImageButton.addEventListener('click', async function (e) {
        e.preventDefault()
        let imageId = deleteImageButton.dataset.id
        if (imageId) {
            Swal.fire({
                icon: 'warning',
                title: "Do you want to delete the image?",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: '#DC3545FF'

            })
                .then(async (result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let response = await Image.destroy(imageId)
                        handleResponse(response, true)
                    } else if (result.isDenied) {
                        Swal.fire("Changes are not saved", "", "info");
                    }
                });
        }
    })
})

let deleteAllButton = document.getElementById('deleteAllButton')
deleteAllButton.addEventListener('click', function (e) {
    e.preventDefault()

    let albumId = deleteAllButton.dataset.id
    if (!albumId) {
        throw new Error('album id not set')
    }

    Swal.fire({
        icon: 'warning',
        title: "are you sure you want to delete all image ?",
        // showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: '#DC3545FF'

    })
        .then(async (result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                let response = await Image.destroyAll(albumId)
                handleResponse(response, true)
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
})
