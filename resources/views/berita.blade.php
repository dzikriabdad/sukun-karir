@extends ('layouts.main')

@section('title', 'Berita - Sukun Karir')

@section('content')
<div class="flex flex-col gap-y-10 lg:flex-row justify-center mt-20 bg-white py-10">
      
      <div class="flex justify-center px-4 w-full lg:w-[800px]">
        <div class="w-full bg-white rounded-2xl shadow-md border p-6 md:p-10">
          
          <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 uppercase">
            {{ $lowongan->title }}
@endsection