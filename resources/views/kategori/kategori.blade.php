@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header"><font color="black">List Kategori</font></h5>

                    <div class="card-body">
                        <div class="mb-4">
                            <a href="{{route('kategori.create')}}" class="btn btn-primary">
                                + Tambah Data Kategori
                            </a>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr align="center" bgcolor="cadetblue">
                                    <th class="px-4 py-2"><font color="white">Nama Kategori</font></th>
                                    <th class="px-4 py-2"><font color="white">Aksi</font></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($kategori as $k)
                                    <tr>
                                        <td class="px-4 py-2">{{ $k->nama_kategori }}</td>
                                        <td>
                                            <form action="{{ route ('kategori.hapus', $k->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                            <button class = "btn btn-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        
                                            <a href="{{ route('kategori.edit', $k->id) }}" class="btn btn-primary">
                                                <i class="ti ti-pencil"></i>
                                                  </form>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center">Tidak ada data kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection