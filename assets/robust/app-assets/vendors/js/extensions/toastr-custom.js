function pesan_sukses(pesan){
    toastr.success(pesan, "Sukses");
}

function pesan_peringatan(pesan){
    toastr.warning(pesan, "Peringatan")
}

function pesan_info(pesan){
    toastr.info(pesan, "Informasi")
}

function pesan_error(pesan){
    toastr.error(pesan, "Kesalahan")
}
