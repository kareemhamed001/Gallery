import Swal from "sweetalert2";
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';
import modal from "bootstrap/js/src/modal";

function handleResponse(response, reload = true) {
    console.log(response)
    if (response.status === 200) {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message,
            showConfirmButton: false,
        })
        if (reload) {
            window.location.reload()
        }
    } else if (response.exception) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: response.exception,
            showConfirmButton: false,
        })
    } else {
        let errorMessage = '';
        if (response.errors) {
            for (let key in response.errors) {
                errorMessage += response.errors[key][0] + '<br>'
            }
        } else
            errorMessage = response.message
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: errorMessage,
            showConfirmButton: false,
        })
    }
}

class Modal {
    constructor(modal_id) {
        let modalElement = document.getElementById(modal_id)
        if (!modalElement) {
            throw new Error('Modal element not found')
        }
        this.modal = new bootstrap.Modal(document.getElementById(modal_id))
    }

    show() {
        this.modal.show()
    }

    hide() {
        this.modal.hide()
    }

    getModal() {
        return this.modal
    }

    setModal(modal) {
        this.modal = modal
    }
}

export {
    handleResponse,
    Modal
}
