@extends('layouts.backend.masterLay')
@section('title', 'Reviews')
@section('content')

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Customer Reviews</h3>
                <button class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i> Add Review</button>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="" id=""></th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox" name="" id=""></td>
                            <td><img src="{{ asset('assets/uploads/') }}" alt=""></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm"><i class="fa-solid fa-edit"></i> Edit</a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection