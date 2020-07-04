@extends('layouts.app')

@section('header')
<header class="page-header position-fixed">
    <div class="container-fluid">
        <div class="row">
            <h2 class="no-margin-bottom py-1 col-md-6">
                <i class="fa fa-universal-access mr-3"></i>Hak Akses
            </h2>
        </div>
    </div>
</header>
@endsection

@section('content')
<section class="p-4">
    <div class="row">
        <div class="col-md-12">
            <div class="py-2 mb-2 border-bottom">
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                UBAH AKSES
            </div>

            <form action="{{ url('/hak-akses/'.encrypt($role->id)) }}" method="post">
                @csrf
                @method('put')

                <div class="form-group">
                    <label for="name">NAMA AKSES</label>
                    <input type="text" name="name" value="{{ old('name') ? old('name') : $role->name }}" class="form-control @error('name') is-invalid @enderror" autocomplete="off">

                    @error('name')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>    
                    @enderror
                </div>

                <div class="form-group">
                    <label for="permission">PILIH MODULE</label>
                    
                    @error('permission')
                        <span class="invalid-feedback d-block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <div style="height:300px;overflow-y:scroll;">
                        @foreach($permissions as $item)
                            <div class="py-1"><input type="checkbox" name="permission[]" value="{{ $item->id}}" {{ in_array($item->id, $rolePermissions) ? 'checked' : '' }}> {{ $item->name_string }}</div>

                            @foreach($item->childs as $child)
                                <div class="py-1 pl-3"><input type="checkbox" name="permission[]" value="{{ $child->id}}"  {{ in_array($child->id, $rolePermissions) ? 'checked' : '' }}> {{ $child->name_string }}</div>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fa fa-undo mr-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-edit mr-2"></i>Ubah
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
