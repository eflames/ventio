<?php
/**
 * Created by PhpStorm.
 * User: eflames
 * Date: 19/02/2015
 * Time: 12:01 PM
 */?>



@if (count($errors) > 0)
    @section('after-scripts')
    @parent
        @foreach ($errors->all() as $error)
                <script> 
                    toastr.error("<?php echo $error; ?>", "Ha ocurrido un error", { progressBar: !0 });
                </script>
        @endforeach
    @endsection
@endif

@if(@$message)
    @section('after-scripts')
    @parent
        <script> 
            toastr.success("<?php echo $message; ?>", "Completado", { progressBar: !0 });
        </script>
    @endsection
@endif

@if(session()->has('message'))
    @section('after-scripts')
    @parent
        <script>
            toastr.success("<?php echo session()->pull('message'); ?>", "Completado", { progressBar: !0 });
        </script>
    @endsection
@endif

@if(session()->has('warning'))
    @section('after-scripts')
    @parent
        <script>
            toastr.warning("<?php echo session()->pull('warning'); ?>", "Aviso", { progressBar: !0 });
        </script>
    @endsection
@endif

@if(session()->has('info'))
    @section('after-scripts')
    @parent
        <script>
            toastr.info("<?php echo session()->pull('info'); ?>", "Aviso", { progressBar: !0 });
        </script>
    @endsection
@endif

@if(session()->has('error'))
    @section('after-scripts')
    @parent
        <script>
            toastr.error("<?php echo session()->pull('error'); ?>", "Ha ocurrido un error", { progressBar: !0 });
        </script>
    @endsection
@endif




<div id="messageBar" class="alert alert-icon-left alert-success alert-dismissible mb-2 alert-arrow-left"
     role="alert" style="display: none">
    <span class="alert-icon"><i class="fa fa-check"></i></span>
    <button type="button" class="close" onclick="hideAlert()">
        <span aria-hidden="true">×</span>
    </button>
    <span id="messageBarText"></span>
</div>
<div id="errorBar" class="alert alert-icon-left alert-danger mb-2 alert-arrow-left"
     role="alert"style="display: none">
    <span class="alert-icon"><i class="fa fa-warning"></i></span>
    <button type="button" class="close" onclick="hideErrorAlert()">
        <span aria-hidden="true">×</span>
    </button>
    <span id="errorBarText"></span>
</div>