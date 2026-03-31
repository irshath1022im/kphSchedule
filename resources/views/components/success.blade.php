@if (session()->has('created'))

<div class="p-4 mb-4 text-sm text-green-100 bg-green-600 rounded-lg" role="alert">
   <span class="font-medium">  {{ session('created') }}</span>
</div>

@endif


@if (session()->has('message'))

<div class="p-4 mb-4 text-sm text-green-100 bg-green-600 rounded-lg" role="alert">
   <span class="font-medium">  {{ session('message') }}</span>
</div>

@endif



@if (session()->has('updated'))

<div class="p-4 mb-4 text-sm text-cyan-600-700 bg-cyan-100 rounded-lg" role="alert">
   <span class="font-medium">  {{ session('updated') }}</span>
</div>

@endif


@if (session()->has('Deleted'))

<div class="p-4 mb-4 text-sm text-cyan-600-700 bg-red-100 rounded-lg" role="alert">
   <span class="font-medium">  {{ session('Deleted') }}</span>
</div>

@endif


@if (session()->has('error'))

<div class="p-4 mb-4 text-sm text-cyan-600-700 bg-red-100 rounded-lg" role="alert">
   <span class="font-medium">  {{ session('error') }}</span>
</div>

@endif

