@extends('proadmin::layouts.app')

@section('content')
<main class="flex items-center justify-center h-screen">
    <div class="bg-white rounded-xl w-11/12 lg:w-1/2 py-10 md:py-16 flex flex-col items-center justify-center">

        <div class="flex items-center gap-4 md:gap-5 mb-10">
            <a href="/">
                <img src="/vendor/proadmin/images/logo.svg" alt="Logo" class="w-16 md:w-26">
            </a>
            <div class="bg-background rounded-lg text-base md:text-xl font-bold px-4 lg:px-6 py-2 lg:py-4">Admin Panel</div>
        </div>

        <div class="text-2xl font-bold">Welcome back!</div>
        <div class="text-base text-grey mb-6">Log in to your Proadmin account</div>

        <form action="{{ route('admin-sign-in') }}" method="POST" class="flex flex-col gap-3 w-full px-5 md:px-32">

            <input type="text" class="w-full border border-stroke rounded-sm px-4 py-2 text-sm xl:text-base ring-0 focus:ring-0 outline-0 focus:outline-none" name="email" placeholder="E-mail" required autofocus>

            <input type="password" class="w-full border border-stroke rounded-sm px-4 py-2 text-sm xl:text-base ring-0 focus:ring-0 outline-0 focus:outline-none" name="password" placeholder="Password" required>

            <div class="flex items-center mb-3">
                <input name="remember" id="remember" type="checkbox" class="hidden peer">
                <label for="remember" class="cursor-pointer peer-checked:[&_svg]:scale-100 text-xs md:text-sm [&_svg]:scale-0 peer-checked:[&_.custom-checkbox]:border-primary peer-checked:[&_.custom-checkbox]:bg-primary select-none flex items-center space-x-2">
                    <span class="flex items-center justify-center w-5 h-5 border border-stroke rounded custom-checkbox duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3 h-3 text-white duration-300 ease-out">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </span>
                    <span class="text-sm xl:text-base text-grey">Remember Me</span>
                </label>
            </div>

            <button type="submit" class="bg-primary text-white rounded-sm px-4 py-2 text-sm xl:text-base w-full font-bold cursor-pointer hover:bg-hover duration-300">
                Login
            </button>

            @if (isset($_COOKIE['password']) && $_COOKIE['password'] == 'incorrect')
                <div class="text-red-500 text-sm xl:text-base text-center mt-2">
                    Login or password incorrect
                </div>
                <script>
                    delete_cookie("password");
                </script>
            @endif
            @csrf
        </form>
    </div>

    <a href="https://probytech.com.ua/" target="_blank" class="absolute bottom-10 right-1/2 translate-x-1/2">
        <img src="/vendor/proadmin/images/probytech.svg" alt="" class="w-32 md:w-40">
    </a>

</main>
@endsection
