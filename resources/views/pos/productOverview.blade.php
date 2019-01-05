@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <a href="/pos/{{ $oProduct->iCategoryId }}" class="no-decoration">
                    <div class="pos-header-back text-center">
                        <h2>Back</h2>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="pos-category text-center">
                    <h1>{{ $oProduct->sName }}</h1>

                    <p>{{ $oProduct->sDescription }}</p>
                    <button class="btn btn-primary">Order</button>
                </div>
            </div>
        </div>
    </div>
@endsection