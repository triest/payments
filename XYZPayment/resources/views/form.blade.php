@extends('layout.welcome')

@section('content')


    <form method="post" action="{{route('postForm')}}">
        @csrf
        <div class="form-group">
            Форма оплаты
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif
        <input type="hidden" name="order_id" value="{{$order_id}}">
        <div class="form-group">
            <label for="sum">Сумма оплаты</label>
            <input type="text" name="sum" value="{{old('sum')}}">
        </div>
        <div class="form-group">
            <label for="name">Имя платильщика</label>
            <input type="text" name="name" value="{{old('name')}}">
        </div>
        <input class="btn btn-primary" type="submit" value="Заплатить">
    </form>

@endsection
