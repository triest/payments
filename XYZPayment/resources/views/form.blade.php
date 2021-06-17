@extends('layout.welcome')

@section('content')
    <form method="post" action="{{route('form')}}">
        @csrf
        <div class="form-group">
            <label for="sum">Сумма оплаты</label>
            <input type="text" name="sum">
        </div>
        <div class="form-group">
            <label for="name">Имя платильщика</label>
            <input type="text" name="name">
        </div>
        <input type="submit" value="Заплатить">
    </form>

@endsection
