@extends('layouts.master')

@section('title')
    {{"Inspect Vehicle"}}
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/formbuilder/form-builder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/formbuilder/form-render.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/pace/pace.min.css') }}">
@stop

@section('content')
    <div class="col-md-12">
        @include('layouts.customerCreate')
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Inspection Details</h3>
            </div>
            <div class="box-body">
                @include('layouts.vehicleCreate')
                <div id="form-box" class="panel-group" role="tab-list" aria-multiselectable="true">
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('remarks', 'Remarks') !!}
                        {!! Form::textarea('remarks',null,[
                            'class' => 'form-control',
                            'placeholder'=>'Remarks',
                            'maxlength'=>'140',
                            'rows' => '1']) 
                        !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ URL::asset('assets/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/formbuilder/form-builder.min.js') }}"></script>
    <script src="{{ URL::asset('assets/formbuilder/form-render.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.numeric.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.phone.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{ URL::asset('js/customer.js') }}"></script>
    <script src="{{ URL::asset('js/inspect.js') }}"></script>
    <script>
        $(document).ready(function (){
            $('#ms').addClass('active');
            $('#mInspection').addClass('active');
            var customers = [
                @foreach($customers as $customer)
                    '{{$customer->firstName}} {{$customer->middleName}} {{$customer->lastName}}',
                @endforeach
            ];    
            var activeTechnicians = [
                @if(old('technician'))
                    @foreach(old('technician') as $technician)
                        "{{$technician}}",
                    @endforeach
                @endif
            ];
            $("#technician").val(activeTechnicians);
            @if(old('modelId'))
                $("#model").val({{old('modelId')}});
            @endif
            $(".select2").select2();
            $('#firstName').autocomplete({source: customers});
            @if(!old('contact'))
                $('#contact').inputmask("+63 999 9999 999");
            @else
                @if(old('contact')[2] == '2' && strlen(old('contact')) >= 17)
                    $('#contact').inputmask("(02) 999 9999 loc. 9999");
                @elseif(old('contact')[2] == '2')
                    $('#contact').inputmask("(02) 999 9999");
                @else
                    $('#contact').inputmask("+63 999 9999 999");
                @endif
            @endif
            @if(!old('plate'))
                $('#plate').inputmask("AAA 999");
            @else
                @if(strlen(old('plate')) == 7)
                    $('#plate').inputmask("AAA 999");
                @elseif(strlen(old('plate')) == 8)
                    $('#plate').inputmask("AAA 9999");
                @elseif(strlen(old('plate')) == 6)
                    @if(old('plate')[3] != ' ')
                        $('#plate').inputmask("AA 9999");
                    @else
                        $('#plate').inputmask("AAA 99");
                    @endif
                @elseif(strlen(old('plate')) == 1)
                    $('#plate').inputmask("9");
                @else
                    $('#plate').inputmask();
                    $('#plate').val("For Registration");
                @endif
            @endif
        });
    </script>
    @if(old('itemId'))
        @foreach(old('itemId') as $key=>$item)
            <script>
                form = JSON.stringify({!! old('form.'.$key) !!});
                popForm({{old('typeId.'.$key)}},"{{old('typeName.'.$key)}}",{{old('itemId.'.$key)}},"{{old('itemName.'.$key)}}",form)
            </script>
        @endforeach
    @else
        @foreach($items as $item)
            <script>
                form = JSON.stringify({!! $item->form !!});
                popForm({{$item->typeId}},"{{$item->type->type}}",{{$item->id}},"{{$item->name}}",form)
            </script>
        @endforeach
    @endif
@stop