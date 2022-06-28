<div class="modal fade" id="show_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{ $product->name }}  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
            </div>

            <div class="modal-body">


                @foreach ($product->medias()->get() as $images)
                    <div style="display:inline-block;"
                        class="text-center"> <a href="{{ env('AWS_S3_URL').'/'.$images->path }} " target="_blank"> <img src="{{env('AWS_S3_URL').'/'.$images->path}}" height="200px" width="200px"> </a>
                    </div>
                @endforeach
                <hr>


                <span> <strong>  Price :- </strong> </span>
                <span> {{ $product->price }} </span>

                <br>

                <span> <strong>  Description :- </strong> </span>
                <p> {{ $product->description }} </p>

                <br>

                <span> <strong>  Category :- </strong> </span>
                @if($product->category()->exists())
                  <p style="display:inline;"> 
                    
                    @if ($product->category->getParentsNames() !== $product->category->name)
                    <i class="fa fa-angle-double-left"> </i>

                        @foreach ($product->category->getParentsNames()->reverse() as $item)

                            @if ($item->parent_id == 0)

                            <span>{{ $item->name }}</span>
                            
                            <i class="fa fa-angle-double-left"> </i>
                            
                            
                            @else
                            <span>{{ $item->name }}</span>
                            <i class="fa fa-angle-double-left"> </i>

                            @endif
                        @endforeach  
                    @endif
                    
                    {{ $product->category->name }} 
                    
                    
                </p>
             @endif

                <br>

                
                <span style="display:inline; font-weight: bolder;">   Address :- </span>

                @if($product->city()->exists())

                   <p style="display:inline;"> {{optional( $product->city)->name }} - {{ optional( $product->city )->governorate->name }} </p>
                @endif


                    <br>

                <hr>
                    <span style="display:inline"> <strong>  Filters :- </strong> </span>

                    @foreach( $filters as $filter)
                        <div style="margin:20px"> 

                            <span style="color:#1435d5"> <strong>  {{ $filter->name }} - </strong> </span>
                            
                            @foreach( $filter->subFiltersRecurring as $sub_filter)


                                <span> {{$sub_filter->name}} </span>

                            @endforeach

                            <br>
                        </div>
                        
                    @endforeach


            </div>


        </div>
    </div>
</div>