@extends('layouts.master')

@section('title')
    {{"Utilities"}}
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/plugins/pace/pace.min.css') }}">
@stop

@section('content')
    {!! Form::open(['method'=>'patch','action' => ['UtilitiesController@update',1],'files' => true]) !!}
    @include('layouts.required')
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">General Settings</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <center><img class="img-responsive" id="util-pic" src="{{ URL::asset($utilities->image)}}" style="max-width:150px; background-size: contain" /></center>
                <center>
                    {!! Form::label('pic', 'Business Icon') !!}
                    {!! Form::file('image',[
                        'class' => 'form-control',
                        'name' => 'image',
                        'class' => 'btn btn-success btn-sm',
                        'onchange' => 'readURL(this)']) 
                    !!}
                </center>
                <div class="form-group">
                    {!! Form::label('name', 'Business Name') !!}<span>*</span>
                    {!! Form::input('text','name',$utilities->name,[
                        'class' => 'form-control',
                        'placeholder'=>'Name',
                        'maxlength'=>'20',
                        'required']) 
                    !!}
                </div>
                <div class="form-group">
                    {!! Form::label('address', 'Business Address') !!}<span>*</span>
                    {!! Form::textarea('address',$utilities->address,[
                        'class' => 'form-control',
                        'placeholder'=>'Address',
                        'maxlength'=>'140',
                        'rows' => '2',
                        'required']) 
                    !!}
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">System Settings</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('category', 'Product Type Categories:') !!}<span>*</span>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::input('text','category1',$utilities->category1,[
                                'class' => 'form-control',
                                'placeholder'=>'Category',
                                'maxlength'=>'50',
                                'required']) 
                            !!}
                        </div>
                        <div class="col-md-6">
                            <label><span>*</span><i>Allows Vehicle Type on Product</i></label>
                        </div>                        
                    </div><br>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::input('text','category2',$utilities->category2,[
                                'class' => 'form-control',
                                'placeholder'=>'Category',
                                'maxlength'=>'50',
                                'required']) 
                            !!}
                        </div>
                        <div class="col-md-6">
                            <label></label>
                        </div>
                    </div>
                    <br>
                    {!! Form::label('type', 'Part Types:') !!}<span>*</span>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::input('text','type1',$utilities->type1,[
                                'class' => 'form-control',
                                'placeholder'=>'Part Type',
                                'maxlength'=>'50',
                                'required']) 
                            !!}
                        </div>
                        <div class="col-md-6">
                            <label><span>*</span><i>Authentic/Original</i></label>
                        </div>               
                    </div><br>
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::input('text','type2',$utilities->type2,[
                                'class' => 'form-control',
                                'placeholder'=>'Part Type',
                                'maxlength'=>'50',
                                'required']) 
                            !!}
                        </div>
                        <div class="col-md-6">
                            <label><span>*</span><i>Replacement/Low Quality</i></label>
                        </div>  
                    </div><br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('max', 'Max Value for Pieces') !!}<span>*</span>
                                {!! Form::input('text','max',$utilities->max,[
                                    'class' => 'form-control',
                                    'id' => 'max',
                                    'placeholder'=>'Max',
                                    'required']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('backlog', 'Max Days for Backlog') !!}<span>*</span>
                                {!! Form::input('text','backlog',$utilities->backlog,[
                                    'class' => 'form-control',
                                    'id' => 'backlog',
                                    'placeholder'=>'backlog',
                                    'required']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php $vatChecked = ($utilities->isVat ? 'checked':'')?>
                                {!! Form::label('hasVat', 'VAT / NON-VAT') !!}<span>*</span><br>
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="vat" name="hasVat" value="1" {{$vatChecked}}> VAT
                                    <input type="hidden" id="isVat" name="isVat" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('vat', 'VAT %') !!}<span>*</span>
                                {!! Form::input('text','vat',$utilities->vat,[
                                    'class' => 'form-control',
                                    'id' => 'vat',
                                    'placeholder'=>'VAT',
                                    'required']) 
                                !!}
                            </div>
                        </div>
                    </div>
                    {!! Form::label('warranty', 'Warranty Details') !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{--  {!! Form::label('hasWarranty', 'Warranty') !!}<span>*</span><br>  --}}
                                @php $warrantyChecked = ($utilities->isWarranty ? 'checked':'') @endphp
                                <label class="checkbox-inline">
                                    <input type="checkbox" class="warranty" name="hasWarranty" value="1" {{$warrantyChecked}}> Warranty
                                    <input type="hidden" id="isWarranty" name="isWarranty" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('year', 'Year') !!}<span>*</span>
                                {!! Form::input('text','year',$utilities->year,[
                                    'class' => 'form-control',
                                    'id' => 'year',
                                    'placeholder'=>'Year',
                                    'required']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('month', 'Month') !!}<span>*</span>
                                {!! Form::input('text','month',$utilities->month,[
                                    'class' => 'form-control',
                                    'id' => 'month',
                                    'placeholder'=>'Month',
                                    'required']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('day', 'Day') !!}<span>*</span>
                                {!! Form::input('text','day',$utilities->day,[
                                    'class' => 'form-control',
                                    'id' => 'day',
                                    'placeholder'=>'Day',
                                    'required']) 
                                !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.numeric.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#utility').addClass('active');
            if(!isVat){
                $('#vat').attr('readonly',true);
                $('#vat').val(0);
            }
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#util-pic')
                        .attr('src', e.target.result)
                        .width(180);
                    };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#max").inputmask({ 
            alias: "integer",
            prefix: '',
            suffix: ' pcs.',
            allowMinus: false,
            autoGroup: true,
            min: 1,
            max: 1000
        });
        $("#backlog").inputmask({ 
            alias: "integer",
            prefix: '',
            allowMinus: false,
            autoGroup: true,
            min: 1,
            max: 30
        });
        $("#vat").inputmask({ 
            alias: "integer",
            prefix: '',
            suffix: ' %',
            allowMinus: false,
            autoGroup: true,
            min: 1,
            max: 100
        });
        $("#year").inputmask({ 
            alias: "integer",
            prefix: '',
            allowMinus: false,
            autoGroup: true,
            min: 0,
            max: 2
        });
        $("#day").inputmask({ 
            alias: "integer",
            prefix: '',
            allowMinus: false,
            autoGroup: true,
            min: 0,
            max: 31
        });
        $("#month").inputmask({ 
            alias: "integer",
            prefix: '',
            allowMinus: false,
            autoGroup: true,
            min: 0,
            max: 12
        });
        $('.vat').change(function(){
            if($(this).prop('checked')){
                $('#vat').attr('readonly',false);
                $('#vat').val(vat);
                $('#isVat').val(1);
            }else{
                $('#vat').attr('readonly',true);
                $('#vat').val(0);
                $('#isVat').val(0);
            }
        });
        $('.warranty').change(function(){
            if($(this).prop('checked')){
                $('#year').attr('readonly',false);
                $('#month').attr('readonly',false);
                $('#day').attr('readonly',false);
                $('#year').val(wYear);
                $('#month').val(wMonth);
                $('#day').val(wDay);
                $('#isWarranty').val(1);
            }else{
                $('#year').attr('readonly',true);
                $('#month').attr('readonly',true);
                $('#day').attr('readonly',true);
                $('#year').val(0);
                $('#month').val(0);
                $('#day').val(0);
                $('#isWarranty').val(0);
            }
        });
    </script>
@endsection