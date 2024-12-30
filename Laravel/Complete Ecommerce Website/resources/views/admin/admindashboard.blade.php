@extends('admin.layouts.app')


@section('content')

<div class="w3-main row justify-content-center mt-5" style="margin-top: 100px;">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Admin Dashboard</div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success" style="color: green;">
                        {{ $message }}
                    </div>
                @else
                    <div class="alert alert-success">
                        You are logged in!
                    </div>       
                @endif                
            </div>
        </div>
    </div>    
</div>
    
@endsection