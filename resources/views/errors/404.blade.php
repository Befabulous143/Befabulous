<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page not found</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="" style="position: absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
        <div>
            <img class="w-80 opacity-70 ml-44"  src="{{ asset('images/microsite_logo.png') }}" alt="">
        </div>
        <div class="text-xl text-center opacity-50 ml-2">
            404 | page not found, 
            Sorry about that! We suggest you go back to our homepage.
        </div>
        <div class="mt-10 text-center">
            <a href="{{ route('login_page') }}" class="px-6 py-3  cursor-pointer text-white rounded-full shadow-md" style="background-color: rgb(170, 130, 100)">
                GO TO HOMEPAGE
            </a>
        </div>
    </div>
</body>
</html>