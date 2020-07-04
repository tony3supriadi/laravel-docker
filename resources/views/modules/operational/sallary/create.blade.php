@extends('layouts.app')

@section('header')
<div class="row position-fixed p-0 m-0 w-100">
    <div class="col-md-12 m-0 p-0">
        <div class="py-2 px-3 mb-2 border-bottom">
                <a href="{{ URL::previous() }}" class="btn btn-sm btn-default mr-2 rounded-circle">
                    <i class="fa fa-arrow-left"></i>
                </a>
                INPUT GAJI KARYAWAN
        </div>
    </div>
</div>
@endsection

@section('content')
<section class="p-4">
    <form action="{{ url('gaji-karyawan') }}" method="post" class="row">
        @csrf

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="employee_id">Pilih Karyawan</label>
                        <select name="employee_id"
                            data-placeholder=""
                            class="form-control select2"
                            onchange="
                                var val = $(this).val();
                                var employees = {{ $employees }};
                                var filter = employees.filter((item) => {
                                    return item.id == $(this).val();
                                })[0];

                                $('#loading').removeClass('d-none');
                                setTimeout(() => {
                                    $('#loading').addClass('d-none');

                                    $('#info-detail').removeClass('d-none');
                                    $('#extra').removeClass('d-none');
                                    $('input[name=salary]').val(filter.salary);
                                }, 2000);
                            ">
                            <option value=""></option>
                            @foreach($employees as $item)
                            <option value="{{ $item->id }}">{{ strtoupper($item->name) }}</option>
                            @endforeach
                        </select>

                        <div id="loading" class="d-none">
                            <small>Loading...</small>
                        </div>
                    </div>

                    <div id="info-detail" class="d-none">
                        <div class="form-group">
                            <label for="salary">Gaji Pokok</label>
                            <input type="text" name="salary" value="" class="form-control text-right" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="extra" class="col-md-8 d-none">
            <div class="border p-3">
                <div class="form-group col-6 p-0">
                    <label for="salary-extra">Gaji Tambahan</label>
                    <input type="text" value="0" name="salary_extra" class="form-control text-right">
                </div>

                <div class="form-group">
                    <label for="description">DESKRIPSI</label>
                    <textarea name="description" class="form-control"></textarea>
                    
                    <small class="text-gray">
                        Tambahkan catatan tamabahan mengenai gaji yang diperoleh, <br />misal: gaji tambahan berupa lembur dsb.
                    </small>
                </div>

                <hr />

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-2"></i>SIMPAN
                    </button>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/select2/css/select2-bootstrap4.min.css') }}">
@endsection

@section('script')
<script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/init/select2.init.js') }}"></script>
@endsection