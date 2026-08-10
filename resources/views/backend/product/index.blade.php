@extends('layouts.backend.masterLay')
@section('title', 'Products')

@section('content')
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Products</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>
                                        <img src="{{ asset('image/product/' . $product->image) }}" alt="{{ $product->title }}"
                                            class="img-fluid" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ $product->discounted_price }}</td>
                                    <td>
                                        <a href="{{ route('admin.product.edit', $product->id) }}" title="Edit"
                                            class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('admin.product.destroy', $product->id) }}" class="btn btn-danger"
                                            title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection