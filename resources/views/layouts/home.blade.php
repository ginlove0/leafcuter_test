@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2>Users</h2>
{{--            divider--}}
            <hr>
{{--            break--}}
            <br>

{{--            table--}}
            <user-table></user-table>
        </div>
    </div>
</div>
@endsection
