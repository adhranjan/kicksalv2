@extends('includes.adminDefault')
@section('header')
    <link href="{{ asset('assets/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('body_content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Ground Setup</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                @php($counter=0)
                {!! Form::open(['route'=>'setup_ground_post','method'=>'POST','novalidate','data-parsley-validate' ,'id'=>'ground_setup_form','class'=>'form-horizontal form-label-left']) !!}

                @forelse($grounds as $ground)

                        <div class="form-group">
                            <div class="col-xs-4">
                                <input type="text" value="{{ $ground->name }}" class="form-control" name="ground_names[]" placeholder="Time" />
                            </div>
                            <div class="col-xs-1">
                                @if($counter++ == 0)
                                <button type = "button" class="btn btn-default addButton" ><i class="fa fa-plus" ></i ></button >
                                @else
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="form-group">
                            <div class="col-xs-4">
                                <input type="text"  class="form-control" name="ground_names[]" placeholder="Ground Name" />
                            </div>
                            <div class="col-xs-1">
                                <?php if($counter == 0) { ?>
                                <button type = "button" class="btn btn-default addButton" ><i class="fa fa-plus" ></i ></button >
                                <?php }else { ?>
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                                <?php } ?>
                            </div>
                        </div>
                    @endforelse
                        <div class="form-group hide" id="bookTemplate">
                            <div class="col-xs-4">
                                <input type="text" class="form-control" name="ground_names[]" placeholder="Ground Name" />
                            </div>
                            <div class="col-xs-1">
                                <button type="button" class="btn btn-default removeButton"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="col-xs-4">
                            <button type="reset" class="btn btn-primary">Cancel</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            bookIndex = 0;
            $('#ground_setup_form')   // Add button click handler
                    .on('click', '.addButton', function() {
                        bookIndex++;
                        var $template = $('#bookTemplate'),
                                $clone    = $template
                                        .clone()
                                        .removeClass('hide')
                                        .removeAttr('id')
                                        .attr('data-book-index', bookIndex)
                                        .insertBefore($template);
                        // Update the name attributes
                        $clone
                                .find('[name="time"]').attr('name', 'times[]').end()
                                .find('[name="price"]').attr('name', 'prices[]').end();
                    })
                    .on('click', '.removeButton', function() {
                        var $row  = $(this).parents('.form-group'),
                                index = $row.attr('data-book-index');
                        // Remove fields
                        $row.remove();
                    });
        });
    </script>
@endsection
