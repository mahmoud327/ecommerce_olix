<div class="modal" id="modaldemo9{{ $organization_service->id }}"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('lang.delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form action="{{ route('organization_services.destroy', $organization_service->id) }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
            </div>
            <div class="modal-body">
                {{trans('lang.message') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('lang.close')}}</button>
                <button type="submit" class="btn btn-danger">{{trans('lang.save')}}</button>
            </div>
            </form>
        </div>
    </div>
</div>