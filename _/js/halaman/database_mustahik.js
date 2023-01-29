    $(document).ready(function(){
        'use strict';

        var title = $('.card-title').text();
        var nama_masjid = $('.subtitle').text();

        var table = $('#tblMustahik').DataTable({
            responsive: true,
            "language": {
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "emptyTable": "Tidak ada data",
                "lengthMenu": "_MENU_ &nbsp; data/halaman",
                "search": "Cari: ",
                "zeroRecords": "Tidak ditemukan data yang cocok.",
                "paginate": {
                  "previous": "<i class='fas fa-chevron-left'></i>",
                  "next": "<i class='fas fa-chevron-right'></i>",
                },
            },
            "order": [[ 1, "desc" ]],
            'columnDefs': [ 
                {
                    'targets': [2,3,4,5,6,7,8,9,10,11,12],
                    'orderable': false,
                }
            ],
            dom: '<"left"l><"center"fr>Btip',
            buttons: [
            {
                extend: 'excelHtml5',
                className: 'btn btn-success',
                pageSize: 'Legal',
                orientation: 'landscape',
                title: title + " " + nama_masjid,
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                },
                action: function(e, dt, button, config) {
                    responsiveToggle(dt);
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(dt.button(button), e, dt, button, config);
                    responsiveToggle(dt);
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-danger',
                pageSize: 'Legal',
                orientation: 'landscape',
                title: title + " " + nama_masjid,
                action: function(e, dt, button, config) {
                    responsiveToggle(dt);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(dt.button(button), e, dt, button, config);
                    responsiveToggle(dt);
                },
                customize : function(doc) {
                    doc.content.splice(0, 1, {
                        text: [{
                            text: title + "\n" + nama_masjid + "\n\n\n",
                            fontSize: 14,
                            alignment: 'center'
                        }]
                    });

                    doc.content[1].margin = [ 10, 0, 10, 0 ];
                    doc.content[1].table.widths = [100,100,80,60,40,40,60,100,60,60,66,60];
                },
                exportOptions: {
                    columns: [0,1,2,3,4,5,6,7,8,9,10,11]
                }
            }],

            initComplete: function() {
                this.api().columns().every( function (i) {
                if(i == 1)
                {
                    var column = this;
                    var select = $('<select class="text-white"><option value="">Filter</option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^'+val+'$' : '', true, false).draw();
                        })

                    column.data().unique().sort().each(function (d,j) {
                        if(column.search() === '^'+d+'$') {
                            select.append('<option value="'+d+'" selected="selected">'+d+'</option>')
                        }
                        else
                        {
                            select.append('<option value="'+d+'">'+d+'</option>');
                        }
                    });
                }
                });
            },
        });
    });

    $(function(){
        $('.tambah-jamaah').on('click', function() {
            $('.modal-title').html('Tambah Data');
            $('.modal-footer button[type=submit]').html('Tambah');
            $('.modal-body form').attr('action', baseURI + '/tambah-data-mustahik');
            
            $('#id_jamaah').val('');
            $('#nama').val('');
            $('#nama_kk').val('');
            $('#tempat_lahir').val('');
            $('#tgl_lahir').val('');
            $('#gender').val('');
            $('#gol_darah').val('');
            $('#pekerjaan').val('');
            $('#alamat').val('');
            $('#telepon').val('');
            $('#status_p').val('');
            $('#kategori').val('');
        });
        $("#tblMustahik").on('click', '.edit-mustahik', function(){
            $('.modal-title').html('Edit Data');
            $('.modal-footer button[type=submit]').html('Edit');
            $('.modal-body form').attr('action', baseURI + '/edit-data-mustahik');

            const hash = $(this).data('id');
            $.ajax({
                url: baseURI + '/get-data-mustahik',
                data: {
                        id_jamaah: hash, 
                        simasjid_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                method: 'post',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: data,
                        showConfirmButton: false,
                        type: 'error'
                    })
                },
                success: function(data){

                    $('.csrf_token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                    $('#id_jamaah').val(hash);
                    $('#nama').val(data.nama);
                    $('#nama_kk').val(data.nama_kk);
                    $('#tempat_lahir').val(data.tempat_lahir);
                    $('#tgl_lahir').val(data.tgl_lahir);
                    $('#gender').val(data.gender);
                    $('#gol_darah').val(data.gol_darah);
                    $('#pekerjaan').val(data.pekerjaan);
                    $('#status_p').val(data.status_p);
                    $('#kategori').val(data.kategori);
                    $('#alamat').val(data.alamat);
                    $('#telepon').val(data.telepon);
                }
            });
        });
    });

    $("#mustahikForm").on('submit', function() {
        var formAction = $("#mustahikForm").attr('action');
        var dataMustahik = {
            id_jamaah: $('#id_jamaah').val(),
            nama : $('#nama').val(),
            nama_kk : $('#nama_kk').val(),
            tempat_lahir : $('#tempat_lahir').val(),
            tgl_lahir : $('#tgl_lahir').val(),
            gender : $('#gender').val(),
            gol_darah : $('#gol_darah').val(),
            pekerjaan : $('#pekerjaan').val(),
            alamat : $('#alamat').val(),
            telepon: $('#telepon').val(),
            status_p : $('#status_p').val(),
            kategori : $('#kategori').val(),
            simasjid_token: $('.csrf_token').val()
        };

        $.ajax({
            type: "POST",
            url: formAction,
            data: dataMustahik,
            dataType: 'json',
            error: function(xhr, status, error) {
                var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    text: data,
                    showConfirmButton: false,
                    type: 'error'
                })
            },
            success: function(data) {
                
                $('.csrf_token').val(data.token);
                $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                if (data.result == 1) {
                    Swal.fire('Berhasil!', data.msg, 'success');
                    setTimeout(location.reload.bind(location), 1000);
                } else {
                    Swal.fire('Gagal!', data.msg, 'error');
                }
            }
        })
        return false;
    });

    $("#tblMustahik").on('click', '.delete-btn', function(e){
      e.preventDefault();

        Swal.fire({
            title: 'Peringatan!',
            text: 'Anda yakin ingin menghapus data ini?',
            showCancelButton: true,
            type: 'warning',
            confirmButtonText: 'Yes',
            reverseButtons: true
        }).then((result) => {

        if (result.value == true) {
            const hash = $(this).data('id');

            $.ajax({
                url: baseURI + '/hapus-data-mustahik',
                data: { 
                    id_jamaah: hash,
                    simasjid_token: $('meta[name="X-CSRF-TOKEN"]').attr('content')
                },
                method: 'post',
                dataType: 'json',
                error: function(xhr, status, error) {
                    var data = 'Mohon refresh kembali halaman ini. ' + '(status code: ' + xhr.status + ')';
                    Swal.fire({
                        title: 'Terjadi Kesalahan!',
                        text: data,
                        showConfirmButton: false,
                        type: 'error'
                    })
                },
                success: function(data) {

                    $('.csrf_token').val(data.token);
                    $('meta[name="X-CSRF-TOKEN"]').attr('content', data.token);

                    if (data.result == 1) {
                      Swal.fire('Berhasil!', data.msg, 'success');
                      setTimeout(location.reload.bind(location), 1000);
                    } 
                    else {
                      Swal.fire('Gagal!', data.msg, 'error');
                    }
                }
            });
        }
        })
    });