    <!-- edit -->
    <div class="modal fade" id="exampleModal2{{$city->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">edit city</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('cities.update', $city->id )}}" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name_en" placeholder="city name in English" value={{ $city->getTranslation('name', 'en') }}>
                        </div>
    
    
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name_ar" placeholder="city name in Arabic" value={{ $city->getTranslation('name', 'ar') }}>
                        </div>

                        @inject('governorates', 'App\Models\Governorate')
                        <div class="form-group">
                            <select name="governorate_id" class="form-control">
                                <option value="" disabled selected>Select a governorate</option>
                                @foreach ($governorates->all() as $governorate)
                                    
                                    <option value="{{$governorate->id}}" @if( $city->governorate->id == $governorate->id) selected @endif> {{$governorate->name}} </option>
                                @endforeach

                            </select>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تاكيد</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
                </form>
            </div>
        </div>
    </div>