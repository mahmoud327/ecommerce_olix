@foreach ($products as $product)
    
    <tr class='tr' data-id="{{ $product->id }}" data-s3="{{env('AWS_S3_URL')}}" >

        <td><input id="cat-box" type="checkbox" name="categories"  value="{{$product->id}}" class="box1" ></td>
        <td>{{ $loop->iteration + $skipped }}</td>
        <td>{{ $product->name }} </td>
        <td>{{optional($product->category)->name}}</td>  


        <td> <a href="{{route('users.index')}}" >{{optional($product->user)->mobile}} </a> </td>   
        <td> <a href="{{route('users.index')}}" >{{optional($product->user)->email}} </a> </td>    

        

        <td>{{ $product->phone[0] }}</td>   
        
        <td>{{ $product->price }}</td>
        <td>{{ $product->quantity}}</td>  

        <td>
            @if($product->organization()->exists())
                <a  href="#" data-product_id="{{ $product->organization_id }}" class="btn btn-primary btn-sm"
                    data-toggle="modal" data-target="#images{{$product->organization_id}}"><i
                    > {{ trans('lang.details') }}</i>
                </a>
                @include('web.admin.products_category.modal_organization',['product' => $product])
            @endif

        </td>
        <td>
            
        @if($product->status !="finished")

            <a href="{{ route('product.finished' , $product->id) }}"
            class="btn btn-danger btn-sm">
            {{ trans('lang.finsih') }}</a>   

        @else
        
            <a href="{{ route('product.approve' , $product->id) }}"
            class="btn btn-primary btn-sm">
            avaiable</a>   

        @endif
    
        
        </td>     

        <td>

            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                data-id="{{ $product->id }}"  data-toggle="modal"
                href="#exampleModal2" title="تعديل"> <i class="fa fa-eye"> </i> </a>

            @can('update_product_of_category')
                
                <a class="btn btn-outline-primary btn-sm"
                href=" {{ route('product.productofcatrgoryedit',$product->id)}}"><i class="fas fa-edit"></i>
                </a>
            @endcan

                

            @can('delete_product_of_category')

                <a  href="#" data-product_id="{{ $product->id }}" class="btn btn-danger  btn-sm "
                    data-toggle="modal" data-target="#delete_prodcut{{$product->id}}"> hide
                </a>    
            @endcan

            @include('web.admin.products_category.modal_delete',['product' => $product])

        </td>

        <td>{{ $product->created_at }} </td>


    </tr>


@endforeach
    <br>
    <br>
    <td colspan="3" align="center">
        {!! $products->links() !!}
    </td>
</tr>
