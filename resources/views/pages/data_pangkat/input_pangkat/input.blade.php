@extends('partials.master')

@prepend('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endprepend

@section('content')
    <div class="row form-control">
        <div class="text-center">
        <h3>Form 
            @if(isset($pangkat)) 
                Edit
            @else
                Input 
            @endif    
                Pangkat</h3>
        </div>
        <hr>
        @if(isset($pangkat))
        <form action="/data-pangkat/update" method="post">
        @else
        <form action="/input-data-pangkat/store" method="post">
        @endif
            @csrf
            <div class="row">
                <input type="hidden" name="id" id="id" value="{{ isset($pangkat) ? $pangkat->id : '' }}">
                <div class="col-lg-12 mb-3">
                    <label for="perihal_nota_dinas" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control border-dark" placeholder="Nama" value="{{ isset($pangkat) ? $pangkat->name : '' }}" >
                </div>
            </div>
            {{-- <input type="text" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->id : '' }}" hidden name="kasus_id"> --}}
            <div class="row">
                <div class="col-lg-12 mb-3">
                    @if(isset($pangkat))
                        <button class="btn btn-success form-control" type="submit" value="edit_pangkat" name="type_submit">
                            Submit Data
                        </button>
                    @else
                        <button class="btn btn-success form-control" type="submit" value="input_pangkat" name="type_submit">
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
