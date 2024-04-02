import routes from "../routes";
import Loader from "../Loader";
import album from "./Album";

class Image {

    static async store(formData) {
        Loader.show()
        let response = await fetch(routes.api.image.store.url, {
            method: routes.api.image.store.method,
            body: formData,
            headers: {
                'Accept': 'application/json',
            }
        }).then(res => res.json())
            .then(data => data);
        Loader.hide()
        return response
    }


    static async destroy(imageId) {
        Loader.show()
        let response = await fetch(routes.api.image.destroy.url.replace('{id}', imageId), {
            method: routes.api.image.destroy.method,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        }).then(res => res.json())
            .then(data => data)
        Loader.hide()
        return response
    }

    static async destroyAll(albumId) {
        Loader.show()
        let response = await fetch(routes.api.image.destroyAll.url, {
            method: routes.api.image.destroyAll.method,
            body:JSON.stringify({
               album_id:albumId
            }),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        }).then(res => res.json())
            .then(data => data)
        Loader.hide()
        return response
    }

    static createElement(album) {
        let albumElement = document.createElement('div')
        albumElement.classList.add('col-12', 'col-md-3', 'col-lg-3', 'col-xl-3', 'col-xxl-4', 'album')
        albumElement.innerHTML = `

                <div class="card p-0 border-0 rounded-0 bg-light h-100">
                    <a href="${routes.web.album.show.url.replace('{id}', album.id)}" class="text-decoration-none h-100">
                        <div class="card-body p-0 position-relative h-100">
                            <img class="w-100 h-100" style="object-fit: cover"
                                 src="${album.cover}" alt="">
                            <div class="album-name-container">
                                <h5 class="text-white text-uppercase bg-dark bg-opacity-25 album-name">
                                    ${album.name}</h5>
                            </div>

                        </div>
                    </a>
                              <div class="options-container">
                            <button type="button" class="btn btn-success m-1 edit-album-button" title="edit" data-id="${album.id}"><i class="fa fa-pen text-white" title="edit"></i></button>
                            <button type="button" class="btn btn-danger m-1 delete-album-button" title="delete" data-id="${album.id}"><i class="fa fa-trash text-white" title="delete"></i></button>
</div>
                </div>

            `
        return albumElement;
    }
}

export default Image
