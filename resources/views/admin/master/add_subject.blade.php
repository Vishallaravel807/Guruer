@extends('admin.layouts.layout')

@section('title','Subcategory Master Form')
@section('admin-content')

<style>
      .invalid-feedback {
    font-size: 100% !important;
}

 /* form#course_form span {
    width: 50%;
    padding-left: 11px;
} */
</style>

<div class="right_col" role="main">
    <div class="">


        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 customer-form-first">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Size Master Form </h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form action="{{ url('admin/addSubject') }}" id="course_form" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                        {!! csrf_field() !!}
                            <div class="form-group row">
                                <!-- First row -->

                                <div class="col-md-6">
                                    <label class="control-label">Category<span class="mandatory" style="color:red"> *</span></label>
                                    <select name="category_name" id="category_id" class="form-control" required>
                                        <option value="">Select Category</option>
                                        @foreach ($category as $value)
                                        <option value="{{ $value->category_id }}" {{ @$subject_detail->category_id == $value->category_id ? 'selected' : ''  }}>{{ $value->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">SubCategory<span class="mandatory" style="color:red"> *</span></label>

                                    <select name="subcategory_name" id="subcategory_id" class="form-control" required>
                                        <option value="">Select Subcategory</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name='subject_name' value="{{ @$subcategory_detail?$subcategory_detail->id:'' }}">
                                    <label class="control-label">SubCategory Name<span class="mandatory" style="color:red"> *</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Subject Name" name="subject_name" minlength="1" maxlength="50" value="{{ $subject_detail?$subject_detail->subject_name:'' }}" required>
                                    @if ($errors->has('subject_name'))
                                        <span class="" style="color:red">
                                            {{ $errors->first('subject_name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                                <div class="form-group row">
                                    <div class="col-md-12 go-back-btn mt-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn btn-primary" onclick="history.back()">Go Back</button>
                                    </div>
                                </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
window.addEventListener('load', function() {
    $("#course_form").validate({
        rules: {
            subcategory_name: { required: true },

            },
            messages: {
                subcategory_name: { required: "Subcategory Name name is required" },


            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                error.insertAfter(element);
            },

    });
});

</script>
<script>
    $(document).ready(function() {
        @if(Session::has('message'))
            toastr.success("{{ Session::get('message') }}");
        @endif

        @if(Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if(Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif

    });

    $('#category_id').on('change', function () {
        var categoryId = $(this).val(); // Get selected category ID

        // Clear previous subcategory options
        $('#subcategory_id').html('<option value="">Select Subcategory</option>');

        if (categoryId) {
            $.ajax({
                url: '{{ url('admin/getsubcategories') }}', // Laravel route to fetch subcategories
                type: 'Post',
                data: { category_id: categoryId,
                    '_token':'{{csrf_token()}}'
                 },
                success: function (response) {
                    // Populate subcategory dropdown
                    $.each(response.subcategories, function (index, subcategory) {
                        $('#subcategory_id').append(
                            '<option value="' + subcategory.id + '">' + subcategory.subcategory_name + '</option>'
                        );
                    });
                },
                error: function (xhr) {
                    console.error("Error fetching subcategories:", xhr);
                    alert('Unable to fetch subcategories. Please try again.');
                }
            });
        }

    });


</script>
@endsection
