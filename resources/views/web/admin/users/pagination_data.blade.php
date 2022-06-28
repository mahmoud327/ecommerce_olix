
@foreach($data as $row)
<tr>
    <td><input id="cat-box" type="checkbox" name="categories"  value="{{$row->id}}" class="box1" ></td>

    <td>{{ $loop->iteration + $skipped }}</td>
    <td>{{ $row->name }}</td>
    <td>{{ $row->email }}</td>
    <td>{{ $row->mobile }}</td>
    <td>{{ $row->points }}</td>
    <td>{{optional($row->products)->count() }}</td>
    <td>

        <a  href="#" data-user_id="{{$row->id}}"
            data-toggle="modal" data-target="#modaldemo9{{$row->id}}"><i
                class="btn btn-danger  btn-sm fas fa-trash-alt"  ></i>
        </a>

        <div class="modal" id="modaldemo9{{$row->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف السجل</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('users.destroy', $row->id) }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="id" id="id" value="{{ $row->name }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                </div>
                </form>
            </div>
        </div>

        <a href="{{url(route('users.products_of_user', $row->id))}}" @if( $row->products()->count() ) class="btn btn-primary btn-sm"  @else class="btn btn-danger btn-sm" @endif > P </a>

        <a  href="#" data-product_id=""  class="btn btn-primary btn-sm"
                data-toggle="modal" data-target="#send_notification{{$row->id}}"><i
            >send notification</i>
        </a>     
                
            <div class="modal fade" id="send_notification{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">send notification</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            
                        </div>
                        <div class="modal-body">

                            <form action="{{route('user.send_notification',$row->id)}}" method="post" enctype="multipart/form-data">
                                {{ csrf_field()}}
            
                                <div class="form-group"id="lnWrapper">
                                    <label>title arabic: <span class="tx-danger">*</span></label>
                                    <input class="form-control" data-parsley-class-handler="#lnWrapper"
                                    name="title_ar" placeholder="Arabic name"   >
                                </div>
                                <div class="form-group"id="lnWrapper">
                                    <label>title english: <span class="tx-danger">*</span></label>
                                    <input class="form-control" data-parsley-class-handler="#lnWrapper"
                                    name="title_en" placeholder="english title"   >

                                    
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">content arabic</label>
                                    <textarea type="text" class="form-control"  id="content_ar" name="content_ar" placeholder="content arabic" > </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">content english</label>
                                    <textarea type="text" class="form-control"  id="content_en" name="content_en" placeholder="content english" > </textarea>
                                </div>
                            
                            
            
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">تاكيد</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                </div>
                            </form>
                        </div>
            
                
                    
                    </div>
                </div>
            </div>

     



    </td>
    <td>{{ $row->created_at }} </td>
    </tr>
    @endforeach
    <br>
    <br>
    <td colspan="3" align="center">
        {!! $data->links() !!}
    </td>
</tr>
