<div class="card-body">
    {{ Form::open(['route' => 'admin.supervisors.index', 'method' => 'get']) }}
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    {{ Form::text('keyword', old('keyword', request()->input('keyword')), ['class'=>'form-control', 'placeholder' => 'Search...']) }}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {{ Form::select('status', ['' => '---', '1' => 'Active', '0' => 'Inactive'], old('status', request()->input('status')), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {{ Form::select('sort_by', ['' => '---', 'name' => 'Name', 'id' => 'ID', 'created_at' => 'Created At'], old('sort_by', request()->input('sort_by')), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {{ Form::select('order_by', ['' => '---', 'asc' => 'Acending', 'desc' => 'Descending'], old('order_by', request()->input('order_by')), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {{ Form::select('limit_by', ['' => '---', '5' => '5', '10' => '10', '20' => '20', '50' => '50'], old('limit_by', request()->input('limit_by')), ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    {{ Form::submit('Search', ['class'=>'btn btn-link']) }}
                </div>
            </div>
        </div>
    {{ Form::close() }}
</div>
