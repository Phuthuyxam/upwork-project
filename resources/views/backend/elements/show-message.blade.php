@if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        <strong>Well done!</strong> You successfully read this important alert message.
    </div>
@endif

<div class="alert alert-danger mb-0" role="alert">
    <strong>Oh snap!</strong> Change a few things up and try submitting again.
</div>
