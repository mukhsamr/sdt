import Swal from 'sweetalert2'

export default function (message) {

    return Swal.fire({
        icon: 'question',
        title: message,
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((res) => res.isConfirmed)

}