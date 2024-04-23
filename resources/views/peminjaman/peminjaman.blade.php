@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header"><font color="black">Data Peminjaman</font></h5>

                    <div class="card-body bg-white">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mb-4">
                            <a href="{{ route('peminjaman.tambah') }}" class="btn btn-primary">
                                + Tambah Data Peminjaman
                            </a>
                            <a href="{{ route ('print') }}" class="btn btn-primary">
                                <i class="ti ti-download"></i>Ekspor PDF</a>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                               <tr align="center" bgcolor="cadetblue">
                                    <th class="px-4 py-2"><font color="white">Nama Peminjam</font></th>
                                    <th class="px-4 py-2"><font color="white">Buku yang Dipinjam</font></th>
                                    <th class="px-4 py-2"><font color="white">Tanggal Peminjaman</font></th>
                                    <th class="px-4 py-2"><font color="white">Tanggal Pengembalian</font></th>
                                    <th class="px-4 py-2"><font color="white">Status</font></th>
                                    <th class="px-4 py-2"><font color="white">Aksi</font></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjaman as $p)
                                    <tr>
                                        <td class="px-4 py-2">{{ $p->user->name }}</td>
                                        <td class="px-4 py-2">{{ $p->buku->judul }}</td>
                                        <td class="px-4 py-2">{{ $p->tanggal_peminjaman }}</td>
                                        <td class="px-4 py-2">{{ $p->tanggal_pengembalian }}</td>
                                       

                                        <td class="px-4 py-2">
                                            @if($p->status === 'Dipinjam')
                                            <span class="badge bg-warning">{{$p->status}}</span>
                                            @elseif($p->status === 'Dikembalikan')
                                            <span class="badge bg-primary">{{$p->status}}</span>
                                            @elseif($p->status === 'Denda')
                                            <span class="badge bg-danger">{{$p->status}}</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-2">
                                            @if($p->status === 'Dipinjam')
                                                <form action="{{ route('peminjaman.kembalikan', $p->id) }}" method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">Kembalikan</button>
                                                </form>
                                            @elseif($p->status === 'Denda')
                                            <a href="{{ route('peminjaman.denda', $p->id) }}" class="btn btn-danger">
                                                Bayar Denda
                                            </a>
                                            @else ($p-> === 'Dikembalikan')
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-2 text-center">Tidak ada data buku.</td>
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