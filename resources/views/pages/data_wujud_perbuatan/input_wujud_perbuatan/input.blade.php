@extends('partials.master')

@prepend('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endprepend

@section('content')
    <div class="row form-control">
        <div class="text-center">
        <h3>Form 
            @if(isset($wujud_perbuatan)) 
                Edit
            @else
                Input 
            @endif    
                Wujud Perbuatan</h3>
        </div>
        <hr>
        @if(isset($wujud_perbuatan))
        <form action="/data-wujud-perbuatan/update" method="post">
        @else
        <form action="/input-data-wujud-perbuatan/store" method="post">
        @endif
            @csrf
            <div class="row">
                <input type="hidden" name="id" id="id" value="{{ isset($wujud_perbuatan) ? $wujud_perbuatan->id : '' }}">
                <div class="col-lg-12 mb-3">
                    <label for="perihal_nota_dinas" class="form-label">Jenis Wujud Perbuatan</label>
                    <select name="jenis_wp" class="form-control" id="jenis_wp">
                        <option value="disiplin"
                            @if(isset($wujud_perbuatan)) 
                                @if($wujud_perbuatan->jenis_wp == "disiplin")
                                    "selected";
                                @endif 
                            @endif >Disiplin</option>
                        <option value="kode etik" @if(isset($wujud_perbuatan)) 
                                @if($wujud_perbuatan->jenis_wp == "kode etik")
                                    "selected";
                                @endif 
                            @endif>Kode Etik</option>
                    </select>
                </div>
                <div class="col-lg-12 mb-3">
                    <label for="perihal_nota_dinas" class="form-label">Keterangan Wujud Perbuatan</label>
                    <input type="text" name="keterangan_wp" class="form-control" placeholder="Keterangan Wujud Perbuatan" value="{{ isset($wujud_perbuatan) ? $wujud_perbuatan->keterangan_wp : '' }}" >
                </div>
            </div>
            {{-- <input type="text" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->id : '' }}" hidden name="kasus_id"> --}}
            <div class="row">
                <div class="col-lg-12 mb-3">
                    @if(isset($wujud_perbuatan))
                        <button class="btn btn-success form-control" type="submit" value="edit_wujud_perbuatan" name="type_submit">
                            Submit Data
                        </button>
                    @else
                        <button class="btn btn-success form-control" type="submit" value="input_wujud_perbuatan" name="type_submit">
                            Submit Data
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        });
        
    </script>
@endsection
