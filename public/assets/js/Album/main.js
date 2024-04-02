
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';
import routes from '../routes.js';
import Swal from "sweetalert2";
import Album from "./Album";
import {handleResponse} from "../helpers";

document.addEventListener('DOMContentLoaded', async function () {
    await showAlbums('albumsContainer')
})

let albumCoverInputs = document.querySelectorAll('.album_cover');
albumCoverInputs.forEach(function (albumCoverInput) {
    let albumCoverPreview = albumCoverInput.parentElement.parentElement.parentElement.querySelector('.album_cover_preview');
    albumCoverInput.addEventListener('change', function () {
        let file = this.files[0];
        let reader = new FileReader();
        reader.onload = function () {

            albumCoverPreview.src = reader.result;
            albumCoverPreview.style.display = 'block';
        };
        if (file) {
            reader.readAsDataURL(file);
        } else {
            albumCoverPreview.src = '';
            albumCoverPreview.style.display = 'none';
        }
    })
})


let addAlbumForm = document.getElementById('addAlbumForm');

addAlbumForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    let formData = new FormData(addAlbumForm);

    let response = await Album.store(formData)
    handleResponse(response)
})

async function showAlbums(container = 'albumsContainer') {
    let albumsContainer = document.getElementById(container)

    let response = await Album.list()
    let albums = response.data
    if (!albums) {
        Swal.fire({
            icon: 'error',
            title: 'Error while showing albums',
            showConfirmButton: false,
            timer: 1500
        })
        return
    }

    albums.forEach(album => {

        let albumElement = Album.createElement(album)
        albumsContainer.appendChild(albumElement)
        let editButton = albumElement.getElementsByClassName('edit-album-button')
        let deleteButton = albumElement.getElementsByClassName('delete-album-button')


        editButton[0].addEventListener('click', function () {
            editAlbum(album)
        })
        deleteButton[0].addEventListener('click', function () {

            let modal = new bootstrap.Modal(document.getElementById('deleteAlbumModal'))

            if (modal) {
                let modalForm = document.querySelector('#deleteAlbumModal form')
                modalForm.dataset.id = album.id
                let modalSelect = document.querySelector('#move_to')
                albums.forEach(albumOption => {
                    if (albumOption.id !== album.id) {
                        let modalOption = document.createElement('option')
                        modalOption.value = albumOption.id
                        modalOption.innerHTML = albumOption.name
                        modalSelect.appendChild(modalOption)
                    }
                })
                modal.show()
            }


        })
    })

}
async function editAlbum(album) {

    let editModal = new bootstrap.Modal(document.getElementById('editAlbumModal'))
    if (editModal) {
        let editModalForm = document.querySelector('#editAlbumModal form')
        let albumNameInput = document.querySelector('#editAlbumModal #album_name_edit')
        let albumCoverPreview = document.querySelector('#editAlbumModal .album_cover_preview')

        albumCoverPreview.src = album.cover
        albumCoverPreview.style.display = 'flex'
        editModalForm.dataset.id = album.id

        albumNameInput.value = album.name
        editModal.show()
    }
}

let editAlbumForm = document.getElementById('updateAlbumForm')
editAlbumForm.addEventListener('submit', async function (e) {
    e.preventDefault()
    let formData = new FormData(editAlbumForm)
    let albumId = editAlbumForm.dataset.id

    let response = await Album.update(albumId, formData)
    handleResponse(response)
})

let deleteAlbumForm = document.getElementById('deleteAlbumForm');

deleteAlbumForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    let formData = new FormData(deleteAlbumForm);
    let albumId = deleteAlbumForm.dataset.id
    console.log(albumId)
    let response = await Album.destroy(albumId, formData)
    handleResponse(response)
})

let searchForm=document.getElementById('searchForm')
searchForm.addEventListener('submit',async function (e){
    e.preventDefault()
    let albumsContainer = document.getElementById('albumsContainer')
    let formData=new FormData(searchForm)
    let response=await Album.search(formData.get('search'))
    if (response.status===200){
        let data=response.data
        if (data){
            albumsContainer.innerHTML='';
            data.forEach(function (album){
                let albumElement = Album.createElement(album)
                albumsContainer.appendChild(albumElement)
            })
        }

    }
    handleResponse(response,false)
})
