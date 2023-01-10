@extends('layouts.layouts')

@push('css')
    <style>
        body {
            background-color: aliceblue
        }

        .card:hover {
            cursor: pointer;
            background-color: gray
        }

        .icon:hover {
            background-color: white
        }
    </style>
@endpush

@section('content')
    <div class="input-group my-4">
        <input type="text" class="form-control" id="key" placeholder="Cari Tugas" aria-label="Recipient's username"
            aria-describedby="basic-addon2">
        <button class="btn btn-success" type="button" id="button-addon2" data-bs-toggle="modal"
            data-bs-target="#exampleModal">Tambah</button>
    </div>
    @includeIf('tugas.modal', ['some' => 'data'])
    @includeIf('tugas.detail-tugas', ['some' => 'data'])
    <div class="list" id="container-list">

    </div>
@endsection

@push('js')
    <script>
        $("#key").on("keyup", function() {
            let key = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ route('tugas.data') }}",
                data: {
                    "key": key,
                },
                dataType: "json",
                success: function(response) {
                    $('#container-list').html("");
                    if (response.length != 0) {
                        $.each(response, function(key, item) {
                            let s = item.status == 1 ? 'bg-secondary text-white' : '';
                            $('#container-list').append(`
                            <div class="card ${s}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-title">${item.nrp}</h6>
                                            <h5>${item.nama}</h5>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button href="/todolist" class="btn btn-info btn-md" onclick="statusActive(${item.id_tugas})"><i class="bi bi-cursor-fill"></i></button>
                                                <button href="/todolist" class="btn btn-success btn-md" onclick="status(${item.id_tugas})"><i class="bi bi-check-lg"></i></button>
                                                <a href="/todolist" class="btn btn-warning btn-md" data-bs-toggle="modal"
                                                    data-bs-target="#taskmodal" onclick="show(${item.id_tugas})"><i class="bi bi-pencil-square"></i></a>
                                                <a href="/todolist" class="btn btn-danger btn-md" onclick="hapus(${item.id_tugas})"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                        <h6>${item.todo}</h6>    
                                </div>
                            </div>
                            `);
                        });
                    } else if (response.length == 0) {
                        $('#container-list').append(`
                            <div class="alert alert-danger text-center">
                                <h5>Tidak ditemukan</h5>
                            </div>
                        `);
                    } else {
                        dataTugas();
                    }
                }
            });
        });

        dataTugas();

        function dataTugas() {
            $.ajax({
                type: "GET",
                url: "{{ route('tugas.data') }}",
                dataType: "json",
                success: function(response) {
                    $('#container-list').html("");
                    if (response.length != 0) {
                        $.each(response, function(key, item) {
                            let s = item.status == 1 ? 'bg-secondary text-white' : '';
                            let bg = item.is_active == 0 ? 'bg-secondary text-white' : 'bg-white';

                            let cek = item.is_done == 1 ? '✅' : '❌';
                            let ceklis = item.is_active == 1 ? '✅' : '❌';
                            console.log(`active ${item.is_active}`)
                            console.log(`done ${item.is_done}`)
                            console.log(key)
                            $('#container-list').append(`
                            <div class="card ${s}  ${bg}">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 i class="bi bi-list-ol text-title">     ${item.nrp}</h6>
                                            <h5 i class="bi bi-person-fill">     ${item.nama}</h5>
                                            <h5 i class="bi bi-cursor-fill">     ${ceklis}</h5>
                                            <h5 i class="bi bi-check-lg">     ${cek}</h5>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <!-- <button href="/todolist" class="btn btn-info btn-md" onclick="statusActive(${item.id_tugas})"><i class="bi bi-cursor-fill"></i></button> -->
                                                <button href="/todolist" class="btn btn-success btn-md" onclick="status(${item.id_tugas}, key)"><i class="bi bi-check-lg"></i></button>
                                                <a href="/todolist" class="btn btn-warning btn-md" data-bs-toggle="modal"
                                                    data-bs-target="#taskmodal" onclick="show(${item.id_tugas})"><i class="bi bi-pencil-square"></i></a>
                                                <a href="/todolist" class="btn btn-danger btn-md" onclick="hapus(${item.id_tugas})"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                        <h6 i class="bi bi-pen-fill">     ${item.todo}</h6>   
                                </div>
                            </div>
                            `);
                        });
                    }
                }
            });
        }

        function tambah() {
            $('#tambah').removeAttr('onclick');

            let nrp = $('#nrp').val();
            let nama = $('#nama').val();
            let todo = $('#todo').val();

            var data = {
                'nrp': nrp,
                'nama': nama,
                'todo': todo,
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('tugas.store') }}",
                data: data,
                dataType: "json",
                succes: function(response) {
                    if (response.status == 200) {
                        $('#nrp').val("");
                        $('#nama').val("");
                        $('#todo').val("");
                        $('.modal').removeClass('show');
                        $(".modal").css('display', 'none');
                        $('.modal-backdrop').remove();
                        $('body').removeAttr('class');
                        $('body').removeAttr('style');
                        $('#tambah').attr('onclick', 'tambah()');
                        dataTugas();
                    }
                }
            });
        }



        function status(id_tugas, key) {
            const card = document.querySelectorAll('.card')
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "{{ url('/todoliststatus') }}/" + id_tugas,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        const status = true;
                        dataTugas(status);

                    }
                }

            })
            card[0].classList.add('bg-primary')

        }



        function hapus(id_tugas) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "{{ url('/todolist') }}/" + id_tugas,
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        dataTugas();
                    }
                }
            });
        }

        function show(id_tugas) {
            $.ajax({
                type: "GET",
                url: "{{ url('/todolist') }}/" + id_tugas,
                dataType: "json",
                success: function(response) {
                    $('#id_tugas').val(response.id_tugas)
                    $('#detail-nrp').val(response.nrp)
                    $('#detail-nama').val(response.nama)
                    $('#detail-todo').val(response.todo)
                    $('#').html("");
                }
            });
        }

        function ubah() {
            $('#simpan').removeAttr('onclick');
            let id_tugas = $('#id_tugas').val();
            let nrp = $('#detail-nrp').val();
            let nama = $('#detail-nama').val();
            let todo = $('#detail-todo').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "{{ url('/todolist') }}/" + id_tugas,
                data: {
                    "nrp": nrp,
                    "nama": nama,
                    "todo": todo
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $('.modal').removeClass('show');
                        $(".modal").css('display', 'none');
                        $('.modal-backdrop').remove();
                        $('body').removeAttr('class');
                        $('body').removeAttr('style');
                        $('#simpan').attr('onclick', 'tambah()');
                        dataTugas();
                    }
                }
            });
        }

        function statusActive(id_tugas) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });



            $.ajax({
                type: "PUT",
                url: `/todolistactive/${id_tugas}`,
                dataType: "json",
                success: function(response) {
                    if (response.statusActive == 200) {
                        dataTugas();
                        console.log("OK!")
                    } else {
                        console.log("fail")
                    }
                }
            });

        }
    </script>
@endpush
