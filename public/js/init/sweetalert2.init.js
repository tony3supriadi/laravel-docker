function _deleted(id) {
    Swal.fire({
        text: "Apakah Anda akan menghapus data?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            document.getElementById('delete-item-' + id).submit();
        }
    })
} 

function _cancel(id) {
    Swal.fire({
        text: "Apakah anda akan membatalkan belanja?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Batal!',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            document.getElementById('cancel-item-' + id).submit();
        }
    })
}