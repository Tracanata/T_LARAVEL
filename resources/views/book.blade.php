@extends('adminlte::page')

@section('title', 'Pengelolaan Buku')

@section('content_header')
    <h1>Pengelolaan Buku</h1>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">{{ __('Pengelolaan Buku') }}</div>
                <div class="card-body">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#tambahBukuModal"><i class="fa fa-plus"></i>Tambah Data</button>
                    <a href="{{ route('admin.print.books') }}" target="_blank" class="btn btn-secondary"><i class="fa fa-print"></i> Cetak PDF</a>
                    <a href="{{ route('admin.book.export') }}" class="btn btn-info" target="_blank">Export</a>
                    <a href=""class="btn btn-warning">Import</a>
                    </hr>
                     <table id="table-data" class="table table-borderer">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>JUDUL</th>
                                <th>PENULIS</th>
                                <th>TAHUN</th>
                                <th>PENERBIT</th>
                                <th>COVER</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach($books as $book)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $book->judul }}</td>
                                    <td>{{ $book->penulis }}</td>
                                    <td>{{ $book->tahun }}</td>
                                    <td>{{ $book->penerbit }}</td>
                                        <td>
                                         @if($book->cover !==null)
                                            <img src="{{ asset('storage/cover_buku/'.$book->cover) }}" width="100px"/>
                                         @else
                                            [gambar tak tersedia]
                                         @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button type="button" id="btn-edit-buku" class="btn btn-success" data-toggle="modal" data-target="#editBukuModal" data-id="{{ $book->id }}">Ubah</button>
                                                <button type="button" id="btn-delete-buku" class="btn btn-danger" data-toggle="modal" data-target="#deleteBukuModal" data-id="{{ $book->id }}" data-cover="{{ $book->cover }}">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal tambah buku --}}
<div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="tambahBukuLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.book.submit') }}" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahBukuLabel">{{ _('Tambah Data Buku') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="inputJudul">Judul Buku</label>
                            <input type="text" class="form-control" id="inputJudul" name="judul">
                        </div>
                        <div class="form-group">
                            <label for="inputPenulis">Penulis</label>
                            <input type="text" class="form-control" id="inputPenulis" name="penulis">
                        </div>
                        <div class="form-group">
                            <label for="inputTahun">Tahun</label>
                            <input type="number" class="form-control" id="inputTahun" name="tahun">
                        </div>
                        <div class="form-group">
                            <label for="inputPenerbit">Penerbit</label>
                            <input type="text" class="form-control" id="inputPenerbit" name="penerbit">
                        </div>
                        <div class="form-group">
                            <label for="inputCover">Cover</label>
                            <input type="file" class="form-control-file" id="inputCover" name="cover">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- end Modal tambah buku--}}

    {{-- Modal edit buku --}}
    <div class="modal fade" id="editBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Data Buku</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" action="{{ route('admin.book.update') }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label for="edit-judul">Judul Buku</label>
                      <input type="text" class="form-control" name="judul" id="edit-judul" required/>
                  </div>
                  <div class="form-group">
                      <label for="edit-penulis">Penulis</label>
                      <input type="text" class="form-control" name="penulis" id="edit-penulis" required/>
                  </div>
                  <div class="form-group">
                      <label for="edit-tahun">Tahun</label>
                      <input min="1" type="number" id="datepicker" class="form-control" name="tahun" id="edit-tahun" required/>
                  </div>
                  <div class="form-group">
                      <label for="edit-penerbit">Penerbit</label>
                      <input type="text" class="form-control" name="penerbit" id="edit-penerbit" required/>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group" id="image-area"></div>
                  <div class="form-group">
                      <label for="edit-cover">Cover</label>
                      <input type="file" class="form-control" name="cover" id="edit-cover"/>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="edit-id"/>
          <input type="hidden" name="old_cover" id="edit-old-cover"/>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
{{-- end Modal edit buku--}}

<div class="modal fade" id="deleteBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Hapus Data Buku</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Apakah anda yakin akan menghapus data tersebut?
          <form method="post" action="{{ route('admin.book.delete') }}" enctype="multipart/form-data">
              @csrf
              @method('DELETE')
        </div>
        <div class="modal-footer">
          <input type="hidden" name="id" id="delete-id" value=""/>
          <input type="hidden" name="old_cover" id="delete-old-cover"/>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@stop





@section('js')
<script>
    $(function(){

        $(document).on('click', '#btn-delete-buku', function(){
                let id = $(this).data('id');
                let cover = $(this).data('cover');
                $('#delete-id').val(id);
                $('#delete-old-cover').val(cover);
                console.log("hallo");
            });



        $(document).on('click', '#btn-edit-buku', function(){
                let id = $(this).data('id');
                $('#image-area').empty();
                $.ajax({
                    type: "get",
                    url: baseurl+'/admin/ajaxadmin/dataBuku/'+id,
                    dataType: 'json',
                    success: function(res){
                        $('#edit-judul').val(res.judul);
                        $('#edit-penerbit').val(res.penerbit);
                        $('#edit-penulis').val(res.penulis);
                        $('#edit-tahun').val(res.tahun);
                        $('#edit-id').val(res.id);
                        $('#edit-old-cover').val(res.cover);
                        if (res.cover !== null) {
                            $('#image-area').append(
                                "<img src='"+baseurl+"/storage/cover_buku/"+res.cover+"' width='200px'/>"
                            );
                        } else {
                            $('#image-area').append('[Gambar tidak tersedia]');
                        }
                    },
                });
            });
        });
</script>
@stop
