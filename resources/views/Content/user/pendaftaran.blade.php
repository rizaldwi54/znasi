@extends('Content.user.dashboard')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Pendaftaran</div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Foto Diri</label>
                                    <input type="file"
                                        class="form-control @error('image')
                                        is-invalid
                                    @enderror"
                                        name="image">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <label for="">Name</label>
                                    <input type="text"
                                        class="form-control @error('name')
                                        is-invalid
                                    @enderror"
                                        name="name" value="{{ $profileData->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <label for="">Name Orang Tua</label>
                                    <input type="text"
                                        class="form-control @error('name')
                                        is-invalid
                                    @enderror"
                                        name="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <label for="">Alamat</label>
                                    <input type="text"
                                        class="form-control @error('address')
                                        is-invalid
                                    @enderror"
                                        name="address">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group my-3">
                                    <label for="">PDF</label>
                                    <input type="file"
                                        class="form-control @error('pdf')
                                        is-invalid
                                    @enderror"
                                        name="pdf">
                                    @error('pdf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group my-3">
                                <label for="">Deskripsi</label>
                                <Textarea name="description" id=""
                                    class="form-control @error('description')
                                    is-invalid
                                @enderror"
                                    cols="30" rows="10"></Textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
