@extends('layouts.master')

@section('title')
    {{"Supplier"}}
@stop

@section('content')
    {!! Form::model($supplier , ['method' => 'patch', 'action' => ['SupplierController@update',$supplier->id]]) !!}
    <div class="col-md-7">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Supplier Information</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('name', 'Supplier') !!}<span>*</span>
                    {!! Form::input('text','name',null,[
                        'class' => 'form-control',
                        'placeholder'=>'Name',
                        'maxlength'=>'75',
                        'required']) 
                    !!}
                </div>
                <div class="form-group">
                    {!! Form::label('address', 'Address') !!}<span>*</span>
                    {!! Form::textarea('address',null,[
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
    <div class="col-md-5">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Contact Person(s)</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div id="persons" class="box-body">
                @foreach($supplier->person as $person)
                    <div id="person" class="form-group">
                        @if($loop->index!=0)
                            <button id="removePerson" type="button" class="btn btn-flat btn-danger btn-xs pull-right">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                        @endif
                        {!! Form::label('spName', 'Contact Person') !!}<span>*</span>
                        {!! Form::input('text','spName',$person->spName,[
                            'class' => 'form-control',
                            'name' => 'spName[]',
                            'placeholder'=>'Name',
                            'maxlength'=>'100',
                            'required'])
                        !!}
                    </div>
                @endforeach
            </div>
            <div class="box-footer">
                <button id="addPerson" type="button" class="btn btn-sm btn-primary pull-right">
                    <i class="glyphicon glyphicon-plus"></i>
                </button>
            </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Contact Number(s)</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div id="numbers" class="box-body">
                @foreach($supplier->number as $key=>$number)
                    <div id="number" class="form-group">
                        @if($loop->index!=0)
                            <button id="removeNumber" type="button" class="btn btn-flat btn-danger btn-xs pull-right">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                        @endif
                        {!! Form::label('scNo', 'Contact Number') !!}<span>*</span>
                        {!! Form::input('text','scNo',$number->scNo,[
                            'class' => 'form-control contact',
                            'id' => $key,
                            'name' => 'scNo[]',
                            'placeholder'=>'Number',
                            'required'])
                        !!}
                    </div>
                @endforeach
            </div>
            <div class="box-footer">
                <button id="addNumber" type="button" class="btn btn-sm btn-primary pull-right">
                    <i class="glyphicon glyphicon-plus"></i>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('script')
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/inputmask.phone.extensions.js')}}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{ URL::asset('js/supplier.js') }}"></script>
    <script>
        $(document).ready(function (){
            $('#mi').addClass('active');
            $('#mSupplier').addClass('active');
        });
        @foreach($supplier->number as $key=>$number)
            @if($number->scNo[4]=='9')
                $('#{{$key}}').inputmask("(+639)99-9999-999");
            @elseif($number->scNo[4]=='2')
                $('#{{$key}}').inputmask("(+639)999-9999");
            @endif
        @endforeach
    </script>
@stop