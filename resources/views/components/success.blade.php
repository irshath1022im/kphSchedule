@if (session()->has('created'))

<div class="status-alert status-alert-success" role="alert">
   <span class="font-medium">  {{ session('created') }}</span>
</div>

@endif


@if (session()->has('message'))

<div class="status-alert status-alert-success" role="alert">
   <span class="font-medium">  {{ session('message') }}</span>
</div>

@endif



@if (session()->has('updated'))

<div class="status-alert status-alert-info" role="alert">
   <span class="font-medium">  {{ session('updated') }}</span>
</div>

@endif


@if (session()->has('Deleted'))

<div class="status-alert status-alert-error" role="alert">
   <span class="font-medium">  {{ session('Deleted') }}</span>
</div>

@endif


@if (session()->has('error'))

<div class="status-alert status-alert-error" role="alert">
   <span class="font-medium">  {{ session('error') }}</span>
</div>

@endif

