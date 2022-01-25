<div>
    <style>
        nav sg{
            height: 20px;
        }
        nav .hidden{
            display: block !important;
        }
    </style>
    <div class="container" style="padding:30px 0;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                All Products
                            </div>
                            <div class="col-md-6">
                                <a href="{{route('admin.addproduct')}}" class="btn btn-success pull-right">Add New Product</a>

                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        @if(Session::has('message'))
                            <div class="alert alert-success">
                                {{Session::get('message')}}
                            </div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Product Image</th>
                                <th>Stock</th>
                                <th>Product Price</th>
                                <th>Product Category</th>
                                <th>Product Date</th>
                                <th>Action</th>
                            </tr>
                            <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td>{{$product->id}}</td>
                                    <td>{{$product->name}}</td>
                                    <td><img src="{{asset('assets/images/products/'.$product->image)}}" width="60"/></td>
                                    <td>{{$product->stock_status}}</td>
                                    <td>{{$product->regular_price}}</td>
                                    <td>{{$product->category->name}}</td>
                                    <td>{{$product->created_at}}</td>
                                    <td>
                                        <a href="{{route('admin.editproduct' , ['product_slug' => $product->slug])}}" ><i class="fa fa-edit fa-2x"></i></a>
                                        <a href="#"  onclick="confirm('Are You Sure, you want delete this Product?') || event.stopImmediatePropagation()"  wire:click.prevent="deleteProduct('{{$product->id}}')" style="margin-left: 10px" ><i class="fa fa-times fa-2x text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            </thead>
                        </table>
                        {{$products->links("pagination::bootstrap-4")}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
